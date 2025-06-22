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
    <div class="w-full flex justify-center items-center">
        @yield('content')
    </div>
    @include('admin.layouts.partials.script')
</body>

</html>
