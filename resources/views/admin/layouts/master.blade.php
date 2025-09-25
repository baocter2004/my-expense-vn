<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyExpenseVn')</title>

    @include('admin.layouts.partials.css')
</head>

<body class="wrapper">

    <nav id="sidebar">
        @include('admin.layouts.partials.sidebar')
    </nav>

    <div id="content">

        @include('admin.layouts.partials.nav-header')

        <div class="line"></div>

        <div class="w-full">
            @include('admin.layouts.partials.bread-crumb')
            @yield('content')
        </div>
    </div>

    <button id="scrollToTop"
        class="fixed z-[99999] bottom-6 right-6 p-3 w-[50px] h-[50px] rounded-full bg-teal-500 text-white shadow-lg hover:bg-teal-600 transition opacity-0 pointer-events-none">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    @include('admin.layouts.partials.script')
</body>

</html>
