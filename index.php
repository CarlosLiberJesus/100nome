<?php
include_once('config.php');
include_once(KERNEL . 'session.php');
sec_session_start(APPLICATION);

if (isset($_GET['task'])) {
  include_once(KERNEL . 'tools.php');
  include_once(KERNEL . 'basedados.php');


  if ($_GET['task'] == 'login') {
    $mysqli = new BaseDeDados;
    if (isset($_POST['user'], $_POST['p'])) {
      $username = strtolower($_POST['user']);
      $password = $_POST['p']; // The hashed password.
      if (login($username, $password, $mysqli)) {
        $mysqli->Fechar();
        // Login success
        if ($_SESSION['perm'] >= 1) {
          header('Location: admin/index.php');
          exit();
        } else {
          header('Location: index.php');
          exit();
        }
      }
    }
    $mysqli->Fechar();

  } else if ($_GET['task'] == 'subscribe') {

    if (isset($_POST['email'])) {

      $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $email = filter_var($email, FILTER_VALIDATE_EMAIL);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $_SESSION['type'] = "E";
        $_SESSION['msg'] = "Erro no resgisto! O email fornecido, não é válido.";
        header('Location: index.php');
        exit();
      }

      $mysqli = new BaseDeDados;
      $pergunta = "SELECT * FROM newsletter WHERE email = '{$email}';";
      $mysqli->Pergunta($pergunta);
      $membro = $mysqli->ResultadoSeguinte();
      if (@$membro) {
        // verifica se o email já está registado
        if ($membro['activo'] != 0) {
          $_SESSION['type'] = "E";
          $_SESSION['msg'] = "Erro no registo! O Email [{$email}] já está registado na newsletter.";
          header('Location: index.php');
          exit();
        }
      }

      $pergunta = "INSERT INTO newsletter (email, message, date_subscribed, valid, md5) VALUES ('{$email}', '{$message}', NOW(), 1, MD5('{$email}'))";
      $mysqli->Pergunta($pergunta);

      $mysqli->Fechar();
      $_SESSION['type'] = 'I';
      $_SESSION['msg'] = "Registou na newsletter com sucesso! Obrigado...";

      header('Location: index.php');
      exit();
    }
    $mysqli->Fechar();
  }
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>100nome.org</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/flag-icons@6.7.0/css/flag-icons.min.css" rel="stylesheet"
    crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Condiment&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=UnifrakturCook:wght@700&display=swap" rel="stylesheet">
  <link href="./css/styles.css" rel="stylesheet">

</head>

<body data-bs-theme="light">

  <div class="mainFrame">
    <div class="w-100 px-3 special-position">
      <div class="row flex-nowrap" style="padding:20px 0px;">
        <div class="col-auto align-self-start">
          <a href="index.php">
            <img src="img/dark-logo.png" alt="100nome" title="100nome" width="125px" id="logoImg" />
          </a>
        </div>
        <div class="col flex-grow-1">&nbsp;</div>
        <div class="col-auto d-flex justify-content-end align-self-center">
          <span class="me-4">
            <i class="fa-solid fa-user" data-bs-toggle="modal" data-bs-target="#loginModal"
              style="cursor: pointer;"></i>
          </span>
          <span>
            <div class="dropdown">
              <a type="button" class="dropdown-toggle" href="#" id="dropdown" data-bs-toggle="dropdown"
                aria-expanded="false" data-bs-auto-close="outside" style="text-decoration-line: none; color: #808080">
                <i class="fi fi-pt m-0" id="currentFlag"></i>
              </a>

              <ul class="dropdown-menu" aria-labelledby="dropdown">
                <li>
                  <a class="dropdown-item" id="lang-en" onclick="javascript:setLanguageUI('en');return true;"><i
                      class="fi fi-gb"></i>English<span class="lang-check"></span></a>
                </li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <a class="dropdown-item" id="lang-pt" onclick="javascript:setLanguageUI('pt');return true;"><i
                      class="fi fi-pt"></i>Português<span class="lang-check"></span></a>
                </li>

              </ul>
            </div>
          </span>
        </div>
        <div class="col-auto align-self-center">
          <div class="themeContainer d-flex justify-content-end" onclick="changeThemeColor();return true;">
            <i class="fa-regular fa-sun mt-1 me-2" id="lightThemeButton"></i>
            <div class="form-check form-switch">
              <input class="form-check-input theme-switcher" type="checkbox" id="toggleThemeMode">
            </div>
            <i class="fa-regular fa-moon mt-1" id="darkThemeButton"></i>
          </div>
        </div>
      </div>
    </div>

<?php
    if (isset($_SESSION['msg']) && isset($_SESSION['type'])) {
      $msg = $_SESSION['msg'];
      $type = $_SESSION['type'];
      if ($type == 'E') {
        echo "<div class='alert alert-danger alert-dismissible fade w-50 mx-auto show mx-3 mt-3' role='alert' style='z-index: 10000;'>
              <strong>Erro!</strong> {$msg}
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
      } elseif ($type == 'I') {
        echo "<div class='alert alert-success alert-dismissible w-50 mx-auto fade show mx-3 mt-3' role='alert' style='z-index: 10000;'>
              <strong>Info:</strong> {$msg}
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
      }
      unset($_SESSION['msg']);
      unset($_SESSION['type']);
    }

    if (isset($_GET['page'])) {
      $page = $_GET['page'];
      $allowed_pages = ['home', 'about', 'services', 'contact']; // Example allowed pages
      if (in_array($page, $allowed_pages)) {
        include_once("public/{$page}.php");
      } else {
        include_once("public/404.php");
      }
    } else {
      include_once("public/home.php");
    }
?>

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="index.php?task=login" method="post" name="login_form">
              <label for="user" class="form-label">Utilizador:</label><input class="form-control" type="text"
                name="user" id="user" size="10" />
              <label for="password" class="form-label">Palavra-Passe:</label><input class="form-control" type="password"
                name="password" id="password" size="15" />
              <button type="submit" class="btn bg-grey mt-3" value="Login"
                onclick="formhash(this.form, this.form.password);" style="color:white;font-weight:bold">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>
    <script src="js/scripting.js"></script>
</body>

</html>