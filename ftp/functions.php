<?php
$cars = array();

add_filter('show_admin_bar', '__return_false'); //скроем на время админ бар сверху
//подключаем стили
function _s_styles()
{
	wp_register_style('main', get_template_directory_uri(). '/css/style.css');
	wp_enqueue_style('main', get_template_directory_uri(). '/css/style.css');
	wp_register_style('main_categories', get_template_directory_uri(). '/css/categories.css');
	wp_enqueue_style('main_categories', get_template_directory_uri(). '/css/categories.css');
	wp_register_style('category', get_template_directory_uri(). '/css/category.css');
	wp_enqueue_style('category', get_template_directory_uri(). '/css/category.css');
	wp_register_style('table', get_template_directory_uri(). '/css/table.css');
	wp_enqueue_style('table', get_template_directory_uri(). '/css/table.css');
	wp_register_style('footer', get_template_directory_uri(). '/css/footer.css');
	wp_enqueue_style('footer', get_template_directory_uri(). '/css/footer.css');
	wp_register_style('category-articles', get_template_directory_uri(). '/css/category-articles.css');
	wp_enqueue_style('category-articles', get_template_directory_uri(). '/css/category-articles.css');
	wp_register_style('cart', get_template_directory_uri(). '/css/cart.css');
	wp_enqueue_style('cart', get_template_directory_uri(). '/css/cart.css');
	wp_register_style('slider_input', get_template_directory_uri(). '/css/slider_input.css');
	wp_enqueue_style('slider_input', get_template_directory_uri(). '/css/slider_input.css');
	wp_register_style('sidebar', get_template_directory_uri(). '/css/sidebar.css');
	wp_enqueue_style('sidebar', get_template_directory_uri(). '/css/sidebar.css');

	wp_register_style('fontawesome', get_template_directory_uri(). '/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('fontawesome', get_template_directory_uri(). '/font-awesome/css/font-awesome.min.css');
}

add_action('wp_enqueue_scripts', '_s_styles');

//подключаю скрипты

function _s_scripts()
{
	//своя библиотека jquery, не вордпрессовска
	wp_deregister_script('jquery');
	wp_register_script('jquery',  get_template_directory_uri(). '/js/jquery.js');
	wp_enqueue_script('jquery');

	if ( !is_page('cart') )
	{
		//функция для вывода вкладок таблиц
		wp_register_script('table_tabs',  get_template_directory_uri(). '/js/table_tabs.js', array('jquery'));
		wp_enqueue_script('table_tabs');

		//функция таблицы товаров
		wp_register_script('tovar_tables',  get_template_directory_uri(). '/js/tovar_tables.js', array('jquery', 'table_tabs'));
		wp_enqueue_script('tovar_tables');

		//для бегунка с машинкой
		//функция таблицы товаров
		wp_register_script('car_input',  get_template_directory_uri(). '/js/range_car.js', array('jquery'));
		wp_enqueue_script('car_input');
	}


	if ( is_page('cart') )
	{
		//валидация формы корзины
		wp_register_script('cart_form_validation',  get_template_directory_uri(). '/js/cart_form_validation.js', array('jquery'), null);
		wp_enqueue_script('cart_form_validation');

		//для таблицы корзины
		wp_register_script('cart_table',  get_template_directory_uri(). '/js/cart_table.js', array('jquery'));
		wp_enqueue_script('cart_table');

	}

	if ( is_page('test') )
	{
		wp_register_script('test',  get_template_directory_uri(). '/js/test.js', array('jquery'), null);
		wp_enqueue_script('test');
	}
}

add_action('wp_enqueue_scripts', '_s_scripts');

//регистрация меню
if ( function_exists( 'register_nav_menus' ) )
{
	register_nav_menus(
		array(
			'top-menu'=>__('Top Menu'),
			'left-menu'=>__('Left Menu')
		)
	);
}

function custom_menu(){
	echo '<ul>';
	wp_list_pages('title_li=&');
	echo '</ul>';
}

// Регистрация сайдбаров
function register_wp_sidebars() {
	/* В левая боковой колонке - первый сайдбар */
	register_sidebar(
		array(
			'id' => 'left_sideb', // уникальный id
			'name' => 'Левый сайдбар', // название сайдбара
			'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
			'before_widget' => '<div id="%1$s" class="">', // по умолчанию виджеты выводятся <li>-списком
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
			'after_title' => '</h3>'
		)
	);
	// register_sidebar(...
}
add_action( 'widgets_init', 'register_wp_sidebars' );

// Добавляем кнопку добавления миниатюры поста
add_theme_support( 'post-thumbnails' );

// Добавляем страничку настроек темы
require_once("options_page.php");
	
// Shortcode бегунка с машинкой
function car_shortcodes_init()
{
    function car_shortcode($atts = [], $content = null)
    {
        // normalize attribute keys, lowercase
    	$atts = array_change_key_case((array)$atts, CASE_LOWER);
 
    	// override default attributes with user attributes
    	$wporg_atts = shortcode_atts([
                                     'min' => '1',
                                     'max' => '20',
                                     'step' => '1',
                                     'rubstep' => "50",
                                     'distancein' => "КМ",
                                     'img' => get_template_directory_uri(). "/img/range_car.png",
                                     "color" => "blue"
                                 ], $atts, $tag);
    	array_push($GLOBALS['cars'], $wporg_atts);        
        // always return
        return $content;
    }
    add_shortcode('car', 'car_shortcode');
}

add_action('init', 'car_shortcodes_init');

// --- CUSTOM FUNCTIONS ---
// Функции обработки категорий
	// функция для вырезания src картинки из img
	function getImageUrl($img){
		$iImgPos = strpos($img,"src=") + 5;
		$sSrcStart = substr($img, $iImgPos);
		$iQuotePos = strpos($sSrcStart, '"');
		$answ = substr($sSrcStart, 0, $iQuotePos); 
		return $answ;
	}
		
	// загружаем список категорий в массив $terms
	// чтобы позже получить их thumbnails
	function get_children_terms($parent_id){
		$taxonomy = 'category';
	    $args = array(
	        'orderby'           => 'id', 
	        'order'             => 'ASC',
	        'hide_empty'        => false, 
	        'exclude'           => array(), 
	        'exclude_tree'      => array(), 
	        'include'           => array(),
	        'number'            => '', 
	        'fields'            => 'all', 
	        'slug'              => '',
	        'parent'            => '',
	        'hierarchical'      => true, 
	        'child_of'          => $parent_id,
	        'childless'         => false,
	        'get'               => '', 
	        'name__like'        => '',
	        'description__like' => '',
	        'pad_counts'        => false, 
	        'offset'            => '', 
	        'search'            => '', 
	        'cache_domain'      => 'core',
	    );
	    $terms = get_terms($taxonomy, $args);
	    return $terms;
	}

// вывод названия категории, которая является самым высшим предком
// данной категории, не доходя до нулевой
function Get_Cat_Ancestor_Name($cat_ID)
{	
	$cur_Parent_ID = -1;
	$cur_Category = -1;
	$cur_Cat_ID = $cat_ID;

	// пока $cur_Parent_ID != 0, идем вверх по дереву категорий
	do {
		$cur_Category = get_category($cur_Cat_ID);
		$cur_Parent_ID = $cur_Category->category_parent;
		if ($cur_Parent_ID != 0)
		{
			$cur_Cat_ID = $cur_Parent_ID;
		}
	} while ($cur_Parent_ID != 0);

	// наконец, возвращаем название категории предка
	$answ = get_cat_name($cur_Cat_ID);
	return $answ;
}

// определяет, есть ли у текущей категории дети
function category_has_children() {
	global $wpdb;   
	$term = get_queried_object();
	$category_children_check = $wpdb->get_results(" SELECT * FROM wp_term_taxonomy WHERE parent = '$term->term_id' ");
    if ($category_children_check) {
        return true;
    } else {
       return false;
    }
}  


//класс для вывода таблиц

class productTableModel
{


	public function is_table($table_id)
	{	
		global $wpdb;
		$query = "SELECT ID FROM tovars_tables WHERE ID = $table_id";
		$result = $wpdb->get_results($query, 'ARRAY_A');

		if ( !empty($result) )
			return true;
		else
			return false;
	}

	public function get_table_data($table_id)
	{
		global $wpdb;
		$query = "SELECT name, price, attributes FROM tovars_tables WHERE ID = $table_id";
		$result = $wpdb->get_results($query, 'ARRAY_A');

		//для удобства
		$result = $result[0];
		return $result;
	}

	//метод для вывода товаров
	public function get_tovars( $table_id )
	{
		global $wpdb;
		$query = "SELECT tovars_ids FROM tovars_tables WHERE ID = $table_id";
		$tovars_ids = $wpdb->get_results($query, 'ARRAY_A');

		//проверм, есть ли такая таблицы
		if ( $tovars_ids != NULL )
		{
			
			//берем товары по их id
			$tovars_ids = unserialize($tovars_ids[0]['tovars_ids']);

			// цикле сформируем запрос
			$query = "SELECT * FROM tovars WHERE ";
			for ( $i = 0; $i < count($tovars_ids); $i++ ){

				$ID = $tovars_ids[$i];
				$query .= ( $i == 0 ) ? "ID = $ID" : " OR ID = $ID";

			}

			$tovars = $wpdb->get_results($query, 'ARRAY_A');
			return $tovars;

		}
		else
			return false;
	}

	public function view_table($table_data, $tovars)
	{
		//ся грязь происходит в шаблоне
		require('templates/table_view_template.php');
	}
}


//функция для вывода перменных, удобно
function dd(...$vars)
{
	for( $i = 0; $i < count($vars); $i++ )
	{
		echo '<pre>';
		var_dump($vars[$i]);
		echo '</pre>';
	}
}


//Функции для безопасности
function csrf()
{
	if ( isset($_SESSION['csrf_token']) )
		return $_SESSION['csrf_token'];
	else
	{
		$bytes = random_bytes(32);
		$_SESSION['csrf_token'] = bin2hex($bytes);
		return $_SESSION['csrf_token'];
	}
}


//аякс добавление товаров в корзину
add_action('wp_ajax_add_cart', 'add_cart');
add_action('wp_ajax_nopriv_add_cart', 'add_cart');

function add_cart()
{
	session_start();
	
	//обозначим перменные
	$tovar_id = $_POST['tovar_id'];
	$num = $_POST['num'];
	$csrf = $_POST['csrf'];
	//проверим csrf защиту
	if ( $csrf == csrf() )
	{
		//проверим на регулярку товар и количество
		$pattern = '/^[0-9]+$/';
		if ( preg_match($pattern, $tovar_id) && preg_match($pattern, $num) )
		{

			settype($num, 'integer');

			//проверем количество товара
			if ( $num > 0 )
			{
				//теперь проверим наличие товара
				global $wpdb;
				$query = "SELECT price FROM tovars WHERE ID = $tovar_id LIMIT 1";
				$result = $wpdb->get_results($query, 'ARRAY_A');
				if ( $result )
				{
					//теперь проверим наш массив
					if ( isset($_SESSION['cart']) )
					{
						//переменная, которая указывает, есть ли в массиве данный айди товара
						$has_tovar = false;
						$price = $result[0]['price'];

						//для хорошего вывода
						settype($tovar_id, 'integer');
						settype($price, 'float');

						//переберем массив, все узнаем
						for ( $i = 0; $i < count($_SESSION['cart']); $i++ )
						{
							//проверим, есть ли такой товар у нас
							if ( $_SESSION['cart'][$i][0] == $tovar_id )
							{
								//если да, то изменим его количество и изменим переменную has_tovar
								$_SESSION['cart'][$i][1] = $num;
								$_SESSION['cart'][$i][2] = $price;
								$has_tovar = true;
							}
						}
						//если товара нет в массиве, то создадим
						if ( !$has_tovar )
						{
							$_SESSION['cart'][] = [$tovar_id, $num, $price];
						}
						dd($_SESSION['cart']);
					}
					else
					{
						//если нет, не беда, создадим
						$_SESSION['cart'] = [];

						//взяли цену
						$price = $result[0]['price'];

						settype($tovar_id, 'integer');
						settype($price, 'float');

						$_SESSION['cart'][] = [$tovar_id, $num, $price];
						dd($_SESSION['cart']);
					}
				}
			}
		}
	}
	wp_die();
}


//удаление товара из корзины

add_action('wp_ajax_remove_cart', 'remove_cart');
add_action('wp_ajax_nopriv_remove_cart', 'remove_cart');

function remove_cart()
{

	session_start();

	$tovar_id = $_POST['tovar_id'];
	$csrf = $_POST['csrf'];

	//проверим csrf защиту
	if ( $csrf == csrf() )
	{

		//проверим на регулярку товар и количество
		$pattern = '/^[0-9]+$/';
		if ( preg_match($pattern, $tovar_id) )
		{

			//проверяем товара по дб и на всякий случай проверим сессию
			global $wpdb;
			$query = "SELECT price FROM tovars WHERE ID = $tovar_id LIMIT 1";
			$result = $wpdb->get_results($query, 'ARRAY_A');

			if ( $result && isset($_SESSION['cart']) )
			{

				//приведем все к числому виду
				settype($tovar_id, 'integer');
				settype($price, 'float');

				//удалим из массива нужную строку
				for ( $i = 0; $i < count($_SESSION['cart']); $i++ )
				{
					//проверим, есть ли такой товар у нас
					if ( $_SESSION['cart'][$i][0] == $tovar_id )
					{
						
						//найдем общую сумму товар и удалим его
						$num = $_SESSION['cart'][$i][1];
						$price = $_SESSION['cart'][$i][2];				
						$sum = $num * $price;

						//удаляем массив
						unset($_SESSION['cart'][$i]);
						$_SESSION['cart'] = array_values($_SESSION['cart']);						

					}
				
				}


				//проверим, все ли посчиталось
				if (isset($sum))
				{
					//проверим,может послдений товар
					if (empty($_SESSION['cart']))
					{
						$response = [
							'status' => 'empty'
						];

						echo json_encode($response);
					}
					else
					{
						$response = [
							'status' => 'ok',
							'sum' => $sum
						];
						
						echo json_encode($response);
					}

				}

			}

		}

	}


	wp_die();
}

//изменние количества товаров
add_action('wp_ajax_change_cart_num', 'change_cart_num');
add_action('wp_ajax_nopriv_change_cart_num', 'change_cart_num');

function change_cart_num()
{
	session_start();

	$tovar_id = $_POST['tovar_id'];
	$num = $_POST['num'];
	$csrf = $_POST['csrf'];

	//проверим csrf защиту
	if ( $csrf == csrf() )
	{
		//проверим на регулярку товар и количество
		$pattern = '/^[0-9]+$/';
		if ( preg_match($pattern, $tovar_id) && preg_match($pattern, $num) )
		{
			//проверим количество и массив товаров
			if ( $num > 0 && isset($_SESSION['cart']) )
			{

				//приведем все к числому виду
				settype($tovar_id, 'integer');
				settype($num, 'integer');

				//удалим из массива нужную строку
				for ( $i = 0; $i < count($_SESSION['cart']); $i++ )
				{
					//проверим, есть ли такой товар у нас
					if ( $_SESSION['cart'][$i][0] == $tovar_id )
					{	
						//изменим количество товара
						$_SESSION['cart'][$i][1] = $num;
					}
				
				}

			}
		}
	}

	wp_die();
}

add_action('wp_ajax_checkout', 'checkout');
add_action('wp_ajax_nopriv_checkout', 'checkout');

function checkout()
{	
	session_start();
	global $wpdb;

	//остановимс скрипт, если нет сесси
	if(!isset($_SESSION['cart']) || empty($_SESSION['cart']))
		exit;

	//регулярки
	$name_pattern = '/^[а-яА-ЯёЁa-zA-Z ]+$/u';
	$email_pattern = '/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/';
	$phone_pattern = '/^((8|\+7)[\-]?)?(\(?\d{3}\)?[\-]?)?[\d\-]{7,10}$/';

	//подготовим и обезопасим запросы
	$name = preg_match($name_pattern, $_POST['name']) ? $_POST['name'] : '';
	$email =  preg_match($email_pattern, $_POST['email']) ? $_POST['email'] : '';
	$phone = preg_match($phone_pattern, $_POST['phone']) ? $_POST['phone'] : '';
	$phone = trim($phone);
	$adress = htmlspecialchars($_POST['adress']);
	$comment = htmlspecialchars($_POST['comment']);
	$cart = serialize($_SESSION['cart']);

	//замутим запрос
	$query = "INSERT INTO tovars_orders ( name, email, phone, adress, commentary, cart ) VALUES ( %s, %s, %s, %s, %s, %s )";

	//формируем массив со значениями
	$data = [ $name, $email, $phone, $adress, $comment, $cart ];

	//подготовленный запрос
	$prepare = $wpdb->prepare($query, $data);

	//обновляем бд
	$insert = $wpdb->query($prepare);

	//если все ок пишем письма и тд
	if ( $insert )
	{	
		$order_id = $wpdb->insert_id;

		if ( $email != '' )
		{

			//отправляем письмо покупателю 
			$headers = 'From: Megapolis <info@megapolis-mck.ru>' . "\r\n";
			$headers .= "Content-type: text/plain; charset=utf-8";

			$message = "Ваш заказ #$order_id принят в обработку! Спасибо за заказ! ";
			$mail = wp_mail( $email, 'Заказ на сайте megapolis-mck.ru', $message, $headers);

			//отправляем письмо продавцу заголовки те же

			//сформируем письмо
			$message = "Новый заказ #$order_id\n";
			$message .= "Имя: $name\n";
			$message .= "Телефон: $phone\n";
			$message .= "Email: $email\n";

			//мыло, указанное в настройках
			$option_mail = get_theme_mod('input_email2', 'info@megapolis-mck.ru');

			$mail = wp_mail( $option_mail, 'Заказ на сайте megapolis-mck.ru', $message, $headers);

			//после почты запишем сессию корзины и айди заказы, чтобы остались данные для страницы checkout
			$_SESSION['order'] = [
				'order_info' => $_SESSION['cart'],
				'order_id' => $order_id
			];

			//теперь обнулим сессию корины
			$_SESSION['cart'] = [];

			//возвратим статус успеха
			echo json_encode([
				'status' => 'ok'
			]);

		}
		
	}
	else
		echo json_encode([
				'status' => 'fail'
		]);

	wp_die();
}


add_action('wp_ajax_test', 'test');

function test()
{
	global $wpdb;
	$xss = htmlspecialchars($_POST['value']);

	$insert = $wpdb->query("INSERT INTO test (xss) VALUES ('$xss')");

	echo $wpdb->insert_id;

	wp_die();
}


// --- END OF CUSTOM FUNCTIONS ---

// --- THUMBNAILS IN MENUS ---

// --- END OF THUMBNAILS IN MENUS ---