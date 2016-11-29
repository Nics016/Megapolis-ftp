<?php 
// регистрация настроек
add_action('customize_register', function($customizer){
    $customizer->add_section(
        'section_main_page',
        array(
            'title' => 'Настройки темы: главная страница',
            'description' => 'Главная страница',
            'priority' => 1,
        )
    );

    $customizer->add_section(
        'section_dostavka_page',
        array(
            'title' => 'Настройки темы: бегунок',
            'description' => 'Бегунок расчета стоимости доставки',
            'priority' => 1,
        )
    );

    init_main_page_inputs($customizer);
});

function init_main_page_inputs($customizer){
    // logo
    $customizer->add_setting(
    'input_logo',
    array('default' => 'http://megapolis-mck.ru/wp-content/uploads/2016/11/logo1.png')
    );
    // контрол
    $customizer->add_control(
    'input_logo',
    array(
        'label' => 'Ссылка на изображение логотипа',
        'section' => 'section_main_page',
        'type' => 'text',
    )
    );

	 // телефон
	$customizer->add_setting(
    'input_phone',
    array('default' => '8-495-777-44-55')
	);
	// контрол телефона
	$customizer->add_control(
    'input_phone',
    array(
        'label' => 'Номер телефона',
        'section' => 'section_main_page',
        'type' => 'text',
    )
	);

	// подпись под телефоном
	$customizer->add_setting(
    'input_phone_subtext',
    array('default' => 'Общий многоканальный телефон')
	);
	// контрол
	$customizer->add_control(
    'input_phone_subtext',
    array(
        'label' => 'Подпись под номером',
        'section' => 'section_main_page',
        'type' => 'text',
    )
	);

	// адрес
	$customizer->add_setting(
    'input_address',
    array('default' => 'г. Москва, пр-т Вернадского 62, стр 3')
	);
	// контрол
	$customizer->add_control(
    'input_address',
    array(
        'label' => 'Адрес',
        'section' => 'section_main_page',
        'type' => 'text',
    )
	);

	// текст до категорий
	$customizer->add_setting(
    'input_categories_title',
    array('default' => 'Основные направления металлопродукции')
	);
	// контрол
	$customizer->add_control(
    'input_categories_title',
    array(
        'label' => 'Заголовок категорий',
        'section' => 'section_main_page',
        'type' => 'text',
    )
	);

    // email-1
    $customizer->add_setting(
    'input_email1',
    array('default' => 'info@megapolis-mck.ru')
    );
    // контрол
    $customizer->add_control(
    'input_email1',
    array(
        'label' => 'E-mail внизу страницы',
        'section' => 'section_main_page',
        'type' => 'text',
    )
    );

    // email-2
    $customizer->add_setting(
    'input_email2',
    array('default' => 'info@megapolis-mck.ru')
    );
    // контрол
    $customizer->add_control(
    'input_email2',
    array(
        'label' => 'E-mail, на который приходят заказы',
        'section' => 'section_main_page',
        'type' => 'text',
    )
    );

}

?>