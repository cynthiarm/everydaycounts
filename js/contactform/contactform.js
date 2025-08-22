jQuery(document).ready(function($) {
    "use strict";
  
    $('.contactForm').submit(function(e) {
      e.preventDefault(); // Evita el submit normal
  
      var f = $(this).find('.form-control'),
          ferror = false,
          emailExp = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i;
  
      // Validación de campos
      f.each(function() {
        var i = $(this);
        var rule = i.attr('data-rule');
  
        if (rule !== undefined) {
          var ierror = false;
          var exp;
          var pos = rule.indexOf(':', 0);
  
          if (pos >= 0) {
            exp = rule.substr(pos + 1, rule.length);
            rule = rule.substr(0, pos);
          }
  
          switch (rule) {
            case 'required':
              if (i.val().trim() === '') ierror = ferror = true;
              break;
            case 'minlen':
              if (i.val().trim().length < parseInt(exp)) ierror = ferror = true;
              break;
            case 'email':
              if (!emailExp.test(i.val())) ierror = ferror = true;
              break;
            case 'checked':
              if (!i.is(':checked')) ierror = ferror = true;
              break;
            case 'regexp':
              var reg = new RegExp(exp);
              if (!reg.test(i.val())) ierror = ferror = true;
              break;
          }
  
          i.siblings('.validation')
            .html(ierror ? (i.attr('data-msg') || 'Wrong input') : '')
            .show();
        }
      });
  
      if (ferror) return false;
  
      // Envío Ajax
      var str = $(this).serialize();
      var action = $(this).attr('action') || 'contactform/contact.php';
  
      $.ajax({
        type: "POST",
        url: action,
        data: str,
        success: function(msg) {
          if (msg.trim() === "OK_CONTACT_ES") {
            $("#sendmessage").addClass("show").html("Mensaje enviado correctamente.");
            $("#errormessage").removeClass("show").html("");
            $("#contactForm").find("input, textarea").val("");
          } else if (msg.trim() === "OK_CONTACT_EN") {
            $("#sendmessage").addClass("show").html("Your message has been sent.");
            $("#errormessage").removeClass("show").html("");
            $("#contactForm").find("input, textarea").val("");
          } else {
            $("#sendmessage").removeClass("show").html("");
            $("#errormessage").addClass("show").html(msg);
          }
        },
        error: function() {
          $("#sendmessage").removeClass("show").html("");
          $("#errormessage").addClass("show").html("❌ Error sending message.");
        }
      
      });
  
      return false;
    });
  
  });
  