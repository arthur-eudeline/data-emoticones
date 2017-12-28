function calcVH() {
    $('#cover').innerHeight( $(this).innerHeight() );
    $('#about').innerHeight( $(this).innerHeight() );
}
(function($) { 
  calcVH();
  $(window).on('orientationchange', function() {
    calcVH();
  });
})(jQuery);