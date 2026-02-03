<?php
  include_once('config.php');
  include_once (KERNEL.'session.php');
  sec_session_start(APPLICATION);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>100nome.org</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/flag-icons@6.7.0/css/flag-icons.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Condiment&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=UnifrakturCook:wght@700&display=swap" rel="stylesheet">
  <link href="./css/styles.css" rel="stylesheet">

</head>
<body data-bs-theme="light">

<div class="mainFrame">
  <div class="container">
    <div class="row flex-nowrap" style="padding-top:20px">
      <div class="col-auto align-self-start">
        <img src="img/dark-logo.png" alt="100nome" title="100nome" width="125px" id="logoImg" />
      </div>
      <div class="col flex-grow-1">&nbsp;</div>
      <div class="col-auto d-flex justify-content-end align-self-center">
        <span class="me-4">
          <i class="fa-solid fa-user" data-bs-toggle="modal" data-bs-target="#loginModal" style="cursor: pointer;"></i>
        </span>
        <span>
          <div class="dropdown">
            <a type="button" class="dropdown-toggle" href="#" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" style="text-decoration-line: none; color: #808080">
                <i class="fi fi-pt m-0" id="currentFlag"></i>
            </a>

            <ul class="dropdown-menu" aria-labelledby="dropdown">
                <li>
                    <a class="dropdown-item" id="lang-en" onclick="javascript:setLanguageUI('en');return true;"><i class="fi fi-gb"></i>English<span class="lang-check"></span></a>
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <a class="dropdown-item" id="lang-pt" onclick="javascript:setLanguageUI('pt');return true;"><i class="fi fi-pt"></i>Português<span class="lang-check"></span></a>
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

  <div class="banner">
    <h1 class="unifrakturcook-bold" style="font-size: 87px;">100 nome</h1>
    <h2 id="trans-banner-subtitle" class="condiment-regular" style="text-align: center;">Porque o nome não interessa</h2>
  </div>

  <div class="mx-3 pb-3">
  <form action="index.php?task=subscribe" method="post" name="subscribe_form">
    <div class="row g-2 justify-content-end ">
      <div class="col-12 col-md-auto d-flex flex-column align-items-end">
        <span class="mb-1 unifrakturcook-bold" style="display:list-item;font-size:large;" id="subscribe_label">Subscreva a nossa newsletter:</span>
        <input class="form-control mb-2 w-100 condiment-regular" type="email" name="email" id="subscribe_email" placeholder="oseu@email.com" required />
        <button type="submit" class="btn bg-grey mt-1 w-100 unifrakturcook-bold" value="Subscrever" style="color:white;font-weight:bold">Subscrever</button>
      </div>
      <div class="col-12 col-md-auto">
        <textarea class="form-control w-100 condiment-regular" placeholder="Deixe uma mensagem" rows="5" name="message" id="subscribe_message"></textarea>
      </div>
    </div>
  </form>
</div>

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
            <label for="user" class="form-label">Utilizador:</label><input class="form-control" type="text" name="user" id="user" size="10"/>
            <label for="password" class="form-label">Palavra-Passe:</label><input class="form-control" type="password" name="password" id="password" size="15" />
            <button type="submit" class="btn bg-grey mt-3" value="Login" onclick="formhash(this.form, this.form.password);" style="color:white;font-weight:bold">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <script type="text/JavaScript" src="js/sha512.js"></script>
  <script type="text/JavaScript" src="js/forms.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="js/scripting.js"></script>
</body>
</html>