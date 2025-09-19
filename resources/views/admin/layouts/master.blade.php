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
        <nav class="navbar flex justify-between items-center px-4 py-3 bg-white shadow-md">
            <button type="button" id="sidebarToggle"
                class="navbar-btn flex items-center gap-2 bg-teal-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-teal-600 transition">
                <i class="fa-solid fa-bars text-lg"></i>
                <span class="hidden sm:inline">Menu</span>
            </button>
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold shadow-inner">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->first_name, 0, 1)) }}
                </div>
                <h2 class="text-slate-700 font-medium">
                    {{ Auth::guard('admin')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name ?? 'Name' }}
                </h2>
            </div>
        </nav>

        <div class="line"></div>

        <div class="w-full">
            @yield('content')
        </div>
    </div>

    @include('admin.layouts.partials.script')
</body>

</html>
