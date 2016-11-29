<?php 
get_header();

if ( have_posts() ):
	while ( have_posts() ):
		the_post();

		$show_slider = get_field("show_slider");
?>

<main>
	<?php
	//показываем слайдер или категории?
	if ( $show_slider ):
		//показываем слайдер
		$slider_alias = get_field("slider_alias");
	?>
		
		<div class="main-slider">
			
			<?php putRevSlider( $slider_alias ); ?>

		</div>

	<?php else: ?>

		<!-- GETTING TERMS OF PRODUCTS -->
		<?php 
			// Заголовок над категориями берем из настроек темы
			$var_categories_title = get_theme_mod("input_categories_title", "Основные направления металлопродукции");

			// берем занчение из ACF, удаляем пробелы, заменяем НЕ цифры в зяпятые и формируем массив
			$category_ids = trim(get_field("category_ids"));

			$category_ids = preg_replace("/\s+/", "", $category_ids);
			$category_ids = preg_replace("/[^0-9]+/", ",", $category_ids);
			
			// проверка массива с айдишниками на корректность
			$verify = true;

			$ids_array = explode(",", $category_ids);
			for( $i = 0; $i < count($ids_array); $i++ )
			{
				if (!preg_match("/[0-9]+/", $ids_array[$i]))
				{	
					$verify = false;
					break;
				}
			}

			// если все ок, то погнали мутить грязь дальше
			if ($verify):

		?>
			<div class="categories_container clearfix">
				<div class="categories">
					<span class="categories-title">
						<?= $var_categories_title ?>
					</span>
					<div class="categories-items clearfix">
		<?php
				//перебираем массив категорий
				for( $i = 0; $i < count($ids_array); $i++ ):
					$cat_id = $ids_array[$i];

					$cat_link = get_category_link($cat_id);

					// проверим на существоание
					if ( $cat_link == "" )
						continue;

					// имя категории
					$cat_name = get_the_category_by_ID($cat_id);
					// получаем картинку категории
					$cat_image_id = get_term_thumbnail_id($cat_id);
					$cat_image = wp_get_attachment_url($cat_image_id);

		?>
		<!-- END OF GETTING TERMS -->
		<!-- CATEGORIES -->
				
				<a href="<?= $cat_link ?>" class="categories-items-element">
					<span class="categories-items-element-pic">
						<img src="<?= $cat_image ?>" width="200" alt="">
					</span>

					<span class="categories-items-element-text">
						<?= $cat_name ?>
					</span>
				</a>	

			<?php endfor; ?>


					</div>
				</div>
			</div>
		<?php endif; ?>
		<!-- END OF CATEGORIES -->

	<?php endif; ?>
	
	<div class="container clearfix">
		<?php get_sidebar(); ?>
		<!-- CONTENT -->
		<div class="content">
			<?php the_content(); ?>
		</div>
		<!-- END OF CONTENT -->
	</div>
</main> 
<?php 
	endwhile;
endif;
get_footer(); 
?>