// prevent user from spamming the submit form
$('.comment-form :submit').click(function (e){
    e.preventDefault();
    this.form.submit(); 
    this.disabled=true; 
});