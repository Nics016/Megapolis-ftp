jQuery(document).ready(function($){


var validation = {
	"customer_name_id": false,
	"customer_email_id": false,
	"customer_phone_id": false
}


var patterns = {
	"customer_name_id": /^[а-яА-ЯёЁa-zA-Z ]+$/,
	"customer_email_id": /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/,
	"customer_phone_id": /^((8|\+7)[\-]?)?(\(?\d{3}\)?[\-]?)?[\d\-]{7,10}$/
}


// присваивает событие по нажатии на клавишу для проверки инпутов по паттерну

var inputFields = $('.contactForm-info-field');

inputFields.keyup(function(){

	//записываем все, что нудно в перменные
	var elem = $(this);

	var elemId = elem.attr('id');

	var value = elem.val();
	var parent = elem.closest('.input-container');
	var error = parent.children('.contactForm-info-error');

	if ( typeof elemId != 'undefined' )
	{

		//проверим всю шелуху на регулярки
		if ( patterns[elemId].test(value) )
		{
			validation[elemId] = true;
			error.slideUp(200);
		}
		else
		{
			validation[elemId] = false;
			error.slideDown(200);
		}
	}

});


//сабмит

var form = $('#cart_form');

form.bind('submit', function(event){
	event.preventDefault();


	for ( key in validation )
	{
		if( !validation[key] )
		{
			console.log('tut');
			inputFields.trigger('keyup');
			return false;
		}
	}

	var ajaxData = 'action=checkout&' + $(this).serialize();

	console.log(ajaxUrl + " " + ajaxData);

	$.ajax({
		url: ajaxUrl,
		type: 'POST',
		data: ajaxData,
		success: function(data){

			var response = JSON.parse(data);

			//если  все прошло успешно, перенаправим пользователя, если нет, выведем ошибку
			if ( response.status = 'ok' )
				window.location.href = '/checkout';
			else
				alert('Ошибка, напишите нам нам, пожалуйста, на почту!');
		}
	});

});

});
