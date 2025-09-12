<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>

    <!-- Vendors primeiro -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900" rel="stylesheet">
    <!-- O teu CSS por último -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <!-- Toast de sucesso -->
    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
            <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Fechar"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="sectionwhite">
        <div class="container">
            <div class="row full-height justify-content-center">
                <div class="col-12 text-center align-self-center py-5">
                    <div class="sectionwhite pb-5 pt-5 pt-sm-2 text-center">
                        <img src="{{ asset('image/logo.png') }}" alt="Logo" width="180" class="imaglogo">
                        <h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>

                        <!-- Checkbox que controla qual aba está ativa -->
                        <input class="checkbox" type="checkbox" id="reg-log"
                            {{ $errors->has('email') || $errors->has('password') ? 'checked' : '' }}>
                        <label for="reg-log"><i class="uil uil-arrow-up-left"></i></label>

                        <div class="card-3d-wrap mx-auto">
                            <div id="sombracaixa" class="card-3d-wrapper">

                                {{-- LOGIN --}}
                                <div class="card-front">
                                    <div class="center-wrap">
                                        <div class="sectioncard text-center">
                                            <h4 class="mb-4 pb-3">Log In</h4>
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="form-group mt-2">
                                                    <input type="email" name="email" class="form-style"
                                                        placeholder="Email@" required>
                                                    <i class="input-icon uil uil-at"></i>
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password" class="form-style"
                                                        placeholder="Password" required>
                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn mt-4">submit</button>
                                                <p class="mb-0 mt-4 text-center">
                                                    <a href="{{ route('password.request') }}" class="link">Forgot your
                                                        password?</a>
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- SIGN UP --}}
                                <div class="card-back">
                                    <div class="center-wrap">
                                        <div class="sectioncard text-center">
                                            <h4 class="mb-4 pb-3">Sign Up</h4>
                                            <form method="POST" action="{{ route('user.store') }}">
                                                @csrf
                                                <div class="form-group mt-2">
                                                    <input type="text" name="name" class="form-style"
                                                        placeholder="Your Full Name" value="{{ old('name') }}" required>
                                                    <i class="input-icon uil uil-user"></i>
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="email" name="email" class="form-style"
                                                        placeholder="Your Email" value="{{ old('email') }}" required>
                                                    <i class="input-icon uil uil-at"></i>
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="text" name="telefone" class="form-style"
                                                        placeholder="Your Telephone Number" value="{{ old('telefone') }}">
                                                    <i class="input-icon uil uil-phone"></i>
                                                    @error('telefone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password" class="form-style"
                                                        placeholder="Your Password" required>
                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password_confirmation"
                                                        class="form-style" placeholder="Confirm Password" required>
                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                </div>
                                                <button type="submit" class="btn mt-4">submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
