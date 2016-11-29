// чтобы не потерялись после окончания работы функции init
	var multi = 1;
	var dimen = "1";

// инициализация
function init_range_car(multiplier, dimension){
	multi = multiplier;
	dimen = dimension;
	// id ползунка
	var range_car_id = "#range_car_id";

	// рассчет начального значения
	position_changed($(range_car_id).val());

	// назначаем функцию при изменении положения бегунка
	$(range_car_id).bind("input change", function(){
		position_changed($(this).val());
	})
}

function position_changed(val){
	$("#range_car_text_id").text(val + " " + dimen + " = " + val * multi + " Руб");
}

// инициализация
function init_range_cars(){ 
	// начальное значение
	$(".car").each(function(i){
		position_changed(
						 $(this).children("span").attr("id"),
						 $(this).children("input").val(),
						 $(this).children("input").attr("dimen"),
						 $(this).children("input").attr("multi"));
		});

	// назначаем функции при изменении положений бегунков
	$(".car").each(function(i){
		$(this).bind("input change", function(){
		position_changed(
						 $(this).children("span").attr("id"),
						 $(this).children("input").val(),
						 $(this).children("input").attr("dimen"),
						 $(this).children("input").attr("multi"));
		});
	});
}

function position_changed(elem, val, dimen, multi){
	console.log(elem + " " + val + " " + dimen + " " + multi);
	$("#"+elem).text(val + " " + dimen + " = " + val * multi + " Руб");
}