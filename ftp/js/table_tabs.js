// функция, которая создает вкладки таблиц 
// и задает для них события по клику
function set_tabs_click_events(){
	// создаем вкладки
	fill_out_tabs_names();

	// задаем функции при клике на вкладку
	$(".table-tabs-element").each(function( i ){
			$(this).bind("click", function(){
				click_element(i);
			});
		});

	// кликаем на первую вкладку
	click_element(0);
}

function fill_out_tabs_names(){
	// создаем вкладки внутри #table-tabs-id элемента
	var tab_text_before = "<span class='table-tabs-element'>";
	var tab_text_after = "</span>";

	// цикл по именам таблиц
	$("table").each(function( i ){
		var cur_element_text = tab_text_before +
							$(this).attr('name')
								+ tab_text_after;
		$("#table-tabs-id").append(cur_element_text);
	});
}

// функция при клике на определенный элемент
function click_element(element_id){
	// циклируем по таблицам, скрываем их все и показываем новую
	$("table").addClass("table-hidden");
	$("table:eq(" + element_id + ")").removeClass("table-hidden");

	// наконец, задаем стили для вкладок, чтобы кликнутая была выделена
	$(".table-tabs-element").removeClass("table-element-picked");
	$(".table-tabs-element:eq(" + element_id + ")").addClass("table-element-picked");
}