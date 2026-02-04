<?php
    include_once('../config.php');
    include_once (ADMIN_KERNEL.'session.php');
    sec_session_start(APPLICATION);

    include_once (ADMIN_KERNEL.'tools.php');
    include_once (ADMIN_KERNEL.'basedados.php');

    $mysqli = new BaseDeDados;

    if (login_check($mysqli) == false) {
        $mysqli->Fechar();
        $_SESSION['type'] = "E";
        $_SESSION['msg'] = "A sessão deve ter expirado. Por favor, entre de novo!";
        header('Location: ../index.php');
        exit();
    }
    $mysqli->Fechar();

    if ($_SESSION['perm'] < 1) {
        $_SESSION['type'] = "E";
        $_SESSION['msg'] = "Não tem permissão para esta zona do site.";
        header('Location: ../index.php');
        exit();
    }

    // Operacoes em utilizadores
    if(isset($_GET['task'])){
        if($_GET['task']=='logout'){
            logOut();
            header('Location: ../index.php');
            exit();
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>100nome Admin</title>
  <!-- Favicon
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> 
        -->
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="../css/admin_styles.css" rel="stylesheet" />
</head>

<body>
  <div class="d-flex" id="wrapper">
    <!-- Sidebar-->
    <div class="border-end bg-white" id="sidebar-wrapper">
      <div class="sidebar-heading border-bottom bg-light">100nome Admin</div>
      <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Subscrições</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Reuniões</a>
      </div>
    </div>
    <!-- Page content wrapper-->
    <div id="page-content-wrapper">
      <!-- Top navigation-->
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container-fluid">
          <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
              <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Perfil</a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#!">Editar</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="index.php?task=logout">Sair</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- Page content-->
      <div class="container-fluid">
        <h1 class="mt-4">100nome Admin</h1>
        <p>Bem vindo ao inicio</p>
        
      </div>
    </div>
  </div>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="../js/admin_scripts.js"></script>
</body>

</html>