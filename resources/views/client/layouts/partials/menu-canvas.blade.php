<div id="offcanvas-overlay"
    class="fixed inset-0 bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity z-40"></div>
<aside id="offcanvas-menu"
    class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg transform translate-x-full transition-transform duration-300 z-50 flex flex-col space-y-2 p-4">
    <button id="close-offcanvas" class="self-end text-gray-600 hover:text-black mb-2 text-lg md:text-xl">✕</button>

    @php
        $publicLinks = [['/', 'Trang chủ'], ['/introduce', 'Giới thiệu'], ['/contact', 'Liên hệ']];
    @endphp

    @foreach ($publicLinks as [$url, $label])
        @php
            $isActive = request()->is(trim($url, '/')) || (request()->is('/') && $url === '/');
        @endphp
        <a href="{{ $url }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors
          {{ $isActive ? 'bg-teal-100 text-teal-700 font-semibold' : 'hover:bg-teal-100 text-gray-700' }}">
            {{ $label }}
        </a>
    @endforeach

    @auth
        @foreach (App\Helpers\Helper::getMenuItems() as $item)
            @php
                $url = route($item['route']);
                $routePath = trim(parse_url($url, PHP_URL_PATH), '/');
                $isActive = request()->is($routePath);
            @endphp
            <a href="{{ $url }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors
              {{ $isActive ? 'bg-teal-100 text-teal-700 font-semibold' : 'hover:bg-teal-100 text-gray-700' }}">
                {{ $label }}
            </a>
        @endforeach

        <a href="/profile" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-teal-100 text-gray-700">
            Hồ sơ của bạn
        </a>
        <form action="/logout" method="POST" class="w-full">@csrf
            <button class="flex items-center w-full gap-3 px-3 py-2 rounded-md hover:bg-red-100 text-red-500">Đăng
                xuất</button>
        </form>
    @else
        <a href="{{ route('auth.client.showFormLogin') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-teal-100 text-gray-700">Đăng nhập</a>
        <a href="{{ route('auth.client.showFormRegister') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-teal-100 text-gray-700">Đăng ký</a>
    @endauth
</aside>
