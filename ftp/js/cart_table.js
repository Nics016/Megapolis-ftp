jQuery(document).ready(function($){

	//csrf
	var csrf = $('#csrf').val();

	//сделаем удаление товара
	var removeTovarBtn = $('a[data-event="remove-tovar"]');
	removeTovarBtn.bind('click', function(event){

		event.preventDefault();

		var elem = $(this);
		var parent = elem.closest('tr');
		var tovarId = parent.attr('data-tovar-id');

		//посылаем аякс запрос
		$.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: 'action=remove_cart&tovar_id=' + tovarId + '&csrf=' + csrf,
			success: function(data)
			{	
				var response = JSON.parse(data);
				var status = response.status;

				switch( status )
				{
					case 'ok':

						//измени сумму
						var sum = +response.sum;
						var orderSum = $('span[data-type="order-sum"]');
						var currentSum = +orderSum.html();
						orderSum.text(currentSum - sum);


						//изменим корзину
						var cartCountTovar = +$('span[data-type="tovars-num"]').html();
						$('span[data-type="tovars-num"]').text(cartCountTovar - 1);

						var cartTotalSum = +$('span[data-type="tovars-sum"]').html();
						$('span[data-type="tovars-sum"]').text(cartTotalSum - sum);

						//удалим строку товара
						parent.remove();

						break;

					case 'empty':
						window.location.reload();
						break;
				}

			}
		});

	});

	//изменение количества товаров
	var changeNum = $('input[data-event="change-num"]');
	changeNum.bind('change', function(){

		//соберем все данные
		var elem = $(this);
		var parent = elem.closest('tr');

		//берем количество и id товара
		var tovarNum = +elem.val();
		var tovarId = +parent.attr('data-tovar-id');

		//блоки общей суммы товара, общей суммы коризины и блок итоговой усммы после таблицы
		var tovarSum = parent.children('td').children('span[data-type="tovar-sum"]');
		var cartTotalSum = $('span[data-type="tovars-sum"]');
		var orderSum = $('span[data-type="order-sum"]');

		//для првоерки
		var pattern = /^[0-9]+$/;

		//сюда всю сумму будем записывать старую сумму
		var oldSum = 0;

		//сюда новую
		var newSum = 0;


		//проверим и то и то
		if ( typeof tovarId != 'NaN' && typeof tovarNum != 'NaN' && tovarId > 0 && tovarNum > 0 )
		{
			for( var i = 0; i < cart.length; i++ )
			{	
				//если айди товара совпдаетт с айди товара в массиве
				if ( cart[i][0] == tovarId )
				{	
					//посчитаем старую и новую  сумму 
					oldSum = cart[i][1] * cart[i][2];
					newSum = tovarNum * cart[i][2];

					//и изменим количество товаров в массиве
					cart[i][1] = tovarNum;
				}
			}

			//теперь измени везде общие суммы

			//общая сумма одного товара в его строке
			tovarSum.text(newSum);

			//изменим значение суммы в корзине
			var cartCurrentSum = +cartTotalSum.html();
			cartTotalSum.text(cartCurrentSum - oldSum + newSum);

			//изменим знаечние под таблицей товаров
			var currentOrderSum = +orderSum.html();
			orderSum.text(currentOrderSum - oldSum + newSum);

			//и пошлем аякс
			$.ajax({
				url: ajaxUrl,
				type: 'POST',
				data: 'action=change_cart_num&tovar_id=' + tovarId 
					   + '&num=' + tovarNum + '&csrf=' + csrf
			});

		}
		else if ( tovarNum <= 0 )
		{
			elem.val(1);
			changeNum.change();
		}

	});

});