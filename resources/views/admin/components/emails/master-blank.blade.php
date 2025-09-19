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
            background-color: #f9fafb;
            color: #1f2937;
            padding: 24px;
            line-height: 1.6;
        }

        .email-container {
            background-color: #ffffff;
            max-width: 640px;
            margin: auto;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(20, 184, 166, 0.1);
            border: 1px solid #e5e7eb;
        }

        .email-header {
            background: linear-gradient(90deg, #14b8a6, #06b6d4);
            padding: 20px;
            text-align: center;
        }

        .email-header img {
            max-height: 50px;
        }

        .email-body {
            padding: 40px 32px;
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
            color: white !important;
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

        .highlight-box {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 12px 16px;
            font-weight: 600;
            font-size: 18px;
            margin: 16px 0;
            border-radius: 8px;
            text-align: center;
            color: #065f46;
        }

        .otp-box {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 8px;
            text-align: center;
            color: #111827;
            background: #f9fafb;
            border: 2px dashed #14b8a6;
            padding: 16px;
            border-radius: 12px;
            margin: 24px 0;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .email-footer {
            background-color: #f9fafb;
            padding: 20px;
            font-size: 13px;
            color: #6b7280;
            text-align: center;
            line-height: 1.4;
            border-top: 1px solid #e5e7eb;
        }

        @media only screen and (max-width: 600px) {
            .email-body {
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
        <div class="email-header">
            <img src="{{ asset('images/logo.png') }}" alt="MyExpenseVn Logo">
        </div>
        <div class="email-body">
            <h2>@yield('heading', 'Thông báo từ MyExpenseVn')</h2>
            @yield('content')
        </div>
        <div class="email-footer">
            © {{ date('Y') }} MyExpenseVn. All rights reserved.<br>
            Đây là email tự động, vui lòng không trả lời.
        </div>
    </div>
</body>

</html>
