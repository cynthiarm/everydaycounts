jQuery(document).ready(function($) {
  "use strict";

  $('.newsletter_form').submit(function(e) {
    e.preventDefault();

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
    var action = $(this).attr('action') || 'newsletter_form.php';

    $.ajax({
      type: "POST",
      url: action,
      data: str,
      success: function(msg) {
        msg = msg.trim();
        if (msg === 'OK') {
          $("#sendmessage_newsletter").addClass("show").html("Subscription successful!");
          $("#errormessage_newsletter").removeClass("show").html("");
          $('.newsletter_form').find("input, textarea").val("");
        } else {
          $("#sendmessage_newsletter").removeClass("show").html("");
          $("#errormessage_newsletter").addClass("show").html(msg);
        }
      },
      error: function() {
        $("#sendmessage_newsletter").removeClass("show").html("");
        $("#errormessage_newsletter").addClass("show").html("There was an error sending your message.");
      }
    });

    return false;
  });

});


