<li class="nav-item">
    <a class="nav-link <?= (in_array(ArshWell\Monolith\Session::panel('box.tab.actions'), [NULL, 'daily']) ? 'active' : '') ?>" data-toggle="tab" href="#actions-daily">
        Daily
    </a>
</li>
<li class="nav-item">
    <a class="nav-link <?= (ArshWell\Monolith\Session::panel('box.tab.actions') == 'frequently' ? 'active' : '') ?>" data-toggle="tab" href="#actions-frequently">
        Frequently
    </a>
</li>
<li class="nav-item">
    <a class="nav-link <?= (ArshWell\Monolith\Session::panel('box.tab.actions') == 'rarely' ? 'active' : '') ?>" data-toggle="tab" href="#actions-rarely">
        Rarely
    </a>
</li>
<li class="nav-item">
    <a class="nav-link <?= (ArshWell\Monolith\Session::panel('box.tab.actions') == 'build' ? 'active' : '') ?>" data-toggle="tab" href="#actions-build">
        Build
    </a>
</li>
