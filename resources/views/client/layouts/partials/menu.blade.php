<nav class="px-5 py-4 flex items-center justify-between shadow-md fixed top-0 left-0 w-full bg-white z-50">
    <a href="{{ route('client.index') }}" class="relative inline-block">
        <h1
            class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-500 to-cyan-400 flex items-center gap-x-2">
            <i class="fa-solid fa-wallet"></i> MyExpenseVn
        </h1>
        <span class="absolute left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-cyan-400"></span>
    </a>

    <ul class="hidden md:flex space-x-6">
        @foreach ([['/', 'Trang chủ'], ['/about', 'Giới thiệu'], ['/contact', 'Liên hệ']] as [$url, $label])
            @php
                $isActive = request()->is(trim($url, '/')) || (request()->is('/') && $url === '/');
            @endphp
            <li>
                <a href="{{ $url }}"
                    class="relative group inline-block transition-colors
                  {{ $isActive ? 'text-teal-500 font-semibold' : 'text-gray-800 hover:text-teal-500' }}">
                    {{ $label }}
                    <span
                        class="absolute left-0 bottom-0
                       {{ $isActive ? 'w-full' : 'w-0 group-hover:w-full' }}
                       h-[2px] bg-teal-500 transition-all"></span>
                </a>
            </li>
        @endforeach

        @auth
            @foreach (App\Helpers\Helper::getMenuItems() as $item)
                @php
                    $url = route($item['route']);
                    $routePath = trim(parse_url($url, PHP_URL_PATH), '/');
                    $isActive = request()->is($routePath);
                @endphp

                <li>
                    <a href="{{ $url }}"
                        class="relative group inline-block transition-colors
                    {{ $isActive ? 'text-teal-500 font-semibold' : 'text-gray-800 hover:text-teal-500' }}">
                        {{ $item['label'] }}
                        <span
                            class="absolute left-0 bottom-0
                        {{ $isActive ? 'w-full' : 'w-0 group-hover:w-full' }}
                        h-[2px] bg-teal-500 transition-all"></span>
                    </a>
                </li>
            @endforeach
        @endauth

    </ul>

    @if (!Auth::user())
        <div class="space-x-3 hidden md:flex">
            <a href="{{ route('auth.client.showFormLogin') }}"
                class="py-1 px-3 border border-teal-500 text-teal-500 rounded-md hover:bg-teal-500 hover:text-white transition-colors">Đăng
                nhập</a>
            <a href="{{ route('auth.client.showFormRegister') }}"
                class="py-1 px-3 bg-teal-500 text-white rounded-md hover:bg-teal-600 transition-colors">Đăng ký</a>
        </div>
    @else
        <div class="hidden md:flex space-x-3">
            <a href="{{ route('client.profile') }}"
                class="py-1 px-3 bg-teal-500 text-white rounded-md hover:bg-teal-600 transition-colors">Hồ sơ của
                bạn</a>
            <form action="/logout" method="POST">
                @csrf
                <button
                    class="py-1 px-3 border border-red-500 text-red-500 rounded-md hover:bg-red-500 hover:text-white transition-colors">Đăng
                    xuất</button>
            </form>
        </div>
    @endif

    <button id="mobile-menu-button" class="md:hidden focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</nav>
