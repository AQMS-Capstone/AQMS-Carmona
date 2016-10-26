$( document ).ready(function(){
    $(".button-collapse").sideNav();
    $('.carousel.carousel-slider').carousel({full_width: true});


})

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

$("#home-tab").click(function () {
    $("#home").show();
    $("#reports").hide();
})

$("#reports-tab").click(function () {
    $("#home").hide();
    $("#reports").show();
})