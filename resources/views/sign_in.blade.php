<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <title>
        Telyu Form
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.4/jquery.rateyo.min.css"
        integrity="sha512-JEUoTOcC35/ovhE1389S9NxeGcVLIqOAEzlpcJujvyUaxvIXJN9VxPX0x1TwSo22jCxz2fHQPS1de8NgUyg+nA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
    </style>
    @yield('css')
</head>

<body class="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">

            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Masuk</h4>
                                    <p class="mb-0">Masukkan email dan password</p>
                                </div>
                                <div class="card-body">
                                    <!-- Display general error message if session has errors -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger text-white">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form role="form" id="loginForm" method="POST"
                                        action="{{ route('auth.check-login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="email" name="email" id="email"
                                                class="form-control form-control-lg" placeholder="Email"
                                                aria-label="Email">
                                            <div id="emailError" class="error-message"></div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <input type="password" name="password" id="password"
                                                    class="form-control form-control-lg" placeholder="Password"
                                                    aria-label="Password">

                                            </div>
                                            <div id="passwordError" class="error-message"></div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="button" onclick="validateForm()"
                                                class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Masuk</button>
                                        </div>
                                    </form>
                                </div>
                                {{-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Tidak punya akun?
                                        <a href="{{ route('sign_up') }}"
                                            class="text-primary text-gradient font-weight-bold">Daftar disini</a>
                                    </p>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center align-items-center overflow-hidden"
                                style="background: linear-gradient(135deg, #b31217 0%, #e52d27 100%); box-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05);">
                                
                                <!-- Decorative background circles for modern look -->
                                <div class="position-absolute" style="width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%; top: -50px; right: -50px; blur(10px);"></div>
                                <div class="position-absolute" style="width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%; bottom: 10%; left: -20px;"></div>

                                <div class="position-relative z-index-1 d-flex flex-column align-items-center w-100">
                                    <div class="bg-white p-4 rounded-circle mb-5" style="box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                        <img src="{{ asset('assets/img/logos/logo.png') }}" alt="Telkom University Logo" style="width: 180px; height: auto; object-fit: contain;">
                                    </div>
                                    <h3 class="mt-4 text-white font-weight-bolder position-relative" style="letter-spacing: 0.5px;">Telkom University</h3>
                                    <p class="text-white position-relative px-4 mt-2" style="font-size: 1.05rem; font-weight: 300; opacity: 0.9;">
                                        Sistem Presensi Terintegrasi untuk menunjang kedisiplinan dan kemudahan administrasi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
    <script>
        function validateForm() {

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            let isValid = true;

            // Reset error messages
            emailError.textContent = '';
            passwordError.textContent = '';


            // Email validation
            if (email.trim() === '') {
                emailError.textContent = 'Email tidak boleh kosong';
                isValid = false;
            } else if (!email.includes('@')) {
                emailError.textContent = 'Email harus menggunakan @';
                isValid = false;
            }

            // Password validation
            if (password.trim() === '') {
                passwordError.textContent = 'Password tidak boleh kosong';
                isValid = false;
            } else if (password.length < 8) {
                passwordError.textContent = 'Password harus lebih dari 8 karakter';
                isValid = false;
            }

            if (isValid) {
                document.getElementById('loginForm').submit();

            }
        }
    </script>

    @yield('script')
</body>

</html>
