<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        p {
            font-size: 14px;
            color: #333;
            margin-bottom: 20px;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }

        .primary-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .primary-btn:hover {
            background-color: #45a049;
        }

        .logout-btn {
            background: none;
            border: none;
            color: #888;
            font-size: 14px;
            text-decoration: underline;
            cursor: pointer;
        }

        .logout-btn:hover {
            color: #333;
        }

    </style>
</head>
<body>
    <div class="container">
        <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="success-message">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div class="buttons">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="primary-btn" type="submit">Resend Verification Email</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn" type="submit">Log Out</button>
            </form>
        </div>
    </div>
</body>
</html>
