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
        <nav class="navbar flex justify-between items-center">
            <button type="button" id="sidebarToggle" class="navbar-btn">
                <span>☰ Menu</span>
            </button>
            <h2 class="ml-4">{{ Auth::user()->name ?? 'Name' }}</h2>
        </nav>

        <div class="line"></div>

        <div class="flex justify-center items-center m-auto">
            @yield('content')
        </div>
    </div>

    @include('admin.layouts.partials.script')
</body>

</html>
