$(function () {
    $('.tag-checkbox .cs-item').on("click", function (e) {
        e.preventDefault();
        $(this).toggleClass('active');
    });
});

