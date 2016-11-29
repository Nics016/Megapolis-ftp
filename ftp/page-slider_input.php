<?php get_header();?>
<main>
	<script>
		$(document).ready(function(){
			init_range_car();
		});
	</script>
	<div class="container clearfix">
		<?php get_sidebar(); ?>
		<div class="content">
			<div class="car">
				<input type="range" min="1" max="20" step="1" id="range_car_id">
				<span class="range_car_text" id="range_car_text_id"></span>
			</div>
		</div>
	</div>
</main> 
<?php get_footer(); ?>