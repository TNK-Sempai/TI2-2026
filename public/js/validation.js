document.addEventListener("DOMContentLoaded", function () {

  let feedback = document.getElementById("js-feedback");
  if (feedback) {
    setTimeout(function () {
      feedback.style.display = "none";
      var url = new URL(window.location);
      url.searchParams.delete("msg");
      history.replaceState(null, "", url);
    }, 3000);
  }

  const textarea = document.getElementById("message");
  const charCount = document.getElementById("char-count");
  const MAX_CHARS = 500;

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
    const usermailInput = document.getElementById("usermail");
    const phoneInput = document.getElementById("phone");
    const postcodeInput = document.getElementById("postcode");
    const messageInput = document.getElementById("message");

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const postcodeRegex = /^\d{4}$/;
    const phoneRegex = /^(\+32|0032|0)4\d{8}$/;

    const bars = document.querySelectorAll(".v-bar");
    const errorDiv = document.getElementById("js-errors");

    function updateBars() {
      let score = 0;

      if (emailRegex.test(usermailInput.value.trim())) score++;
      if (postcodeRegex.test(postcodeInput.value.trim())) score++;
      if (phoneRegex.test(phoneInput.value.trim())) score++;

      let msg = messageInput.value.trim();
      if (msg.length > 0 && msg.length <= MAX_CHARS) score++;

      bars.forEach(function (bar) {
        bar.className = "v-bar";
      });

      for (var i = 0; i < score; i++) {
        if (score === 1) bars[i].classList.add("--red");
        else if (score <= 3) bars[i].classList.add("--orange");
        else bars[i].classList.add("--green");
      }
    }

    [usermailInput, phoneInput, postcodeInput, messageInput].forEach(function (input) {
      input.addEventListener("input", updateBars);
    });

    form.addEventListener("submit", function (e) {
      let errors = [];

      if (!emailRegex.test(usermailInput.value.trim())) {
        errors.push(
          "L'adresse e-mail n'est pas valide (Ex : prenom.nom@mail.com)."
        );
      }

      if (!postcodeRegex.test(postcodeInput.value.trim())) {
        errors.push(
          "Le code postal doit contenir exactement 4 chiffres (ex : 1000)."
        );
      }

      if (!phoneRegex.test(phoneInput.value.trim())) {
        errors.push(
          "Le numéro de téléphone doit commencer par 04 et contenir 10 chiffres (ex : 0498150882)."
        );
      }

      let msg = messageInput.value.trim();
      if (msg.length === 0) {
        errors.push("Le message ne peut être vide.");
      } else if (msg.length > MAX_CHARS) {
        errors.push(
          "Le message ne doit pas dépasser " + MAX_CHARS + " caractères."
        );
      }

      if (errors.length > 0) {
        e.preventDefault();

        errorDiv.innerHTML = errors
          .map(function (err) {
            return "<p>" + err + "</p>";
          })
          .join("");

        errorDiv.className = "msg msg--error";
        errorDiv.style.display = "block";
        errorDiv.scrollIntoView({ behavior: "smooth", block: "center" });
      } else {
        errorDiv.innerHTML =
          "<p>Toutes les informations sont valides ✅</p>";
        errorDiv.className = "msg msg--success";
        errorDiv.style.display = "block";
      }
    });
  }

  // Dark mode toggle (jQuery)
  $(".btn-dark-toggle").on("click", function () {
    $("body").toggleClass("dark");

    if ($("body").hasClass("dark")) {
      $(".btn-dark-toggle").text("☀️ Light Mode");
    } else {
      $(".btn-dark-toggle").text("🌙 Dark Mode");
    }
  });
});