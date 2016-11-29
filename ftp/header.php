<?php
	session_start();

	//перменная о количестве товаров
	$count = 0;

	//перменная о всей сумме
	$total_sum = 0;

	//переменна для фронтеда
	$json_arr = [];
	$json = '';

	//возьмем данные с корзины
	if ( isset($_SESSION['cart']) && !empty($_SESSION['cart']))
	{
		global $wpdb;
		$count = count($_SESSION['cart']);

		//переберем все значения массива и узнаем цену
		for ( $i = 0; $i < count($_SESSION['cart']); $i++ )
		{
			//для удобства запишем перменные
			$tovar_id = $_SESSION['cart'][$i][0];
			$num = $_SESSION['cart'][$i][1];
			$price = $_SESSION['cart'][$i][2];

			//чтобы перемножать
			settype($num, 'integer');
			settype($price, 'float');

			//для json
			settype($tovar_id, 'integer');

			$total_sum += $num * $price;

			//занесем все данные в json массив
			$json_arr[] = [$tovar_id, $num, $price];

		}

		//итоговая сумма
		if ( is_page('cart') )
		{
			global $total;
			$total = $total_sum;
		}

	}

	//формируем json
	if ( !empty($json_arr) )
		$json = json_encode($json_arr);


?>

<!-- GETTING THEME OPTIONS VARIABLE -->
<?php 
	$var_phone = get_theme_mod('input_phone', '8-495-444-77-55'); 
	$var_phone_subtext = get_theme_mod('input_phone_subtext', 'Общий многоканальный телефон'); 
	$var_address = get_theme_mod('input_address', 'г. Москва, пр-т Вернадского 62, стр 3'); 
	$var_logo = get_theme_mod('input_logo', 'http://megapolis-mck.ru/wp-content/uploads/2016/11/logo1.png');
?>
<!-- END OF GETTING THEME OPTIONS VARIABLE -->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Мегаполис</title>
	<?php wp_head(); ?>

	<script>
		
		var ajaxUrl = '<?= site_url() ?>/wp-admin/admin-ajax.php';

		//массив, где будут хранится данные о товарах в корзине
		// в нем буду еще массивы, в кторых первый элемент это айди, второй элемент количество товаров, третий его цена
		var cart = [];

		//запишем json
		<?php if ( $json != '' ): ?>

		cart = JSON.parse('<?= $json ?>');

		<?php endif; ?>

	</script>

	<script>
		$(document).ready(function(){
			set_tabs_click_events();
		});
	</script>

</head>
<body>
<div id="main-wrap">

	<!-- HEADER -->
	<header id="main-header">
		<!-- CONTACT INFORMATION -->
		<div class="container clearfix">
			<div class="main-header-logo">
				<a href="<?= site_url() ?>" class="main-header-logo-pic"
					style="background-image: url('<?=$var_logo?>');"></a>
			</div>
			<div class="main-header-phone">
				<a href="tel:<?= $var_phone; ?>" class="main-header-phone-text">
					<?= $var_phone; ?>
				</a>
				<i class="fa fa-phone" aria-hidden="true"></i>
				<span class="main-header-phone-subtext">
					<?= $var_phone_subtext; ?>
				</span>
			</div>
			<div class="main-header-address">
				<i class="fa fa-location-arrow" aria-hidden="true"></i>
				<span class="main-header-address-text">
					 <?= $var_address; ?>
				</span>
				<span class="main-header-address-subtext">
					
				</span>
			</div>
			<div class="main-header-cart clearfix">
				<a href="/cart/" class="main-header-cart-pic">
				</a>
				<a class="main-header-cart-inyourcart" href="/cart/">
					<span class="main-header-cart-inyourcart-text">
						В Вашей корзине
					</span>
					<span class="main-header-cart-inyourcart-items">
						товаров: <span class="main-header-cart-inyourcart-itemsNum" data-type="tovars-num" id="itemsNum">
									<?= $count ?>
								</span> 
					</span>
					<span class="main-header-cart-inyourcart-items">
						на сумму: 
						<span class="main-header-cart-inyourcart-itemsNum" id="itemsSum">
							<span data-type="tovars-sum">
								<?= $total_sum ?>
							</span>
							руб. 
						</span>
					</span>
				</a>
			</div>
		</div>
		<!-- END OF CONTACT INFORMATION -->
		<div id="top-nav" class="clearfix">
			<!-- TOP MENU -->
      <?php
    		if ( function_exists( 'wp_nav_menu' ) )
        wp_nav_menu( 
	        array( 
	        'theme_location' => 'top-menu',
	        'fallback_cb'=> 'top_menu',
	        'container' => 'ul',
	        'menu_id' => 'top-nav-list',
	        'menu_class' => 'nav') 
				);
    		else custom_menu();
			?>
			<!-- END OF TOP MENU -->
			<!-- MENU IN LEFT SIDEBAR -->
			<!-- <?php
    		if ( function_exists( 'wp_nav_menu' ) )
        wp_nav_menu( 
	        array( 
	        'theme_location' => 'left-menu',
	        'fallback_cb'=> 'left_menu',
	        'container' => 'ul',
	        'menu_id' => 'left-nav-list',
	        'menu_class' => '') 
				);
    		else custom_menu();
			?> -->
			<!-- END OF MENU IN LEFT SIDEBAR -->
		</div>
	<hr class="shadowHr">
	</header>
	<!-- END OF HEADER -->