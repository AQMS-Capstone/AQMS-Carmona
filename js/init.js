$( document ).ready(function(){
    $('.parallax').parallax();
    $(".button-collapse").sideNav();
    $('.carousel.carousel-slider').carousel({full_width: true});
    $("#reports").hide();
    $('select').material_select();
    $('.parallax').parallax();
    $('.modal-trigger').leanModal();
    $('.collapsible').collapsible();

});

$("#reports-tab").click(function () {
    $("#home").hide();
    $("#legends").hide();
    $("#reports").show();
});

$("#sensor").off("click").on("click", function() {
    $("#sensor-content").fadeToggle("default");
});

$("#calculator").off("click").on("click", function() {
    $("#calculator-content").fadeToggle("default");
});

$("#reports-tab").click(function () {
    $("#content-holder").load('public/history.php');
});

$("#home-tab").click(function () {
    location.reload();
});

$("#prevStatus").click(function () {
    $('.carousel').carousel('prev');
});

$("#nextStatus").click(function () {
    $('.carousel').carousel('next');
});

function ScrollTo(id){
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    $('html,body').animate({
            scrollTop: $("#"+id).offset().top},
        'slow');
}
