<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - DentalCare Clinic</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            min-height: 100vh;
            background:
                linear-gradient(
                    rgba(15, 118, 110, 0.12),
                    rgba(15, 118, 110, 0.12)
                ),
                #f0fdfa;

            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1050px;
            min-height: 620px;

            display: grid;
            grid-template-columns: 1fr 1fr;

            background: white;
            border-radius: 25px;

            overflow: hidden;

            box-shadow:
                0 25px 60px rgba(15, 23, 42, 0.15);
        }

        /* =========================
           LEFT SIDE
        ========================= */

        .left-side {
            background:
                linear-gradient(
                    135deg,
                    rgba(15, 118, 110, 0.95),
                    rgba(13, 148, 136, 0.90)
                );

            color: white;

            padding: 55px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            position: relative;
            overflow: hidden;
        }

        .left-side::before {
            content: "";
            position: absolute;

            width: 300px;
            height: 300px;

            border-radius: 50%;

            background: rgba(255,255,255,0.08);

            top: -100px;
            right: -100px;
        }

        .left-side::after {
            content: "";
            position: absolute;

            width: 250px;
            height: 250px;

            border-radius: 50%;

            background: rgba(255,255,255,0.07);

            bottom: -100px;
            left: -100px;
        }

        .brand {
            position: relative;
            z-index: 2;

            margin-bottom: 45px;
        }

        .brand-icon {
            width: 70px;
            height: 70px;

            background: white;

            border-radius: 20px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 38px;

            margin-bottom: 20px;
        }

        .brand h1 {
            font-size: 34px;
            margin-bottom: 7px;
        }

        .brand span {
            font-size: 14px;
            opacity: 0.85;
            letter-spacing: 2px;
        }

        .welcome {
            position: relative;
            z-index: 2;
        }

        .welcome h2 {
            font-size: 38px;
            line-height: 1.2;
            margin-bottom: 18px;
        }

        .welcome p {
            line-height: 1.8;
            opacity: 0.9;
            font-size: 15px;
            max-width: 420px;
        }

        .features {
            position: relative;
            z-index: 2;

            margin-top: 35px;

            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 12px;

            font-size: 14px;
        }

        .feature-icon {
            width: 35px;
            height: 35px;

            background: rgba(255,255,255,0.15);

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;
        }


        /* =========================
           RIGHT SIDE
        ========================= */

        .right-side {
            padding: 60px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 35px;
        }

        .login-header h2 {
            color: #0f172a;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #64748b;
            font-size: 14px;
        }

        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;

            margin-bottom: 8px;

            color: #334155;

            font-size: 14px;

            font-weight: 600;
        }

        .input {
            width: 100%;

            padding: 14px 16px;

            border: 1px solid #cbd5e1;

            border-radius: 10px;

            font-size: 14px;

            outline: none;

            transition: 0.2s;
        }

        .input:focus {
            border-color: #0f766e;

            box-shadow:
                0 0 0 3px rgba(15,118,110,0.12);
        }

        .error {
            color: #dc2626;

            font-size: 12px;

            margin-top: 7px;
        }

        /* =========================
           REMEMBER
        ========================= */

        .form-options {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 25px;

            font-size: 13px;
        }

        .remember {
            display: flex;

            align-items: center;

            gap: 7px;

            color: #64748b;
        }

        .remember input {
            accent-color: #0f766e;
        }

        .forgot {
            color: #0f766e;

            font-weight: 600;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn-login {
            width: 100%;

            border: none;

            background: #0f766e;

            color: white;

            padding: 14px;

            border-radius: 10px;

            font-size: 15px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-login:hover {
            background: #115e59;
        }

        /* =========================
           REGISTER
        ========================= */

        .register {
            text-align: center;

            margin-top: 25px;

            font-size: 14px;

            color: #64748b;
        }

        .register a {
            color: #0f766e;

            font-weight: bold;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            text-align: center;

            margin-top: 35px;

            color: #94a3b8;

            font-size: 12px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 850px) {

            .login-wrapper {
                grid-template-columns: 1fr;
            }

            .left-side {
                padding: 40px;
            }

            .welcome h2 {
                font-size: 30px;
            }

            .right-side {
                padding: 40px;
            }
        }

        @media (max-width: 500px) {

            body {
                padding: 15px;
            }

            .left-side {
                padding: 30px;
            }

            .right-side {
                padding: 30px 25px;
            }

            .brand h1 {
                font-size: 28px;
            }

            .welcome h2 {
                font-size: 27px;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- =========================
             LEFT SIDE
        ========================= -->

        <div class="left-side">

            <div class="brand">

                <div class="brand-icon">
                    🦷
                </div>

                <h1>
                    DentalCare
                </h1>

                <span>
                    KLINIK GIGI
                </span>

            </div>


            <div class="welcome">

                <h2>
                    Selamat Datang
                    Kembali 👋
                </h2>

                <p>
                    Masuk ke sistem DentalCare untuk mengakses
                    layanan dan informasi kesehatan gigi Anda
                    dengan mudah dan nyaman.
                </p>

            </div>


            <div class="features">

                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    <span>
                        Pengelolaan data pasien
                    </span>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    <span>
                        Informasi pemeriksaan gigi
                    </span>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    <span>
                        Sistem klinik terintegrasi
                    </span>

                </div>

            </div>

        </div>


        <!-- =========================
             RIGHT SIDE
        ========================= -->

        <div class="right-side">

            <div class="login-header">

                <h2>
                    Masuk ke Akun
                </h2>

                <p>
                    Silakan masukkan email dan password Anda.
                </p>

            </div>


            <!-- SESSION STATUS -->

            @if (session('status'))

                <div class="error">
                    {{ session('status') }}
                </div>

            @endif


            <!-- LOGIN FORM -->

            <form method="POST" action="{{ route('login') }}">

                @csrf


                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        id="email"
                        class="input"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="contoh@email.com"
                    >

                    @error('email')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        id="password"
                        class="input"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan password"
                    >

                    @error('password')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- OPTIONS -->

                <div class="form-options">

                    <label class="remember">

                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                        >

                        <span>
                            Ingat saya
                        </span>

                    </label>


                    @if (Route::has('password.request'))

                        <a
                            class="forgot"
                            href="{{ route('password.request') }}"
                        >
                            Lupa password?
                        </a>

                    @endif

                </div>


                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    class="btn-login"
                >
                    Masuk ke DentalCare
                </button>

            </form>


            <!-- REGISTER -->

            @if (Route::has('register'))

                <div class="register">

                    Belum mempunyai akun?

                    <a href="{{ route('register') }}">
                        Daftar sekarang
                    </a>

                </div>

            @endif


            <div class="footer">

                © {{ date('Y') }} DentalCare Clinic

            </div>

        </div>

    </div>

</body>

</html>