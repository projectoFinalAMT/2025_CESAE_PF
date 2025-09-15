<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"> <!--icons bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap.css') }}"> <!--Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"> <!--nosso css -->

     <!-- Material Icons ou Symbols-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet"> <!--Versão outlined (mais simples)-->

    <!-- CSS específico da página -->
    @yield('css')

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script> --}}
    <script src="{{ asset('assets/bootstrap.js')}}" defer></script> <!--Script bootstrap -->
    <script src="{{ asset('js/script.js') }}" defer></script> <!--Script nosso -->
     <script src="{{ asset('js/documentos.js') }}" defer></script> <!--Script nosso -->


    <!-- JS específico da página -->
    @yield('scripts')

</head>


<body>

   <!-- Botão hamburger visível apenas no mobile -->
<button class="btn btn-dark d-lg-none m-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
    <i class="bi bi-list"></i>
  </button>

  <!-- Sidebar offcanvas -->
  <div class="offcanvas-lg offcanvas-start bg-dark text-white sidebar" tabindex="-1" id="sidebarMenu">
  <div class="offcanvas-header d-lg-none">
  </div>

  <div class="offcanvas-body p-0 d-flex flex-column">
    <div class="text-center pt-3">
      <img src="{{asset('image/logo2.png')}}" alt="Logo" width="150" height="auto">
    </div>

    <div class="profile text-center pb-3">
           <img src="{{  Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('image/perfil.png') }}"
                alt="Foto de perfil" class="rounded-circle mb-2" width="110" height="110"
                style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#novoUserModal">
      <h5>{{ explode(' ',  Auth::user()->name)[0] }}</h5>
    </div>

    <a href="{{route ('casa')}}"><i class="bi bi-display"></i> Dashboard</a>
    <a href="{{route ('instituicoes')}}"><i class="bi bi-building-fill"></i> Instituições</a>
    <a href="{{ route('cursos') }}"><i class="bi bi-mortarboard"></i> Cursos</a>
    <a href="{{ route('modulos') }}"><i class="bi bi-journal-bookmark-fill"></i> Módulos</a>
    <a href="{{ route('alunos_view') }}"><i class="bi bi-people-fill"></i> Alunos</a>
    <a href="{{ route('calendarioBladeView') }}"><i class="bi bi-calendar-event-fill"></i> Calendário</a>
    <a href="{{ route('documentos') }}"><i class="bi bi-file-earmark-text-fill"></i> Documentos</a>
    <a href="{{ route('financas') }}"><i class="bi bi-currency-dollar"></i> Finanças</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<a href="#" id="sair" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="bi bi-box-arrow-left"></i> Sair
</a>

  </div>
</div>
    @yield('content') <!--permite usar nas outras blades o layout-->

    <!-- MDBootstrap JS -->  <!-- Permite usar a barra de progresso circular na página Finanças -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.js"></script>



</body>
</html>
