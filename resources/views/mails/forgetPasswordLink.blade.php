<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>[CellphoneS] Đổi mới mật khẩu</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .main {
            background: linear-gradient(rgb(241, 50, 55), rgb(248, 207, 214));
            width: 100%;
            min-height: 100vh;
        }

        .main .box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            background-color: #ffffff;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
            padding: 26px;
            border-radius: 12px;
            text-align: center;
        }

        .main .box .box-title {
            font-weight: bold;
            color: #d70018;
            font-size: 22px;
            margin: 0;
        }

        .main .box .box-subtitle {
            font-weight: bold;
            color: #232b33;
        }

        .main .box .box-button {
            background-color: #d9534f;
            border: 2px solid #422800;
            border-radius: 12px;
            box-shadow: #422800 4px 4px 0 0;
            color: #ffffff;
            font-weight: 700;
            cursor: pointer;
            display: inline-block;
            font-weight: 600;
            font-size: 18px;
            padding: 0 18px;
            line-height: 50px;
            text-align: center;
            text-decoration: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        .main .box .box-divide-layout {
            display: flex;
            justify-content: center;
            margin-top: 16px;
        }

        .main .box .box-divide {
            width: 320px;
            height: 3px;
            border-radius: 6px;
            background-color: #f3f4f6;
        }

        .main .box .box-button:hover {
            background-color: #fff;
            color: #d9534f;
        }

        .main .box .box-button:active {
            box-shadow: #422800 2px 2px 0 0;
            transform: translate(2px, 2px);
        }

        .main input {
            width: 320px;
            border: 2px solid #232b33;
            height: 32px;
            border-radius: 6px;
            padding-left: 12px;
            padding-right: 12px;
        }

        .main input:active {
            border-color: #d70018;
        }

        .main .lable {
            color: #232b33;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .main .lable.confirm {
            margin-top: 12px;
        }

        .main form {
            margin: 16px 0;
        }

    </style>
</head>

<body class="antialiased">
<div class="main">
    <div class="box">
        <img src="https://itviec.com/rails/active_storage/representations/proxy/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaHBBL0gvRFE9PSIsImV4cCI6bnVsbCwicHVyIjoiYmxvYl9pZCJ9fQ==--0d8cef178a9a6fb63857d25eaa55766d51abba78/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaDdCem9MWm05eWJXRjBTU0lJY0c1bkJqb0dSVlE2RkhKbGMybDZaVjkwYjE5c2FXMXBkRnNIYVFJc0FXa0NMQUU9IiwiZXhwIjpudWxsLCJwdXIiOiJ2YXJpYXRpb24ifX0=--ee4e4854f68df0a745312d63f6c2782b5da346cd/cellphones-logo.png"
             alt="Logo" />
        <p class="box-title">Create your new password</p>
        <div class="box-divide-layout">
            <div class="box-divide"></div>
        </div>
        <form>
            <div class="lable">
                New password
            </div>
            <div>
                <input type="password" />
            </div>
            <div class="lable confirm">
                Confirm new password
            </div>
            <div>
                <input type="password" />
            </div>
        </form>
        <a class="box-button">CREATE NEW PASSWORD</a>
    </div>
</div>
</div>
</body>

</html>
