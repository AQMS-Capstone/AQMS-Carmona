$( document ).ready(function(){
    $('.parallax').parallax();
    $(".button-collapse").sideNav();
    $('.carousel.carousel-slider').carousel({full_width: true});
    $("#zoneStatus").hide();
    $("#reports").hide();
    $('select').material_select();
    $('#home-tab').on('click',initialize)
})


//Functions
var optionIsVisible = true;

$( "#nextItem" ).click(function() {
    $('.carousel').carousel('next');

    if(optionIsVisible){
        $( "#plotOption" ).hide();
        optionIsVisible = false;
    }
    else{
        $( "#plotOption" ).show();
        optionIsVisible = true;
    }
});

$( "#prevItem" ).click(function() {
    $('.carousel').carousel('prev');
    if(optionIsVisible){
        $( "#plotOption" ).hide();
        optionIsVisible = false;
    }
    else{
        $( "#plotOption" ).show();
        optionIsVisible = true;
    }
});


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

