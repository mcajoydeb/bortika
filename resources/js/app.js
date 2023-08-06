require('./bootstrap');

require('alpinejs');

$('body').on('click', '.toggle-plus-minus-icon', function () {
    $(this).find('.plus').toggle();
    $(this).find('.minus').toggle();
});
