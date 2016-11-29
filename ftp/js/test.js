jQuery(document).ready(function($){

	$('#form').bind('submit', function(e){
		e.preventDefault();

		var value = $(this).children('input[name="xss"]').val();

		$.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: 'action=test&value=' + value,
			success: function(data)
			{
				console.log(data);
			}
		});
	});

});