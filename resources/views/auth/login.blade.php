<!-- resources/views/auth/login.blade.php -->
@extends('layouts.auth')



@section('content')
    <style>
        .login-container {
            max-width: 480px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
            text-align: center;
        }

        .page-subtitle {
            font-size: 15px;
            color: #666;
            text-align: center;
            margin-bottom: 32px;
        }

        .social-buttons {
            display: flex;
            gap: 15px;
            margin: 24px 0;
        }

        .social-button {
            flex: 1;
            height: 50px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .google-btn {
            background-color: #f1f5f9;
            color: #ea4335;
        }

        .google-btn:hover {
            background-color: #ea4335;
            color: white;
        }

        .facebook-btn {
            background-color: #f1f5f9;
            color: #1877f2;
        }

        .facebook-btn:hover {
            background-color: #1877f2;
            color: white;
        }

        .divider {
            text-align: center;
            position: relative;
            margin: 30px 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background-color: #e5e7eb;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .divider-text {
            background-color: white;
            padding: 0 15px;
            color: #6b7280;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            cursor: pointer;
            padding: 4px;
            z-index: 1;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .signup-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #6b7280;
        }

        .signup-link a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .emoji {
            font-size: 1.2em;
            vertical-align: middle;
            margin-left: 4px;
        }
    </style>
    <div class="login-container">
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
            @if(session('error_details'))
                <small class="d-block mt-1">التفاصيل التقنية: {{ session('error_details') }}</small>
            @endif
        </div>
    @endif
        <h2 class="page-title">Login</h2>
        <p class="page-subtitle">Welcome Back! <span class="emoji">👋</span></p>

        <form action="#">
            <div class="social-buttons">
                <a href="{{ url('auth/google/redirect') }}" class="social-button google-btn">
                    <i class="ph ph-google-logo"></i>
                </a>

            </div>

            <div class="divider">
                <span class="divider-text">or</span>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Or Number</label>
                <div class="input-wrapper">
                    <input type="email" class="form-input" id="email" placeholder="Type your email address">
                    <span class="input-icon">
                        <i class="ph ph-envelope"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="current-password">Password</label>
                <div class="input-wrapper">
                    <input type="password" class="form-input" id="current-password" placeholder="Enter Current Password">
                    <span class="input-icon">
                        <i class="ph ph-lock"></i>
                    </span>
                    <span class="toggle-password ph ph-eye-slash" id="#current-password"></span>
                </div>
            </div>

            <button type="submit" class="submit-btn">Login</button>

            <p class="signup-link">
                Don't Have Account?
                <a href="{{ route('register.form') }}">Sign Up</a>
            </p>
        </form>
    </div>

    <script>
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const password = document.querySelector('#current-password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle icon
            this.classList.toggle('ph-eye');
            this.classList.toggle('ph-eye-slash');
        });
    </script>
@endsection
