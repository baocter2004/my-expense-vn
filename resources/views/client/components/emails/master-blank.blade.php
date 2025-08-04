<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyExpenseVn')</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f0fdf4;
            color: #1f2937;
            padding: 24px;
            line-height: 1.6;
        }

        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 40px 32px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(20, 184, 166, 0.08);
            border-top: 6px solid #14b8a6;
            transition: all 0.3s ease;
        }

        h2 {
            color: #0f172a;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            color: #374151;
            font-size: 16px;
            margin-bottom: 16px;
        }

        .btn {
            background: linear-gradient(to right, #14b8a6, #06b6d4);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 9999px;
            display: inline-block;
            font-weight: 600;
            font-size: 15px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background: linear-gradient(to right, #0d9488, #0891b2);
            transform: scale(1.03);
        }

        .email-footer {
            margin-top: 40px;
            font-size: 13px;
            color: #6b7280;
            text-align: center;
            line-height: 1.4;
        }

        @media only screen and (max-width: 600px) {
            .email-container {
                padding: 28px 20px;
            }

            h2 {
                font-size: 20px;
            }

            .btn {
                width: 100%;
                text-align: center;
                padding: 12px;
            }
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
