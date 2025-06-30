<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyExpenseVn')</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f0fdf4;
            color: #1f2937;
            padding: 24px;
        }

        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(20, 184, 166, 0.1);
            border-top: 4px solid #14b8a6;
        }

        h2 {
            color: #0f172a;
            margin-bottom: 16px;
        }

        p {
            line-height: 1.6;
        }

        .btn {
            background-color: #14b8a6;
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            margin-top: 20px;
            font-weight: 600;
        }

        .btn:hover {
            background-color: #0d9488;
        }

        .email-footer {
            margin-top: 40px;
            font-size: 13px;
            color: #6b7280;
            text-align: center;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="email-container">
        <h2>@yield('heading', 'Thông báo từ MyExpenseVn')</h2>
        @yield('content')
    </div>
    <div class="email-footer">
        © {{ date('Y') }} MyExpenseVn. All rights reserved.
    </div>
</body>

</html>
