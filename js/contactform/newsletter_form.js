$(document).ready(function () {
  $("#newsletter_form").on("submit", function (e) {
    e.preventDefault();

    var $form = $(this);

    // Evitar doble envío
    if ($form.data("sending") === true) return false;
    $form.data("sending", true);

    var email = $form.find("input[name='newsletter_email']").val().trim();
    var validationDiv = $form.find(".validation");
    var type = parseInt($form.find("input[name='type']").val()) || 1; // 1=ES, 2=EN

    validationDiv.html("").hide();

    // Mensajes según idioma
    var msgEmpty = (type === 1) ? 'Por favor, ingrese un correo electrónico.' : 'Please enter an email address.';
    var msgInvalid = (type === 1) ? 'Escriba una dirección de correo electrónico válida.' : 'Please enter a valid email address.';

    // Validación básica
    if (email === '') {
        validationDiv.html(msgEmpty).show();
        $form.data("sending", false);
        return false;
    }

    var emailExp = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i;
    if (!emailExp.test(email)) {
        validationDiv.html(msgInvalid).show();
        $form.data("sending", false);
        return false;
    }

      $.ajax({
          type: "POST",
          url: action,
          data: str,
          success: function (msg) {
              msg = msg.trim();
              if (msg === "OK_NEWSLETTER_ES") {
                  $("#sendmessage_newsletter").addClass("show").html("¡Gracias por suscribirte!");
                  $("#errormessage_newsletter").removeClass("show").html("");
                  $('#newsletter_form')[0].reset();
              } else if (msg === "OK_NEWSLETTER_EN") {
                  $("#sendmessage_newsletter").addClass("show").html("Thanks for subscribing!");
                  $("#errormessage_newsletter").removeClass("show").html("");
                  $('#newsletter_form')[0].reset();
              } else {
                  $("#errormessage_newsletter").addClass("show").html(msg);
              }
              $("#newsletter_form").data("sending", false);
          },
          error: function () {
              $("#errormessage_newsletter").addClass("show").html("❌ Error de conexión.");
              $("#newsletter_form").data("sending", false);
          }
      });
  });
});