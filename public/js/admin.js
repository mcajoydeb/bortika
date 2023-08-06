/******/ (() => { // webpackBootstrap
/*!*************************************!*\
  !*** ./resources/js/admin/admin.js ***!
  \*************************************/
$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
  });
  $('#sidebar-collapse-button').click(function () {
    setTimeout(function () {
      var is_collapsed = false;

      if ($('body').hasClass('sidebar-collapse')) {
        is_collapsed = true;
      }

      $.ajax({
        type: "post",
        url: window.sidebar_collpase_route,
        data: {
          is_collapsed: is_collapsed
        },
        success: function success(response) {
          var response_obj = JSON.parse(response);
          console.log('Sidebar Collpase:' + response_obj.is_collapsed);
        }
      });
    }, 200);
  });
  $(document).on('click', '.delete-table-item', function (e) {
    e.preventDefault();

    var _this = $(this);

    swal({
      title: window.confirmation_title,
      text: window.delete_confirmation,
      icon: "warning",
      buttons: true,
      dangerMode: true
    }).then(function (willDelete) {
      if (willDelete) {
        _this.closest('form').submit();
      }
    });
  });
});
$(window).on('load', function () {
  $('.fixed-page-center').fadeOut();
});
/******/ })()
;