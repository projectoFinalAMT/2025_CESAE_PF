<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Vendors -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900" rel="stylesheet">

    <!-- CSS próprio -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>

<body>
    <!-- Toast de sucesso -->
    @if(session('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
            <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">{{ session('success') }}</div>
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
                        <img src="{{ asset('image/logo2.png') }}" alt="Logo" width="180" class="imaglogo">
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
                                                        placeholder="Email" required>
                                                    <i class="input-icon uil uil-at"></i>
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password" class="form-style"
                                                        placeholder="Palavra Passe" required>
                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn mt-4">Submeter</button>

                                                <!-- Link para abrir modal de recuperação -->
                                                <p class="mb-0 mt-4 text-center">
                                                    <a href="#" class="link" data-bs-toggle="modal"
                                                        data-bs-target="#recuperarSenhaModal">Esqueceu a Palavra Passe?</a>
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- SIGN UP --}}
                                <div class="card-back">
                                    <div class="center-wrap">
                                        <div class="sectioncard text-center">
                                            <h4 class="  mt-4 mb-4 pb-3">Sign Up</h4>
                                            <form method="POST" action="{{ route('user.store') }}">
                                                @csrf
                                                <div class="form-group mt-2">
                                                    <input type="text" name="name" class="form-style"
                                                        placeholder="Nome" value="{{ old('name') }}" required>
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
                                                        placeholder="Sua Palavra Passe" required>
                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password_confirmation"
                                                        class="form-style" placeholder="Comfirmar Palavra Passe" required>
                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                </div>
                                                <button type="submit" class="btn mt-4 mb-4">Submeter</button>
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

    {{-- Modal de Recuperar Password --}}
<div class="modal fade"  id="recuperarSenhaModal" tabindex="-1" aria-labelledby="recuperarSenhaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body p-4">
                <!-- Título centralizado -->
                <h2 class="text-center mb-4" style="color: #696969;">Recuperar Palavra Passe</h2>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="emailModal" style="color: #696969;" class="form-label">Endereço de Email</label>
                        <input required name="email" type="email" class="form-control" id="emailModal"
                            placeholder="Digite seu email">
                            dfdfdf
                        @error('email')
                            <div class="text-danger mt-1">Email inválido</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-novo-curso w-100">Recuperar</button>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Modal de Reset de Password --}}
<div class="modal fade" id="resetSenhaModal" tabindex="-1" aria-labelledby="resetSenhaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">

            <!-- Título centralizado -->
            <h2 class="fw-bold text-center mb-4" style="color: #696969;">Redefinir Password</h2>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="emailReset" class="form-label" style="color: #696969;">Email</label>
                    <input type="email" class="form-control" id="emailReset" name="email"
                        value="{{ request()->email }}" placeholder="Digite seu email" required>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nova Password -->
                <div class="mb-3">
                    <label for="passwordReset" class="form-label" style="color: #696969;">Nova Palavra Passe</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        id="passwordReset" name="password" placeholder="Digite nova palavra passe" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmação Password -->
                <div class="mb-3">
                    <label for="passwordConfirmReset" class="form-label" style="color: #696969;">Confirme a Palavra Passe</label>
                    <input type="password" class="form-control" id="passwordConfirmReset"
                        name="password_confirmation" placeholder="Confirme a palavra passe" required>
                </div>

                <!-- Token oculto -->
                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <button type="submit" class="btn btn-novo-curso w-100">Submeter nova password</button>
            </form>
        </div>
    </div>
</div>


    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 <!-- Scripts modal, precisa estar aqui por causa do if -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(!empty($openResetModal) && $openResetModal)
            var resetModal = new bootstrap.Modal(document.getElementById('resetSenhaModal'));
            resetModal.show();

            // Preencher inputs do modal com email e token
            document.getElementById('emailReset').value = @json($email);
            document.querySelector('input[name="token"]').value = @json($token);
        @endif
    });
</script>

</body>
</html>
