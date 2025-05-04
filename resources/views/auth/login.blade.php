<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TechConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    margin: 0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

/* Glowing floating circles */
.circle {
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.3), transparent);
    animation: float 15s infinite ease-in-out;
    z-index: 0;
    pointer-events: none;
}
.circle:nth-child(1) {
    width: 200px;
    height: 200px;
    top: 10%;
    left: 15%;
    animation-delay: 0s;
}
.circle:nth-child(2) {
    width: 300px;
    height: 300px;
    bottom: 10%;
    right: 20%;
    animation-delay: 5s;
}
.circle:nth-child(3) {
    width: 150px;
    height: 150px;
    top: 60%;
    left: 60%;
    animation-delay: 2s;
}
@keyframes float {
    0%, 100% {
        transform: translateY(0px) scale(1);
    }
    50% {
        transform: translateY(-30px) scale(1.1);
    }
}

/* Background blob */
.blob {
    position: absolute;
    width: 400px;
    height: 400px;
    background: linear-gradient(45deg, var(--primary), var(--accent));
    opacity: 0.15;
    border-radius: 50% 50% 40% 60% / 60% 40% 60% 50%;
    animation: blobMove 20s infinite alternate ease-in-out;
    z-index: 0;
}
.blob.blob1 {
    top: -100px;
    left: -100px;
}
.blob.blob2 {
    bottom: -150px;
    right: -150px;
}
@keyframes blobMove {
    0% {
        transform: translate(0, 0) rotate(0deg);
    }
    100% {
        transform: translate(30px, 50px) rotate(360deg);
    }
}


        .form-container {
            background-color: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 2;
        }

        .form-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo {
            height: 60px;
            width: auto;
            transition: all 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .form-container h2 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: var(--dark);
            text-align: center;
            font-weight: 700;
            position: relative;
        }

        .form-container h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--accent);
            border-radius: 3px;
        }

        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            font-size: 0.95rem;
            transition: all 0.3s;
            background-color: #f9f9f9;
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(72, 149, 239, 0.2);
            background-color: white;
        }

        .error {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            width: auto;
            margin-right: 8px;
        }

        .remember-me label {
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .forgot-password {
            font-size: 0.9rem;
        }

        .forgot-password a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(to right, var(--primary), var(--accent));
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            background: linear-gradient(to right, var(--primary-dark), var(--primary));
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .submit-btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.95rem;
            color: #666;
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .register-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Animated Background Elements */
        .gear {
            position: absolute;
            fill: #6b7280;
            opacity: 0.1;
            z-index: 1;
        }

        .gear1 {
            top: 10%;
            left: 15%;
            width: 120px;
            animation: rotate 8s linear infinite;
        }

        .gear2 {
            bottom: 15%;
            right: 20%;
            width: 150px;
            animation: rotate-reverse 10s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes rotate-reverse {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(-360deg); }
        }

        /* Animation classes */
        .animate-form {
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .form-container {
                padding: 1.5rem;
            }
            
            .form-container h2 {
                font-size: 1.5rem;
            }
            
            .gear1, .gear2 {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Background SVG gears -->
    <svg class="gear gear1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
        <path d="M63,38V26H54.77A23.9,23.9,0,0,0,50.11,17L56,11.13,52.87,8,47,13.89a23.9,23.9,0,0,0-9-4.66V1H26V9.23a23.9,23.9,0,0,0-9,4.66L11.13,8,8,11.13,13.89,17a23.9,23.9,0,0,0-4.66,9H1V38H9.23a23.9,23.9,0,0,0,4.66,9L8,52.87,11.13,56,17,50.11a23.9,23.9,0,0,0,9,4.66V63H38V54.77a23.9,23.9,0,0,0,9-4.66L52.87,56,56,52.87,50.11,47a23.9,23.9,0,0,0,4.66-9Z"/>
    </svg>

    <svg class="gear gear2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
        <path d="M63,38V26H54.77A23.9,23.9,0,0,0,50.11,17L56,11.13,52.87,8,47,13.89a23.9,23.9,0,0,0-9-4.66V1H26V9.23a23.9,23.9,0,0,0-9,4.66L11.13,8,8,11.13,13.89,17a23.9,23.9,0,0,0-4.66,9H1V38H9.23a23.9,23.9,0,0,0,4.66,9L8,52.87,11.13,56,17,50.11a23.9,23.9,0,0,0,9,4.66V63H38V54.77a23.9,23.9,0,0,0,9-4.66L52.87,56,56,52.87,50.11,47a23.9,23.9,0,0,0,4.66-9Z"/>
    </svg>

    <!-- Login Form -->
    <div class="form-container animate__animated animate__fadeInUp">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('path_to_logo/logo.png') }}" alt="Maintera Logo" class="logo">
        </div>

        <h2>Welcome Back</h2>
        
        <form method="POST" action="{{ route('login') }}" class="animate-form">
            @csrf
            <input type="hidden" name="role" value="{{ request('role') ?? 'customer' }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required placeholder="••••••••">
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="options-row">
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember Me</label>
                </div>
                @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                @endif
            </div>

            <button type="submit" class="submit-btn animate__animated animate__pulse animate__slow animate__infinite">
                Sign In
            </button>

            <div class="register-link">
                <span>Don't have an account? <a href="{{ route('register') }}">Register</a></span>
            </div>
        </form>
    </div>

    <script>
        // Add focus effects
        document.querySelectorAll('input').forEach(element => {
            element.addEventListener('focus', function() {
                this.parentNode.querySelector('label').style.color = '#4361ee';
            });
            
            element.addEventListener('blur', function() {
                this.parentNode.querySelector('label').style.color = '#212529';
            });
        });

        // Button ripple effect
        document.querySelector('.submit-btn').addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.add('animate__animated', 'animate__pulse');
            
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__pulse');
                this.form.submit();
            }, 500);
        });
    </script>
</body>
</html>