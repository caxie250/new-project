$('#myForm').on('submit', function(event) {
    event.preventDefault();
    
    var formData = new FormData(this);
    formData.append('service_id', 'service_xtc40i6');
    formData.append('template_id', 'template_nu6734b');
    formData.append('user_id', 'PsFGwyNbp_D0iaO67');
 
    $.ajax('https://api.emailjs.com/api/v1.0/email/send-form', {
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false 
    }).done(function() {
        alert('Your mail is sent!');
    }).fail(function(error) {
        alert('Oops... ' + JSON.stringify(error));
    });
});
$('#Form').on('submit', function(event) {
    event.preventDefault();
    
    var formData = new FormData(this);
    formData.append('service_id', 'service_xtc40i6');
    formData.append('template_id', 'template_nu6734b');
    formData.append('user_id', 'PsFGwyNbp_D0iaO67');
 
    $.ajax('https://api.emailjs.com/api/v1.0/email/send-form', {
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false 
    }).done(function() {
        alert('Your mail is sent!');
    }).fail(function(error) {
        alert('Oops... ' + JSON.stringify(error));
    });
});
$('#form').on('submit', function(event) {
    event.preventDefault();
    
    var formData = new FormData(this);
    formData.append('service_id', 'service_xtc40i6');
    formData.append('template_id', 'template_nu6734b');
    formData.append('user_id', 'PsFGwyNbp_D0iaO67');
 
    $.ajax('https://api.emailjs.com/api/v1.0/email/send-form', {
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false 
    }).done(function() {
        alert('Your mail is sent!');
    }).fail(function(error) {
        alert('Oops... ' + JSON.stringify(error));
    });
});
