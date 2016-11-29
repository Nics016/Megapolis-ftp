<?php get_header();?>

<main>
	<div class="container clearfix">
		<?php get_sidebar(); ?>
		<div class="content">

		<?php
		if ( isset($_SESSION['order']) && !empty($_SESSION['order']['order_info']) ):
			global $wpdb;
			$count = count($_SESSION['order']);
		?>

		<span class="checkout-title">
			Ваш заказ 
			<span class="checkout-title-orderNumber">
				#<?= $_SESSION['order']['order_id'] ?>
			</span> 
			принят в обработку.
		</span>

			<div class="cart">
				<span class="content-title">
					Вы заказали:
				</span>
				<div class="cart-items">
					<table id="cart-items-table">
						<tr>
							<th></th>
							<th>Товар</th>
							<th>Цена</th>
							<th>Количество</th>
							<th>Сумма</th>
						</tr>

						<?php
						//переберем все значения массива и узнаем цену
						for ( $i = 0; $i < count($_SESSION['order']['order_info']); $i++ ):

							//обозначим перменные
							$tovar_id = $_SESSION['order']['order_info'][$i][0];
							$num = $_SESSION['order']['order_info'][$i][1];
							$price = $_SESSION['order']['order_info'][$i][2];

							//нужные даннные
							$query = "SELECT name, image_link FROM tovars WHERE ID = $tovar_id LIMIT 1";
							$result = $wpdb->get_results($query, 'ARRAY_A');

							$name = $result[0]['name'];
							$image_link = $result[0]['image_link'];

						
							//подсчитаем итоговую сумму
							$tovar_sum = $price * $num;

							$total_sum += $tovar_sum;

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
								<span data-event="change-num" class="cart-items-table-num"><?= $num ?></span>
										
							</td>

							<td>
								<span data-type="tovar-sum"><?= $tovar_sum ?></span> руб.
							</td>
						</tr>

						<?php endfor; ?>

					</table>
				</div>
				<div class="cart-orderinfo">
					<span class="cart-orderinfo-sum">
						Итого: <span id="orderSum" data-type="order-sum">
									<?= $total_sum ?>							
								</span> руб.
					</span>
				</div>
			</div>
			<span class="checkout-thanks">Спасибо вам за работу с нашим интернет-магазином!</span>

			<?php else: ?>

				<b style="color:red;">Ваша корзина пуста!</b>

			<?php endif; ?>
		</div>
	</div>
	</div>
</main> 
<?php get_footer(); ?>