<?php get_header();?>
<main>
	<!-- GETTING THEME OPTIONS VARIABLE -->
	<?php 
		$var_min = get_theme_mod('input_min', '1'); 
		$var_max = get_theme_mod('input_max', '20'); 
		$var_step = get_theme_mod('input_step', '1'); 
		$var_multiplier = get_theme_mod('input_multiplier', "133");
		$var_dimension = get_theme_mod('input_dimension', "КМ");
	?>
	<!-- END OF GETTING THEME OPTIONS VARIABLE -->

	<script>
		$(document).ready(function(){
			init_range_cars();   
		});
	</script>

	<div class="container clearfix">
		<?php get_sidebar(); ?>
		<div class="content">
			<?php 
				if(have_posts()):
				while(have_posts()):
					the_post();
			?>	
			<span class="content-title">
				<?php the_title(); ?>
			</span>
			<div class="content-text">
				<?php the_content(); ?>
			</div>

			<?php 
				endwhile;
				endif; 
			?>
			<!-- TABLE-TABS -->
			<div id="table-tabs-id" class="table-tabs clearfix">
			</div>
			<!-- END OF TABLE-TABS -->
			
			<!-- TABLE-OUTPUT -->
			<!--Выведем таблицы из мета поля -->
			<?php
			//получаем значения из мета поля
			$meta_values = get_post_meta( $post->ID, 'product_tables_ids', true );
			//првоерим значение мета данных, если все ок, продолжаем фанится
			if ( $meta_values != '' )
			{
				global $wpdb; //объявим сразу
				// переведем айдишники мета данных в массив
				$table_arr = explode(',', $meta_values);
				//для каждого элемента выведем талицу
				for ( $i_main = 0; $i_main < count($table_arr); $i_main++ )
				{
					$table_id = $table_arr[$i_main];
					//лежит в функциях
					$Model = new productTableModel(); 
					//проверим наличие таблицы
					$is_table = $Model->is_table($table_id);

					//если все ок, и таблица найдена, то получаем данные
					if ( $is_table )
					{	
						//данные таблицы из бд
						$table_data = $Model->get_table_data($table_id);
						//а тут уже данные о товарах из бд
						$tovars = $Model->get_tovars($table_id);
						$table_name = $table_data['name']; // переменная имени таблицы, можешь ее использовать
						// вьюха таблицы
						$Model->view_table($table_data, $tovars);
					}
				}
			}
			?>
			<!-- END OF TABLE OUTPUT --> 
			
			<!-- CARS -->
			<style>	
			<?php 
				$i = 0;
				foreach ($GLOBALS['cars'] as $car) { 
					$i++;
					$imgUrl = $car['img'];
			?>
			.<?php echo "car_input".$i; ?>::-webkit-slider-thumb {
			  background-image: url("<?php echo $imgUrl; ?>");
			}
			<?php } ?>
			</style>

			<?php 
				$i = 0;
				foreach ($GLOBALS['cars'] as $car) { 
					$i++;
					$imgUrl = $car['img'];
			?>
			<div class="car">
				<input class="car_input <?php echo "car_input".$i; ?>" 
					type="range" 
					   min="<?= $car['min'] ?>" 
					   max="<?=$car['max'] ?>" 
					   step="<?= $car['step'] ?>"
					   dimen="<?= $car['distancein'] ?>"
					   multi="<?= $car['rubstep'] ?>"
					   id="range_car"
					   value = "1">
				<span class="range_car_text" 
				      id="range_car_span<?= $i ?>" style="color: <?=$car['color'];?>"></span>
			</div>
			<?php } ?>
			<!-- END OF CARS -->
		</div>
	</div>
</main> 
<?php get_footer(); ?>