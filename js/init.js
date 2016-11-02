$( document ).ready(function(){
    $('.parallax').parallax();
    $(".button-collapse").sideNav();
    $('.carousel.carousel-slider').carousel({full_width: true});
    $("#zoneStatus").hide();
    $("#reports").hide();
    $('select').material_select();
})



$("#reports-tab").click(function () {
    $("#home").hide();
    $("#legends").hide();
    $("#reports").show();
})


$("#reports-tab").click(function () {
    $("#content-holder").load('public/history.php');
})

$("#home-tab").click(function () {
    location.reload();
})
