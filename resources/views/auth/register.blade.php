<!-- resources/views/auth/login.blade.php -->
@extends('layouts.auth')



@section('content')
    <style>
        .register-container {
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

        .login-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #6b7280;
        }

        .login-link a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
    <div class="register-container">
        <h2 class="page-title">Sign Up</h2>
        <p class="page-subtitle">Please create your account to get started</p>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <select name="" id="" class=" form-input">
                <option value="">teacher</option>
                <option value="">student</option>
            </select>

            
            <div class="social-buttons">
                <a href="{{ url('auth/google/redirect') }}" class="social-button google-btn">
                    <i class="ph ph-google-logo"></i>
                </a>

            </div>

            {{-- <div class="divider">
                <span class="divider-text">or</span>
            </div>


            <div class="form-group">
                <label class="form-label" for="email">Name</label>
                <div class="input-wrapper">
                    <input type="text" class="form-input" id="name" placeholder="Enter your email address"
                        name="name">
                    <span class="input-icon">
                        <i class="ph ph-user"></i>
                    </span>
                </div>
            </div>


            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrapper">
                    <input type="email" class="form-input" id="email" placeholder="Enter your email address"
                        name="email">
                    <span class="input-icon">
                        <i class="ph ph-envelope"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <div class="input-wrapper">
                    <input type="tel" class="form-input" id="phone" placeholder="Enter your phone number"
                        name="phone_number">
                    <span class="input-icon">
                        <i class="ph ph-phone"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" class="form-input" id="password" placeholder="Create a password"
                        name="password">
                    <span class="input-icon">
                        <i class="ph ph-lock"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <div class="input-wrapper">
                    <input type="password" class="form-input" id="password_confirmation" placeholder="Confirm your password"
                        name="password_confirmation">
                    <span class="input-icon">
                        <i class="ph ph-lock"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="submit-btn">Create Account</button> --}}

            <p class="login-link">
                Already have an account?
                <a href="{{ route('login.form') }}">Login</a>
            </p>
        </form>
    </div>
@endsection
