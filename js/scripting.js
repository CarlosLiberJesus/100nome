$(document).ready(function () {
  var mode = localStorage.getItem("theme");
  if (mode === null) {
    mode = "dark";
  }

  if (mode === "light") {
    $("#lightThemeButton").css("color", "#808080");
    $("#logoImg").attr("src", "img/dark-logo.png");
    $("body").attr("data-bs-theme", mode);
  } else {
    $("#darkThemeButton").css("color", "#808080");
    $("#logoImg").attr("src", "img/light-logo.png");
    $("#toggleThemeMode").attr("checked", true);
    $("body").attr("data-bs-theme", mode);
  }

  localStorage.setItem("theme", mode);

  var lang = localStorage.getItem("lang");
  if (lang === null) {
    lang = "pt";
  }
  setLanguageUI(lang);
});

function setLanguageUI(lang) {
  // Set flag
  localStorage.setItem("lang", lang);
  $("#currentFlag").removeClass("fi-gb fi-pt");
  if (lang === "pt") {
    $("#currentFlag").addClass("fi-pt");
  } else {
    $("#currentFlag").addClass("fi-gb");
  }
  // Set checkmark
  $(".lang-check").html("");
  if (lang === "pt") {
    $("#lang-pt .lang-check").html(
      '<i class="fa fa-check color-grey ms-2"></i>'
    );
  } else {
    $("#lang-en .lang-check").html(
      '<i class="fa fa-check color-grey ms-2"></i>'
    );
  }
  var dropdown = bootstrap.Dropdown.getOrCreateInstance(
    document.getElementById("dropdown")
  );
  dropdown.hide();
  updateTranslations(lang);
}

function changeThemeColor() {
  var mode = localStorage.getItem("theme");
  if (mode === null) {
    mode = "light";
  }

  if (mode === "dark") {
    mode = "light";
    $("#lightThemeButton").css("color", "#808080");
    $("#darkThemeButton").css("color", "#000000");
    $("#logoImg").attr("src", "img/dark-logo.png");
    $("body").attr("data-bs-theme", mode);
    $("#toggleThemeMode").attr("checked", false);
  } else {
    mode = "dark";
    $("#darkThemeButton").css("color", "#808080");
    $("#lightThemeButton").css("color", "#ffffff");
    $("#logoImg").attr("src", "img/light-logo.png");
    $("body").attr("data-bs-theme", mode);
    $("#toggleThemeMode").attr("checked", true);
  }

  localStorage.setItem("theme", mode);
}

const translations = {
  "banner-subtitle": {
    pt: "Porque o nome não interessa",
    en: "Because the name doesn't matter",
  },
  "subscribe-label": {
    pt: "Subscreva a nossa newsletter:",
    en: "Subscribe to our newsletter:",
  },
  "subscribe_message": {
    pt: "Deixe uma mensagem...",
    en: "Leave a message...",
  },
  "subscribe_email": {
    pt: "oseu@email.pt",
    en: "youremail.com",
  },
  "subscribe-button": {
    pt: "Subscrever",
    en: "Subscribe",
  },
};

function updateTranslations(lang) {
  $("#trans-banner-subtitle").text(translations["banner-subtitle"][lang]);
  $("#subscribe_label").text(translations["subscribe-label"][lang]);
  $("#subscribe_message").attr("placeholder", translations["subscribe_message"][lang]);
  $("#subscribe_email").attr("placeholder", translations["subscribe_email"][lang]);
  $("#subscribe_button").text(translations["subscribe-button"][lang]);
}
