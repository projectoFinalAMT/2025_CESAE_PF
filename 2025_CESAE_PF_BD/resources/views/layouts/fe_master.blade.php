<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"> <!--icons bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap.css') }}"> <!--Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"> <!--nosso css -->

     <!-- Material Icons ou Symbols - botão Edit Lápis -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- CSS específico da página -->
    @yield('css')


    <script src="{{ asset('assets/bootstrap.js')}}" defer></script> <!--Script bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script> <!--Script nosso -->



</head>


<body>

   <!-- Botão hamburger visível apenas no mobile -->
<button class="btn btn-dark d-lg-none m-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
    <i class="bi bi-list"></i>
  </button>

  <!-- Sidebar offcanvas -->
  <div class="offcanvas-lg offcanvas-start bg-dark text-white sidebar" tabindex="-1" id="sidebarMenu">
  <div class="offcanvas-header d-lg-none">
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body p-0 d-flex flex-column">
    <div class="text-right py-3">
      <img src="{{asset('image/logo.png')}}" alt="Logo" width="100" height="auto" class="mb-3">
    </div>

    <div class="profile text-center py-3">
      <img src="{{asset('image/008.1.jpg')}}" alt="Foto de perfil" class="rounded-circle mb-2" width="120" height="120">
      <h5>Fernando</h5>
    </div>

    <a href="#"><i class="bi bi-display"></i> Dashboard</a>
    <a href="{{ route('cursos') }}"><i class="bi bi-mortarboard"></i> Cursos</a>
    <a href="#"><i class="bi bi-journal-bookmark-fill"></i> Módulos</a>
    <a href="#"><i class="bi bi-people-fill"></i> Alunos</a>
    <a href="#"><i class="bi bi-calendar-event-fill"></i> Calendário</a>
    <a href="#"><i class="bi bi-file-earmark-text-fill"></i> Documentos</a>
    <a href="#"><i class="bi bi-currency-dollar"></i> Finanças</a>
    <a href="#" id="sair"><i class="bi bi-box-arrow-left"></i> Sair</a>
  </div>
</div>
    @yield('content') <!--permite usar nas outras blades o layout-->

    <!-- MDBootstrap JS -->  <!-- Permite usar a barra de progresso circular na página Finanças -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.js"></script>

</body>
</html>
