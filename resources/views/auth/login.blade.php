<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #F1FAF5; /* Pastel Green Background */
            font-family: 'Inter', sans-serif;
        }

        .btn-pastel-green {
            background-color: #4ADE80;
            color: #ffffff;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-pastel-green:hover {
            background-color: #35C76E;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .input-group-text {
            cursor: pointer;
            background-color: #f8f9fa;
            border: none;
            color: #6c757d;
        }

        /* ปรับแต่ง Input เมื่อ Focus */
        .form-control:focus {
            box-shadow: 0 0 0 0.25 margin-rgba(74, 222, 128, 0.25);
            border-color: #4ADE80;
        }
    </style>
</head>
<body class="min-vh-100 d-flex align-items-center">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="row g-0">

                        <div class="col-md-5 d-none d-md-flex flex-column align-items-center justify-content-center p-5"
                             style="background-color: #7EE0AD;">
                            <div class="text-center">
                                <h2 class="fw-bold mb-3" style="color: #1A531A;">Welcome!</h2>
                                <p class="mb-0" style="color: #22543D; opacity: 0.8;">เข้าสู่ระบบเพื่อจัดการข้อมูลของคุณ</p>
                            </div>
                        </div>

                        <div class="col-md-7 p-4 p-md-5 bg-white">
                            <div class="text-center mb-4">
                                <h3 class="fw-bold text-dark">{{ __('Login') }}</h3>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-secondary small">{{ __('Email Address') }}</label>
                                    <input id="email" type="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-semibold text-secondary small mb-0">{{ __('Password') }}</label>
                                        @if (Route::has('password.request'))
                                            <a class="text-decoration-none small fw-semibold" style="color: #2F855A;" href="{{ route('password.request') }}">Forgot?</a>
                                        @endif
                                    </div>

                                    <div class="input-group">
                                        <input id="password" type="password"
                                               class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror"
                                               name="password" required placeholder="••••••••">
                                        <span class="input-group-text bg-light border-0" id="togglePassword">
                                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                                        </span>
                                    </div>

                                    @error('password')
                                        <span class="text-danger small" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="mb-4 form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label text-secondary small" for="remember">Remember Me</label>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-lg btn-pastel-green fw-bold rounded-3 shadow-sm">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            // สลับ type ระหว่าง password และ text
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // สลับไอคอนระหว่าง eye และ eye-slash
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>
