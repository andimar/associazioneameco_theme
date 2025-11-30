(function($){

  wp.customize("home_title", function(value) {
      value.bind(function(newval) {
      $('#home_title').html(newval);
  	});
  });
  wp.customize("home_text", function(value) {
		value.bind(function(newval) {
		$("#home_text").html(newval);
		} );
	});
})(jQuery);
