<?php

function sec_session_start($session_name)
{

  $secure = SECURE;

  // iis sets HTTPS to 'off' for non-SSL requests
  if ($secure && isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
  } elseif ($secure) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 301);
    // we are in cleartext at the moment, prevent further execution and output
    die();
  }

  // This stops JavaScript being able to access the session id.
  $httponly = true;
  // Forces sessions to only use cookies.
  if (ini_set('session.use_only_cookies', 1) === FALSE) {
    //$this->setErro("Could not initiate a safe session (ini_set).");
    header("Location: index.php");
    exit();
  }
  // Gets current cookies params.
  $cookieParams = session_get_cookie_params();
  session_set_cookie_params(
    $cookieParams["lifetime"],
    $cookieParams["path"],
    $cookieParams["domain"],
    $secure,
    $httponly
  );
  // Sets the session name to the one set above.
  session_name($session_name);
  @session_start();            // Start the PHP session
  //session_regenerate_id(true);    // regenerated the session, delete the old one.
}

function isSecure()
{
  return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
}


function login($username, $password, $mysqli)
{

  $pergunta = "SELECT * FROM membros WHERE username = '{$username}' LIMIT 1";
  $mysqli->Pergunta($pergunta);

  if ($util = $mysqli->ResultadoSeguinte()) {

    $user_id = $util['id'];
    $email = $util['email'];
    $db_password = $util['password'];
    $salt = $util['salt'];
    $activo = $util['activo'];
    $lastmomento = $util['lastmomento'];
    $permissao = $util['permissao'];


    if ($activo == 0) { //Pré bloqueada
      $_SESSION['type'] = "E";
      if (@$lastmomento == '') {
        $_SESSION['msg'] = "A sua conta não está activa. Contacte a administração caso o sistema persista.";
      } else {
        $_SESSION['msg'] = "Esta conta foi desactivada a <u>{$lastmomento}</u>. Contacte a Equipa de Desenvolvimento como reactivar!";
      }
      return false;

    } elseif ($activo == 2) {
      $_SESSION['type'] = "E";
      $_SESSION['msg'] = "Esta conta foi desactivada por ação do utilizador (remoção de permissões ou pedido de eliminação de conta). Contacte a Equipa de Desenvolvimento para saber como reactivar!";
      return false;
    }
    // Valida excesso de erros
    else if (checkbrute($user_id, $mysqli) == true) {
      // Account is locked
      $pergunta = "UPDATE membros SET activo = 0, lastmomento = '" . date("Y-m-d H:i:s") . "' WHERE id = {$user_id} ;";
      $mysqli->Pergunta($pergunta);
      $pergunta = "INSERT INTO motivo VALUES(0,{$user_id},'" . mb_convert_encoding("Conta bloqueada por checkbrute()", "HTML-ENTITIES", "UTF-8") . "');";
      $mysqli->Pergunta($pergunta);

      // Send an email to user saying their account is locked
      /*
       TODO: Reactivar conta por email
              include_once("mail.php");
              $txt = "Foram detetados demasiados acessos incorrectos na sua conta. Contacte a Equipa de Desenvolvimento para mais esclarecimentos.";
      $topico = APPLICATION . " - Conta Bloqueada";
      enviaMail($email,$topico,$txt);
      */
      $_SESSION['type'] = "E";
      $_SESSION['msg'] = "Erro na autenticação! Conta Bloqueda! Demasiados pedidos foram verificados.";
      return false;


    }


    $password = hash('sha512', $password . $salt);
    if ($db_password == $password) {
      // Password is correct!
      // Get the user-agent string of the user.
      $user_browser = $_SERVER['HTTP_USER_AGENT'];
      // XSS protection as we might print this value
      $user_id = preg_replace("/[^0-9]+/", "", $user_id);
      $_SESSION['user_id'] = $user_id;
      $_SESSION['username'] = $username;
      $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
      $_SESSION['perm'] = $permissao;

      /*if($activo == 2 ){
          $_SESSION['type'] = "I";
          $_SESSION['msg'] = "As suas licenças expiraram a {$lastmomento}, consulte o <a href='?pageId=1'>registo</a> com as extender e usufrua dos descontos.";
      }*/
      $_SESSION['type'] = 'I';
      $_SESSION['msg'] = "Entrou com sucesso!";

      return true;

    } else {
      // Password is not correct
      // We record this attempt in the database
      $now = time();
      $pergunta = "INSERT INTO login_attempts VALUES ('{$user_id}', '{$now}')";
      $mysqli->Pergunta($pergunta);

      $_SESSION['type'] = "E";
      $_SESSION['msg'] = "Erro na autenticação! Password não corresponde ao utilizador.";

      return false;
    }

  } else {
    $_SESSION['type'] = "E";
    $_SESSION['msg'] = "Erro na autenticação! Utilizador não existente.";
    // No user exists.
    return false;
  }

}



function checkbrute($user_id, $mysqli)
{
  // Get timestamp of current time 
  $now = time();

  // All login attempts are counted from the past 2 hours. 
  $valid_attempts = $now - (2 * 60 * 60);

  $pergunta = "SELECT time FROM login_attempts WHERE user_id = {$user_id} AND time > '{$valid_attempts}'; ";
  $mysqli->Pergunta($pergunta);
  // If there have been more than 5 failed logins 
  if ($mysqli->NumeroResultados() > 5) {
    return true;
  } else {
    return false;
  }

}



function login_check($mysqli)
{
  // Check if all session variables are set 
  if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {

    $user_id = $_SESSION['user_id'];
    $login_string = $_SESSION['login_string'];
    $username = $_SESSION['username'];

    // Get the user-agent string of the user.
    $user_browser = $_SERVER['HTTP_USER_AGENT'];

    $pergunta = "SELECT password as password FROM membros WHERE id = {$user_id} LIMIT 1";
    $mysqli->Pergunta($pergunta);
    if ($util = $mysqli->ResultadoSeguinte()) {

      $login_check = hash('sha512', $util['password'] . $user_browser);
      if ($login_check == $login_string) {
        // Logged In!!!! 
        return true;
      } else {
        // Not logged in 
        return false;
      }

    } else {
      return false;
    }

  } else {
    // Not logged in 
    return false;
  }
}




function logOut()
{
  // Unset all session values 
  $_SESSION = array();

  // get session parameters 
  $params = session_get_cookie_params();

  // Delete the actual cookie. 
  setcookie(
    session_name(),
    '',
    time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]
  );

  // Destroy session 
  session_destroy();
}


function redirect($url)
{
  if (!headers_sent()) {
    header('Location: ' . $url);
    exit;
  } else {
    echo '<script type="text/javascript">';
    echo 'window.location.href="' . $url . '";';
    echo '</script>';
    echo '<noscript>';
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
    echo '</noscript>';
    exit;
  }
}

?>