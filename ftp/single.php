<?php get_header();?>
<main>
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
			<div class="content-post clearfix">
					<?php 
						$img = get_the_post_thumbnail();
						$sImageUrl = getImageUrl($img); 
					?>
				<div class="content-text">
					<img class="content-thumbnail" 
					 src="<?= $sImageUrl; ?>">
					<?php the_content(); ?>
				</div>
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
		</div>
	</div>

	<script>
		$(document).ready(function(){

			// если передается запрос "GET" с номером вкладки,
			// имитируем нажатие этой вкладки
			var x =	<?php
				  	if( $_GET["tab"] ) {
				      echo $_GET['tab'];
				    }
				   	else 
				   		echo "-1";
				?>;
			var pattern = new RegExp(/^[0-9]+$/);
			var numTables = <?php echo count($table_arr); ?>;

			if (pattern.test(x))
			{
				if (x > 0 && x <= numTables){
				click_element(x-1);
			}
			}
		});
	</script>
</main> 
<?php get_footer(); ?>