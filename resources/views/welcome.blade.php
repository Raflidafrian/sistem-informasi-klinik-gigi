<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<title>DentalCare Clinic</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        color: #1e293b;
        background: #ffffff;
    }

    a {
        text-decoration: none;
    }

    /* ================= NAVBAR ================= */

    .navbar {
        width: 100%;
        padding: 20px 7%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255,255,255,0.95);
        border-bottom: 1px solid #e5e7eb;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 22px;
        font-weight: bold;
        color: #0f766e;
    }

    .logo-icon {
        width: 42px;
        height: 42px;
        background: #ccfbf1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    .nav-menu {
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .nav-menu a {
        color: #475569;
        font-size: 14px;
        font-weight: 500;
    }

    .nav-menu a:hover {
        color: #0f766e;
    }

    .btn-login {
        border: 1px solid #0f766e;
        color: #0f766e !important;
        padding: 10px 20px;
        border-radius: 8px;
    }

    .btn-register {
        background: #0f766e;
        color: white !important;
        padding: 11px 20px;
        border-radius: 8px;
    }

    /* ================= HERO ================= */

    .hero {
        min-height: 620px;
        padding: 80px 7%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(
            135deg,
            #f0fdfa 0%,
            #ffffff 55%,
            #ecfeff 100%
        );
    }

    .hero-content {
        max-width: 580px;
    }

    .badge {
        display: inline-block;
        background: #ccfbf1;
        color: #0f766e;
        padding: 9px 15px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 22px;
    }

    .hero h1 {
        font-size: 55px;
        line-height: 1.12;
        color: #0f172a;
        margin-bottom: 22px;
    }

    .hero h1 span {
        color: #0f766e;
    }

    .hero p {
        color: #64748b;
        font-size: 17px;
        line-height: 1.8;
        margin-bottom: 30px;
    }

    .hero-buttons {
        display: flex;
        gap: 15px;
    }

    .btn-primary {
        background: #0f766e;
        color: white;
        padding: 14px 24px;
        border-radius: 10px;
        font-weight: bold;
        display: inline-block;
    }

    .btn-primary:hover {
        background: #115e59;
    }

    .btn-secondary {
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 14px 24px;
        border-radius: 10px;
        font-weight: bold;
        display: inline-block;
        background: white;
    }

    /* ================= HERO IMAGE ================= */

    .hero-image {
        width: 440px;
        height: 440px;
        border-radius: 35px;
        background: linear-gradient(
            135deg,
            #ccfbf1,
            #cffafe
        );
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .doctor-placeholder {
        width: 330px;
        height: 380px;
        border-radius: 170px 170px 30px 30px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 100px;
        box-shadow: 0 20px 50px rgba(15,118,110,0.15);
    }

    /* ================= STATS ================= */

    .stats {
        padding: 35px 7%;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .stat {
        text-align: center;
    }

    .stat h3 {
        font-size: 28px;
        color: #0f766e;
    }

    .stat p {
        color: #64748b;
        margin-top: 5px;
    }

    /* ================= SERVICES ================= */

    .section {
        padding: 90px 7%;
    }

    .section-title {
        text-align: center;
        max-width: 650px;
        margin: auto;
    }

    .section-title span {
        color: #0f766e;
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .section-title h2 {
        font-size: 38px;
        margin: 12px 0;
        color: #0f172a;
    }

    .section-title p {
        color: #64748b;
        line-height: 1.7;
    }

    .services {
        margin-top: 50px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 22px;
    }

    .service-card {
        padding: 30px;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        transition: 0.3s;
        background: white;
    }

    .service-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 15px 35px rgba(15,23,42,0.08);
        border-color: #99f6e4;
    }

    .service-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        background: #ccfbf1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin-bottom: 20px;
    }

    .service-card h3 {
        margin-bottom: 10px;
        color: #0f172a;
    }

    .service-card p {
        color: #64748b;
        line-height: 1.6;
        font-size: 14px;
    }

    /* ================= ABOUT ================= */

    .about {
        background: #f8fafc;
        display: flex;
        align-items: center;
        gap: 80px;
    }

    .about-image {
        flex: 1;
        height: 400px;
        border-radius: 25px;
        background: #ccfbf1;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 120px;
    }

    .about-content {
        flex: 1;
    }

    .about-content span {
        color: #0f766e;
        font-weight: bold;
        font-size: 13px;
    }

    .about-content h2 {
        font-size: 38px;
        margin: 15px 0;
        color: #0f172a;
    }

    .about-content p {
        color: #64748b;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .features {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .feature {
        color: #334155;
        font-size: 14px;
    }

    .feature span {
        color: #0f766e;
        margin-right: 7px;
    }

    /* ================= CTA ================= */

    .cta {
        margin: 80px 7%;
        padding: 65px;
        border-radius: 25px;
        background: linear-gradient(
            135deg,
            #0f766e,
            #115e59
        );
        text-align: center;
        color: white;
    }

    .cta h2 {
        font-size: 38px;
        margin-bottom: 15px;
    }

    .cta p {
        opacity: 0.9;
        margin-bottom: 25px;
    }

    .cta-button {
        display: inline-block;
        background: white;
        color: #0f766e;
        padding: 14px 25px;
        border-radius: 10px;
        font-weight: bold;
    }

    /* ================= FOOTER ================= */

    footer {
        background: #0f172a;
        color: white;
        padding: 45px 7%;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        gap: 30px;
    }

    .footer-brand {
        max-width: 350px;
    }

    .footer-brand h3 {
        color: #5eead4;
        margin-bottom: 10px;
    }

    .footer-brand p {
        color: #94a3b8;
        line-height: 1.7;
        font-size: 14px;
    }

    .footer-contact h4 {
        margin-bottom: 12px;
    }

    .footer-contact p {
        color: #94a3b8;
        line-height: 1.8;
        font-size: 14px;
    }

    .copyright {
        border-top: 1px solid #334155;
        margin-top: 30px;
        padding-top: 20px;
        color: #64748b;
        font-size: 13px;
    }

    /* ================= RESPONSIVE ================= */

    @media (max-width: 1000px) {

        .hero {
            flex-direction: column;
            text-align: center;
            gap: 50px;
        }

        .hero-buttons {
            justify-content: center;
        }

        .services {
            grid-template-columns: repeat(2, 1fr);
        }

        .about {
            flex-direction: column;
        }

        .hero-image {
            width: 350px;
            height: 350px;
        }
    }

    @media (max-width: 700px) {

        .nav-menu a:not(.btn-login):not(.btn-register) {
            display: none;
        }

        .hero h1 {
            font-size: 40px;
        }

        .stats {
            grid-template-columns: 1fr;
        }

        .services {
            grid-template-columns: 1fr;
        }

        .features {
            grid-template-columns: 1fr;
        }

        .cta {
            margin: 40px 5%;
            padding: 40px 20px;
        }

        .cta h2 {
            font-size: 28px;
        }

        .footer-content {
            flex-direction: column;
        }
    }
</style>

</head>

<body>

<!-- ================= NAVBAR ================= -->

<nav class="navbar">

    <a href="{{ url('/') }}" class="logo">
        <div class="logo-icon">🦷</div>
        DentalCare
    </a>

    <div class="nav-menu">

        <a href="#home">Beranda</a>
        <a href="#layanan">Layanan</a>
        <a href="#tentang">Tentang</a>
        <a href="#kontak">Kontak</a>

        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-login">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-login">
                    Login
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-register">
                        Register
                    </a>
                @endif
            @endauth
        @endif

    </div>

</nav>


<!-- ================= HERO ================= -->

<section class="hero" id="home">

    <div class="hero-content">

        <div class="badge">
            🦷 KLINIK GIGI PROFESIONAL
        </div>

        <h1>
            Senyum Sehat,
            <span>Percaya Diri.</span>
        </h1>

        <p>
            DentalCare hadir memberikan pelayanan kesehatan gigi
            yang profesional, nyaman, dan terpercaya dengan
            dukungan tenaga medis berpengalaman.
        </p>

        <div class="hero-buttons">

            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary">
                    Masuk Dashboard →
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-primary">
                    Buat Janji →
                </a>

                <a href="#layanan" class="btn-secondary">
                    Lihat Layanan
                </a>
            @endauth

        </div>

    </div>


    <div class="hero-image">

        <div class="doctor-placeholder">
            🧑‍⚕️
        </div>

    </div>

</section>


<!-- ================= STATS ================= -->

<section class="stats">

    <div class="stat">
        <h3>10+</h3>
        <p>Tahun Pengalaman</p>
    </div>

    <div class="stat">
        <h3>1.000+</h3>
        <p>Pasien Ditangani</p>
    </div>

    <div class="stat">
        <h3>5+</h3>
        <p>Tenaga Profesional</p>
    </div>

</section>


<!-- ================= SERVICES ================= -->

<section class="section" id="layanan">

    <div class="section-title">

        <span>Layanan Kami</span>

        <h2>
            Perawatan Gigi untuk Anda
        </h2>

        <p>
            Kami menyediakan berbagai layanan perawatan
            gigi untuk menjaga kesehatan dan kepercayaan
            diri Anda.
        </p>

    </div>


    <div class="services">

        <div class="service-card">

            <div class="service-icon">
                🦷
            </div>

            <h3>
                Pemeriksaan Gigi
            </h3>

            <p>
                Pemeriksaan kondisi gigi dan mulut
                secara menyeluruh oleh dokter gigi.
            </p>

        </div>


        <div class="service-card">

            <div class="service-icon">
                ✨
            </div>

            <h3>
                Scaling Gigi
            </h3>

            <p>
                Membersihkan karang gigi dan menjaga
                kesehatan gigi serta gusi.
            </p>

        </div>


        <div class="service-card">

            <div class="service-icon">
                🩺
            </div>

            <h3>
                Tambal Gigi
            </h3>

            <p>
                Perawatan gigi berlubang untuk membantu
                mempertahankan fungsi gigi.
            </p>

        </div>


        <div class="service-card">

            <div class="service-icon">
                😁
            </div>

            <h3>
                Perawatan Ortodonti
            </h3>

            <p>
                Perawatan untuk membantu mendapatkan
                susunan gigi yang lebih teratur.
            </p>

        </div>

    </div>

</section>


<!-- ================= ABOUT ================= -->

<section class="section about" id="tentang">

    <div class="about-image">
        🦷
    </div>

    <div class="about-content">

        <span>TENTANG DENTALCARE</span>

        <h2>
            Kesehatan Gigi Anda
            adalah Prioritas Kami
        </h2>

        <p>
            DentalCare merupakan sistem informasi klinik
            yang membantu proses pengelolaan data pasien,
            dokter, pemeriksaan, pembayaran, dan layanan
            kesehatan gigi secara lebih terstruktur.
        </p>

        <div class="features">

            <div class="feature">
                <span>✓</span>
                Dokter Profesional
            </div>

            <div class="feature">
                <span>✓</span>
                Pelayanan Nyaman
            </div>

            <div class="feature">
                <span>✓</span>
                Data Terintegrasi
            </div>

            <div class="feature">
                <span>✓</span>
                Sistem Terkomputerisasi
            </div>

        </div>

    </div>

</section>


<!-- ================= CTA ================= -->

<section class="cta">

    <h2>
        Siap Menjaga Kesehatan Gigi Anda?
    </h2>

    <p>
        Daftarkan diri Anda dan dapatkan pelayanan
        kesehatan gigi yang nyaman dan profesional.
    </p>

    @auth
    @php
        $dashboardRoute = match (Auth::user()->role) {
            'admin' => 'admin.dashboard',
            'dokter' => 'dokter.dashboard',
            'pasien' => 'pasien.dashboard',
            default => null,
        };
    @endphp

    @if ($dashboardRoute && Route::has($dashboardRoute))
        <a href="{{ route($dashboardRoute) }}"
           class="cta-button">
            Masuk ke Dashboard
        </a>
    @endif

    <form method="POST"
          action="{{ route('logout') }}"
          style="display: inline-block;">

        @csrf

        <button type="submit" class="cta-button">
            Logout
        </button>
    </form>

@else

    <a href="{{ route('login') }}"
       class="cta-button">
        Login
    </a>

    @if (Route::has('register'))
        <a href="{{ route('register') }}"
           class="cta-button">
            Daftar Sekarang
        </a>
    @endif

@endauth

</section>


<!-- ================= FOOTER ================= -->

<footer id="kontak">

    <div class="footer-content">

        <div class="footer-brand">

            <h3>
                🦷 DentalCare Clinic
            </h3>

            <p>
                Sistem informasi klinik gigi untuk membantu
                pengelolaan pelayanan kesehatan gigi secara
                efektif dan terintegrasi.
            </p>

        </div>


        <div class="footer-contact">

            <h4>
                Kontak Kami
            </h4>

            <p>
                📍 Jakarta, Indonesia
                <br>
                📞 0812-3456-7890
                <br>
                ✉️ dentalcare@gmail.com
            </p>

        </div>

    </div>


    <div class="copyright">

        © {{ date('Y') }} DentalCare Clinic.
        All Rights Reserved.

    </div>

</footer>

</body>
</html>