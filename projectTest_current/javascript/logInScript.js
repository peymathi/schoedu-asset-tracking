$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});


$('#loginBtn').click(function(){
   window.location = "../index.php";
});