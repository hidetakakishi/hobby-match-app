<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        /* Reset some default styles */
        body,
        h2,
        input,
        button {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
            font-family: 'Arial', sans-serif;
        }

        /* Container for the login form */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        /* Login form styles */
        .login-form {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            /* Adjusted for a wider form */
        }

        /* Heading styles */
        .login-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        /* Form group styles */
        .form-group {
            margin-bottom: 20px;
        }

        /* Label styles */
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        /* Input styles */
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Button styles */
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        /* Button hover effect */
        .btn:hover {
            background-color: #0056b3;
        }

        /* Forgot password link styles */
        .forgot-password {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }

        /* Forgot password link hover effect */
        .forgot-password:hover {
            text-decoration: underline;
        }

        .google-login {
            margin-top: 20px;
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px;
            background-color: #ffffff;
            color: #757575;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .google-btn:hover {
            background-color: #f1f1f1;
        }

        .google-icon {
            width: 20px;
            margin-right: 10px;
        }
    </style>
</head>

<body class="container">
    <div class="login-container">
        <div class="login-form">
            <h2>Reset Password</h2>
            <form method="POST" action="{{ route('auth.send.reset.password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required autofocus>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">send</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
