<div class="sidebar-header relative p-6 flex items-center justify-between">
    <div>
        <h3 class="font-semibold text-lg">
            <span id="sidebar-header-logo">MY EXPENSE VN</span>
        </h3>
        <p class="sidebar-role-label text-sm opacity-80">Dành cho Quản trị viên</p>
    </div>

    <button id="closeSidebar"
        class="md:hidden w-10 h-10 rounded-full bg-white text-teal-600 flex items-center justify-center shadow-md hover:bg-gray-200 transition">
        <i class="fa-solid fa-xmark text-lg"></i>
    </button>
</div>

@php
    $adminMenus = [
        [
            'route' => 'admin.dashboard',
            'label' => 'Thống Kê',
            'icon' => 'fa-chart-line',
        ],
        [
            'label' => 'Người Dùng',
            'icon' => 'fa-users',
            'submenu' => [
                ['route' => 'admin.users.index', 'label' => 'Danh Sách', 'icon' => 'fa-list'],
            ],
        ],
        // [
        //     'route' => 'admin.accounts.index',
        //     'label' => 'Tài Khoản',
        //     'icon' => 'fa-wallet',
        // ],
        // [
        //     'route' => 'admin.reports.index',
        //     'label' => 'Báo Cáo',
        //     'icon' => 'fa-file-alt',
        // ],
        // [
        //     'route' => 'admin.settings.index',
        //     'label' => 'Cài Đặt',
        //     'icon' => 'fa-cog',
        // ],
    ];
@endphp

<ul class="components" id="sidebar-menu">
    @foreach ($adminMenus as $menu)
        @php
            $menuRoute = $menu['route'] ?? null;
            $isActive = $menuRoute
                ? Route::is($menuRoute) || Route::is(Str::before($menuRoute, '.index') . '.*')
                : false;
    
            $subActive = false;
            if (!empty($menu['submenu'])) {
                foreach ($menu['submenu'] as $sub) {
                    if (Route::is($sub['route'])) {
                        $subActive = true;
                        break;
                    }
                }
            }
        @endphp

        <li class="{{ !empty($menu['submenu']) ? 'has-submenu' : '' }} {{ $isActive ? 'active' : '' }}">
            <a href="{{ $menuRoute ? route($menuRoute) : '#' }}"
                class="sidebar-link {{ !empty($menu['submenu']) ? 'dropdown-toggle' : '' }}">
                <span>
                    <i class="fa-solid {{ $menu['icon'] }}"></i>
                    {{ $menu['label'] }}
                </span>
                @if (!empty($menu['submenu']))
                    <i class="fa-solid fa-chevron-down caret"></i>
                @endif
            </a>

            @if (!empty($menu['submenu']))
                <ul class="submenu {{ $subActive ? 'show' : '' }}">
                    @foreach ($menu['submenu'] as $sub)
                        @php
                            $isSubActive = Route::is($sub['route']);
                        @endphp
                        <li class="{{ $isSubActive ? 'active' : '' }}">
                            <a href="{{ route($sub['route']) }}" class="sidebar-link">
                                <i class="fa-solid {{ $sub['icon'] }}"></i>
                                {{ $sub['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
