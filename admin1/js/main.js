$(function() {
    $('.navbar-toggle').click(function() {
        $('.navbar-nav').toggleClass('slide-in');
        $('.side-body').toggleClass('body-slide-in');
        $('#search').removeClass('in').addClass('collapse').slideUp(200);
        $('.absolute-wrapper').toggleClass('slide-in');
    });

    $('#search-trigger').click(function() {
        $('.navbar-nav').removeClass('slide-in');
        $('.side-body').removeClass('body-slide-in');
        $('.absolute-wrapper').removeClass('slide-in');
    });
});

document.getElementById('log-out-link').addEventListener('click', function(event){
    event.preventDefault();
    if (confirm("Bạn có muốn đăng xuất không?")) {
        window.location.href = "../login/logout.php";
        }
});