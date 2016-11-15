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

$("#prevStatus").click(function () {
    $('.carousel').carousel('prev');
})

$("#nextStatus").click(function () {
    $('.carousel').carousel('next');
})

function ScrollTo(id){
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    $('html,body').animate({
            scrollTop: $("#"+id).offset().top},
        'slow');
}
flatpickr(".flatpickr", {
    enableTime: true,
    defaultDate: new Date(),
    wrap: true,
    clickOpens: false // disable opening calendar by clicking on input
});

