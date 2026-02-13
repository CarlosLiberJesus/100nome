function formhash(form, password) {
  $("#user").removeClass("erro");
  // closeErro();
  // Create a new element input, this will be our hashed password field.
  var p = document.createElement("input");

  if (form.user.value == "") {
    openErro("Tem de indicar utilizador");
    $("#user").addClass("erro");
    return false;
    // Add the new element to our form.
  }
  if (form.password.value == "") {
    openErro("Tem de indicar password");
    $("#password").addClass("erro");
    return false;
    // Add the new element to our form.
  }

  form.appendChild(p);
  p.name = "p";
  p.type = "hidden";
  p.value = CryptoJS.SHA512(password.value);

  // Make sure the plaintext password doesn't get sent.
  password.value = "";

  // Finally submit the form.
  form.submit();
}

function regformhash(form, uid, email, password, conf) {
  $(".input").removeClass("erro");
  closeErro();

  // Check each field has a value
  if (
    uid.value == "" ||
    email.value == "" ||
    password.value == "" ||
    conf.value == "" ||
    form.nome.value == ""
  ) {
    if (uid.value == "") {
      openErro("Tem de indicar utilizador.");
      $("#username").addClass("erro");
      return false;
    }

    if (email.value == "") {
      openErro("Tem de indicar email de contato.");
      $("#email").addClass("erro");
      return false;
    }

    if (password.value == "" || conf.value == "") {
      openErro("Tem de indicar as duas passwords.");
      $("#password").addClass("erro");
      $("#confirmpwd").addClass("erro");
      return false;
    }

    if (form.nome.value == "") {
      openErro("Tem de indicar o seu nome.");
      $("#nome").addClass("erro");
      return false;
    }
  }

  // Check the username
  //var re = /^\w+$/;
  //alert(uid.value);
  //if(!re.test(uid.value)) {
  if ($(uid).is(":invalid")) {
    openErro(
      "Utilizador inválido. Deve começar com 1 letra minúscula, seguido de sequência de (letra minúscula ou número ou '_' ou '.' ou '-')."
    );
    $("#username").addClass("erro");
    return false;
  }

  //if(!email.checkValidity())
  if ($(email).is(":invalid")) {
    openErro("Tem de indicar uma morada de email válida.");
    $("#email").addClass("erro");
    return false;
  }

  /* old
    re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!re.test(email.value)){
        openErro("Tem de indicar uma morada de email válida.");
        $("#email").addClass("erro");
        return false;
    }*/

  /**
        // Check that the password is sufficiently long (min 6 chars)
        // The check is duplicated below, but this is included to give more
        // specific guidance to the user
        if (password.value.length < 6) {
            alert('A password deve ter mais de 6 caracteres.');
            form.password.focus();
            return false;
        }

        // At least one number, one lowercase and one uppercase letter
        // At least six characters

        var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
        if (!re.test(password.value)) {
            alert('A password deve conter pelo menos 1 algarismo, 1 letra minúscula e 1 letra maiúscula.  Por favor, tente de novo.');
            return false;
        }
    **/

  // Check password and confirmation are the same
  if (password.value != conf.value) {
    openErro("As passwords não coincidem. Por favor, tente de novo.");
    $("#password").addClass("erro");
    $("#confirmpwd").addClass("erro");
    return false;
  }

  if (!$("#permTermosPoliticas").is(":checked")) {
    openErro(
      "Tem de aceitar o termos e condições e as políticas de privacidade para continuar o seu registo."
    );
    return false;
  }

  /*
    if(form.contacto.value !=''){
        var n = form.contacto.value;
        if(!(Number(n)===n && n%1===0)){
            openErro("O contato deve ser um número.");
            $("#contacto").addClass("erro");
            return false;
        }
    }*/

  // Create a new element input, this will be our hashed password field.
  var p = document.createElement("input");

  // Add the new element to our form.
  form.appendChild(p);
  p.name = "p";
  p.type = "hidden";
  p.value = CryptoJS.SHA512(password.value);

  // Make sure the plaintext password doesn't get sent.
  password.value = "";
  conf.value = "";

  // Finally submit the form.
  form.submit();
  return true;
}
