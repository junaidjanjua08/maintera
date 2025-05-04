<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | TechConnect</title>
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
            padding: 2.5rem 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px; /* Increased from 450px to 800px */
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
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

        .form-container h2 {
            margin-bottom: 1.5rem;
            font-size: 2.2rem;
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
            width: 80px;
            height: 4px;
            background: var(--accent);
            border-radius: 3px;
        }

        .form-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        input, select {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            font-size: 0.95rem;
            transition: all 0.3s;
            background-color: #f9f9f9;
        }

        input:focus, select:focus {
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

        .submit-section {
            grid-column: span 2;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .submit-btn {
            width: 60%;
            background: linear-gradient(to right, var(--primary), var(--accent));
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 0.5rem;
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

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.95rem;
            color: #666;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .login-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .role-selector {
            grid-column: span 2;
            margin-bottom: 1rem;
        }

        .role-selector select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 1em;
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
        @media (max-width: 768px) {
            .form-content {
                grid-template-columns: 1fr;
            }
            
            .submit-section, .role-selector {
                grid-column: span 1;
            }
            
            .submit-btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 1.5rem;
            }
            
            .form-container h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container animate__animated animate__fadeInUp">
        <h2>Create Your Account</h2>
        <form method="POST" action="{{ route('register') }}" class="animate-form">
            @csrf
            
            <div class="form-content">
                <div class="role-selector">
                    <label for="role">I want to register as:</label>
                    <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="customer">Customer</option>
                        <option value="technician">Technician</option>
                    </select>
                </div>
                
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter your full name">
                    @if($errors->has('name'))
                        <span class="error">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
                    @if($errors->has('email'))
                        <span class="error">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required placeholder="At least 8 characters">
                    @if($errors->has('password'))
                        <span class="error">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirm your password">
                    @if($errors->has('password_confirmation'))
                        <span class="error">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>

                <div class="submit-section">
                    <button type="submit" class="submit-btn animate__animated animate__pulse animate__slow animate__infinite">
                        Register Now
                    </button>

                    <div class="login-link">
                        <span>Already have an account? <a href="{{ route('login') }}">Sign In</a></span>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Add focus effects
        document.querySelectorAll('input, select').forEach(element => {
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