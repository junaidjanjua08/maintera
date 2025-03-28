<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
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

        .input-label {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 8px;
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

        .btn-container {
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>This is a secure area of the application. Please confirm your password before continuing.</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <label for="password" class="input-label">Password</label>
                <input id="password" class="input-field" type="password" name="password" required autocomplete="current-password">
                <!-- Error Message -->
                <div class="error-message">
                    @if ($errors->has('password'))
                        {{ $errors->first('password') }}
                    @endif
                </div>
            </div>

            <!-- Confirm Button -->
            <div class="btn-container">
                <button class="primary-btn" type="submit">Confirm</button>
            </div>
        </form>
    </div>
</body>
</html>
