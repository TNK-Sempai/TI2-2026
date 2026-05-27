document.addEventListener("DOMContentLoaded", function () {
  const textarea = document.getElementById("message");
  const charCount = document.getElementById("char-count");
  const MAX_CHARS = 300;

  if (textarea && charCount) {
    textarea.addEventListener("input", function () {
      const current = this.value.length;
      charCount.textContent = current;

      const counter = charCount.closest(".char-counter");
      if (counter) {
        if (MAX_CHARS - current < 50) {
          counter.classList.add("--warning");
        } else {
          counter.classList.remove("--warning");
        }
      }
    });
  }

  const form = document.getElementById("guestbook-form");

  if (form) {
    form.addEventListener("submit", function (e) {
      const errors = [];

      const usermail = document.getElementById("usermail").value.trim();
      const phone = document.getElementById("phone").value.trim();
      const postcode = document.getElementById("postcode").value.trim();
      const message = document.getElementById("message").value.trim();

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const postcodeRegex = /^\d{4}$/;
      const phoneRegex = /^(\+32|0032|0)4\d{8}$/;

      if (!emailRegex.test(usermail)) {
        errors.push(
          "L'adresse e-mail n'est pas valide (Ex : prenom.nom@mail.com).",
        );
      }

      if (!postcodeRegex.test(postcode)) {
        errors.push(
          "Le code postal doit contenir exactement 4 chiffres (ex : 1000).",
        );
      }

      if (!phoneRegex.test(phone)) {
        errors.push(
          "Le numéro de téléphone doit commencer par 04 et contenir 10 chiffres (ex : 0498150882).",
        );
      }

      if (message.length === 0) {
        errors.push("Le message ne peut-être vide.");
      } else if (message.length > MAX_CHARS) {
        errors.push(
          "Le message ne doit pas dépasser " + MAX_CHARS + " caractères.",
        );
      }

      const errorDiv = document.getElementById("js-errors");

      if (errors.length > 0) {
        e.preventDefault();

        errorDiv.innerHTML = errors
          .map(function (err) {
            return "<p>" + err + "</p>";
          })
          .join("");

        errorDiv.style.display = "block";

        errorDiv.scrollIntoView({ behavior: "smooth", block: "center" });
      } else {
        errorDiv.style.display = "none";
        errorDiv.innerHTML = "";
      }
    });
  }
 $(".btn-dark-toggle").on("click", function () {
    $("body").toggleClass("dark");
 
    if ($("body").hasClass("dark")) {
      // On est en dark → le bouton propose de passer en light
      $(".btn-dark-toggle").text("☀️ Light Mode");
    } else {
      // On est en light → le bouton propose de passer en dark
      $(".btn-dark-toggle").text("🌙 Dark Mode");
    }
  });
});

