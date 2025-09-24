<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />

    <title>@yield('title', 'MyExpenseVn')</title>
    <meta name="description" content="@yield('meta_description', 'Quản lý chi tiêu, thống kê và báo cáo tài chính cá nhân — MyExpenseVn')" />
    <meta name="keywords" content="@yield('meta_keywords', 'quản lý chi tiêu, finance, personal finance, myexpense')" />
    <meta name="author" content="@yield('meta_author', 'MyExpenseVn')" />
    <meta name="robots" content="@yield('meta_robots', 'index,follow')" />
    <link rel="canonical" href="@yield('canonical', url()->current())" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon-32x32.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicon-16x16.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="@yield('theme_color', '#06b6d4')" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="color-scheme" content="light dark">

    <meta property="og:locale" content="@yield('og_locale', 'vi_VN')" />
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:title" content="@yield('og_title', config('app.name', 'MyExpenseVn'))" />
    <meta property="og:description" content="@yield('og_description', 'Quản lý chi tiêu & thống kê tài chính cá nhân')" />
    <meta property="og:url" content="@yield('og_url', url()->current())" />
    <meta property="og:site_name" content="@yield('og_site_name', config('app.name', 'MyExpenseVn'))" />
    <meta property="og:image:alt" content="@yield('og_image_alt', 'MyExpenseVn')" />

    <meta name="referrer" content="no-referrer-when-downgrade" />
    @include('client.layouts.partials.css')
</head>

<body class="wrapper">
    <header>
        @include('client.layouts.partials.header')
    </header>
    <div class="w-full px-5 md:px-20 mx-auto mt-20 overflow-x-hidden">
        @include('client.components.elements.breadcrumb', ['items' => $breadcrumb ?? []])
        @yield('content')
        <div id="preloader"
            class="fixed inset-0 z-50 bg-white flex items-center justify-center transition-opacity duration-300">
            <div class="w-12 h-12 border-4 border-dashed border-teal-500 rounded-full animate-spin"></div>
        </div>
    </div>
    @include('client.components.elements.modal-ai')
    <footer>
        @include('client.layouts.partials.footer')
    </footer>
    <script>
        $(window).on('load', function() {
            $('#preloader').fadeOut(200);
        });
    </script>
    @include('client.layouts.partials.script')
</body>

</html>
