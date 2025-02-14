<?php

namespace Arshwell\Monolith\Module\Syntax\Frontend\Field;

final class HTML
{
    /**
     * (array|string) $notes
    */
    static function icon ($icon = NULL) {
        return $icon;
    }

    static function label (string $label): string {
        return $label;
    }

    static function type (string $name): string {
        return $name;
    }

    /**
     * (closure|array) $notes
    */
    static function notes ($notes) {
        return $notes;
    }

    static function class (string $class): string {
        return $class;
    }

    /**
     * (closure|bool) $disabled
    */
    static function disabled ($disabled) {
        return $disabled;
    }

    /**
     * (closure|bool) $readonly
    */
    static function readonly ($readonly) {
        return $readonly;
    }

    static function hidden (bool $hidden): bool {
        return $hidden;
    }

    static function checked (bool $checked): bool {
        return $checked;
    }

    /**
     * (closure|string) $placeholder
    */
    static function placeholder ($placeholder) {
        return $placeholder;
    }

    static function multiple (bool $multiple): bool {
        return $multiple;
    }

    static function value ($value = NULL) {
        return $value;
    }

    /**
     * (closure|array) $notes
    */
    static function values ($values) {
        return $values;
    }

    static function required (bool $required): bool {
        return $required;
    }

    static function overwrite (bool $overwrite): bool {
        return $overwrite;
    }

    /**
     * (closure|string) $preview
    */
    static function preview ($preview) {
        return $preview;
    }
}
