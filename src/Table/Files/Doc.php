<?php

namespace Arsavinel\Arshwell\Table\Files;

use Arsavinel\Arshwell\Table\TableSegment;
use Arsavinel\Arshwell\Folder;
use Arsavinel\Arshwell\File;
use Arsavinel\Arshwell\Web;
use Arsavinel\Arshwell\ENV;

final class Doc implements TableSegment {
    private $class;
    private $id_table = NULL;
    private $filekey;
    private $folder;
    private $paths = array(); // filepaths
    private $urls = NULL; // if no files in uploads/

    function __construct (string $class, int $id_table = NULL, string $filekey) {
        $this->class    = $class;
        $this->id_table = $id_table;
        $this->filekey  = $filekey;
        $this->folder   = (Folder::encode($class) .'/'. $id_table .'/'. $filekey);

        $files = File::tree(ENV::path('uploads') . 'files/'. $this->folder, NULL, false, true);

        if ($files) {
            $site = Web::site();

            foreach ((($this->class)::TRANSLATOR)::LANGUAGES as $language) {
                if (!isset($files[$language])) {
                    $first_lang = array_key_first($files);

                    if (Folder::copy(ENV::path('uploads') . 'files/'. $this->folder .'/'. $first_lang, ENV::path('uploads') . 'files/'. $this->folder .'/'. $language)) {
                        $files[$language] = $files[$first_lang];
                    }
                }

                if (!empty($files[$language])) {
                    $this->paths[$language] = (ENV::path('uploads') . 'files/' . $this->folder .'/'. $language .'/'. array_values($files[$language])[0]);

                    $this->urls[$language] = ($site .'uploads/files/'. $this->folder .'/'. $language .'/'. array_values($files[$language])[0]);
                }
            }
        }
    }

    function class (): string {
        return $this->class;
    }

    function id (): ?int {
        return $this->id_table;
    }

    function key (): string {
        return $this->filekey;
    }

    function isTranslated (): bool {
        return true;
    }

    function value (string $lang = NULL): ?string {
        if ($lang == NULL) {
            $lang = (($this->class)::TRANSLATOR)::get();
        }

        return file_get_contents($this->paths[$lang]) ?? NULL;
    }

    function url (string $lang = NULL): ?string {
        return $this->urls[($lang ?: (($this->class)::TRANSLATOR)::get())];
    }

    function __call (string $method, array $args) {
        return $this->{$method}; // class, id_table, filekey, folder
    }

    function rename (string $name, string $language = NULL): void {
        $language = ($language ?: (($this->class)::TRANSLATOR)::default());

        $file_ext = ('.'. File::extension(File::rFirst(ENV::path('uploads') . 'files/'. $this->folder .'/'. $language)));

        foreach (File::rFolder(ENV::path('uploads') . 'files/'. $this->folder .'/'. $language) as $file) {
            rename($file, dirname($file) .'/'. $name . $file_ext);
        }
    }

    function update (array $data, string $language = NULL): void {
        $language = ($language ?: (($this->class)::TRANSLATOR)::default());

        $dirname = ENV::path('uploads') . 'files/'.$this->folder.'/'.$language;

        Folder::remove($dirname);
        mkdir($dirname, 0755, true);

        if (isset($data['content'])) {
            file_put_contents(
                ENV::path('uploads') . 'files/'.$this->folder.'/'.$language.'/'.$data['name'],
                $data['content'],
                LOCK_EX
            );
        }
        else {
            copy($data['tmp_name'], ENV::path('uploads') . 'files/'.$this->folder.'/'.$language.'/'.$data['name']);
        }

        $this->urls[$language] = Web::site().'uploads/files/'.$this->folder.'/'.$language.'/'.$data['name'];
    }

    function delete (string $language = NULL): bool {
        Folder::remove(ENV::path('uploads') . 'files/'. $this->folder .'/'. ($language ?? ''));

        Folder::removeEmpty(ENV::path('uploads') . 'files/'. dirname($this->folder));

        if (!$language) {
            $this->urls = NULL;
        }

        return true;
    }
}
