<?php get_header();?>
<main>
	<div class="container clearfix">
		<?php get_sidebar(); ?>
		<div class="content">

		<?php
		if ( isset($_SESSION['cart']) && !empty($_SESSION['cart']) ):

		global $wpdb;
		$count = count($_SESSION['cart']);
		?>

			<div class="cart">
				<span class="content-title">
					В корзине:
				</span>
				<div class="cart-items">
					<table id="cart-items-table">
						<tr>
							<th></th>
							<th>Товар</th>
							<th>Цена</th>
							<th>Количество</th>
							<th>Сумма</th>
							<th></th>
						</tr>

						<?php
						//переберем все значения массива и узнаем цену
						for ( $i = 0; $i < count($_SESSION['cart']); $i++ ):

							//обозначим перменные
							$tovar_id = $_SESSION['cart'][$i][0];
							$num = $_SESSION['cart'][$i][1];

							//нужные даннные
							$query = "SELECT name, image_link, price FROM tovars WHERE ID = $tovar_id LIMIT 1";
							$result = $wpdb->get_results($query, 'ARRAY_A');

							$name = $result[0]['name'];
							$image_link = $result[0]['image_link'];
							$price = $result[0]['price'];

							//для умножения
							settype($num, 'integer');
							settype($price, 'float');

							$tovar_sum = $price * $num;

						?>

						<tr data-tovar-id="<?= $tovar_id ?>">

							<td>
								<img class="cart-items-table-pic" src="<?= $image_link ?>">
							</td>

							<td>
								<?= $name ?>
							</td>

							<td>
								<span> <?= $price ?> </span> руб.
							</td>

							<td>
								<input type="number" data-event="change-num" class="cart-items-table-num" 
										value="<?= $num ?>" min="1" step="1">
							</td>

							<td>
								<span data-type="tovar-sum"><?= $tovar_sum ?></span> руб.
							</td>

							<td> 
								<a href="#" data-event="remove-tovar" class="cart-items-table-delete">Удалить</a>
							</td>
						</tr>

						<?php endfor; ?>

					</table>
				</div>
				<div class="cart-orderinfo">
					<span class="cart-orderinfo-sum">
						Итого: <span id="orderSum" data-type="order-sum">
									<?php 
										global $total;
										echo $total; 
									?>							
								</span> руб.
					</span>
				</div>
			</div>

			<form class="contactForm" action="" method="post" id="cart_form">
				<span class="contactForm-title">
					Информация о покупателе
				</span>
				<div class="contactForm-info">
					<!-- NAME -->
					<div class="input-container">
						<div class="contactForm-info-line clearfix">
							<label for="customer_Name_id" class="contactForm-info-lab">
							Имя <span class="contactForm-info-star">*</span>
							</label>
							<input type="text" name="name" id="customer_name_id" class="contactForm-info-field" placeholder="Иванов Иван Васильевич" autocomplete="off">
						</div>
						<span class="contactForm-info-error" id="customer_name_id_error">Неверное имя</span>
					</div>

					<!-- EMAIL -->
					<div class="input-container">
						<div class="contactForm-info-line clearfix">
							<label for="customer_email_id" class="contactForm-info-lab">
							E-Mail <span class="contactForm-info-star">*</span>
							</label>
							<input type="text" name="email" id="customer_email_id" class="contactForm-info-field" placeholder="ivanov@gmail.com" autocomplete="off">
						</div>
						<span class="contactForm-info-error" id="customer_email_id_error">Неверный формат e-mail</span>
					</div>
					
					<div class="input-container">
						<div class="contactForm-info-line clearfix">
							<label for="customer_phone_id" class="contactForm-info-lab">
							Телефон <span class="contactForm-info-star">*</span>
							</label>
							<input type="text" name="phone" id="customer_phone_id" class="contactForm-info-field" placeholder="89997776969" autocomplete="off">
						</div>
						<span class="contactForm-info-error" id="customer_phone_id_error">Неверный номер телефона</span>
					</div>	

					<div class="contactForm-info-line clearfix">
						<label for="customer_address_id" class="contactForm-info-lab">Адрес доставки</label>
						<input type="text" name="adress" class="contactForm-info-field" placeholder="г. Москва, ул. Шоссейная, д.5" autocomplete="off">
					</div>

					<div class="contactForm-info-line clearfix">
						<label for="customer_comment_id" class="contactForm-info-lab">
						Комментарий
						</label>
						<textarea rows="3" type="textarea" name="comment" class="contactForm-info-field" placeholder="Оставьте ваш комментарий" autocomplete="off"></textarea>
					</div>
					<input type="submit" class="contactForm-info-makeorder" value="Оформить заказ" id="customer_submit_id">
				</div>
			</form>

			<?php else: ?>

			<b style="color:red;">Ваша корзина пуста!</b>

			<?php endif; ?>

		</div>
	</div>
</main> 
<?php get_footer(); ?>