<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{url('/')}}" class="app-brand-link">
            <div class="brand-logo">
                <img src="{{ asset('assets/img/backgrounds/VCWULogo-removebg-preview.png') }}" width="90"
                    alt="brand-logo">
            </div>
            <span class="demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)
        {{-- adding active and open class if child is active --}}
        {{-- menu headers --}}
        @if (isset($menu->menuHeader))
        @php
        $visibleHeader = true;

        if (isset($menu->roles)) {
        $userRole = Auth::User()->usertype;
        $visibleHeader = in_array($userRole, $menu->roles);
        }
        @endphp

        @if ($visibleHeader)
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
        </li>
        @endif
        @else
        {{-- active menu method --}}
        @php
        $activeClass = null;
        $currentRouteName = Route::currentRouteName();

        if ($currentRouteName === $menu->slug) {
        $activeClass = 'active';
        } elseif (isset($menu->submenu)) {
        if (gettype($menu->slug) === 'array') {
        foreach($menu->slug as $slug){
        if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
        $activeClass = 'active open';
        }
        }
        } else {
        if (
        str_contains($currentRouteName,$menu->slug) and
        strpos($currentRouteName,$menu->slug) === 0
        ) {
        $activeClass = 'active open';
        }
        }
        }

        $visible = true;

        if (isset($menu->roles)) {
        $userRole = Auth::User()->usertype;
        $visible = in_array($userRole, $menu->roles);
        }
        @endphp

        @if ($visible)
        <li class="menu-item {{$activeClass}}">
            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target)
                and !empty($menu->target)) target="_blank" @endif>
                @isset($menu->icon)
                <i class="{{ $menu->icon }}"></i>
                @endisset
                <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                @isset($menu->badge)
                <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}
                </div>
                @endisset
            </a>
            {{-- submenu --}}
            @isset($menu->submenu)
            @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
            @endisset
        </li>
        @endif
        @endif
        @endforeach
    </ul>
</aside>