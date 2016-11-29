<?php if ( is_active_sidebar( 'left_sideb' ) ) : ?>
 
	<div id="left-sideb" class="sidebar">
 
		<?php 
			dynamic_sidebar( 'left_sideb' ); 
		?>

		<!-- NEWS-BLOCK -->
		<div class="newsbar">
			<span class="newsbar-title">
				Новости
			</span>
			<?php 
				$args = array(
				  'numberposts' => 3,
				  'category' => 20
				);
				$latest_posts = get_posts( $args );
				foreach ($latest_posts as $post)
				{
					// вырезаем url картинки
					$url = get_the_post_thumbnail_url($post);
					// показываем только дату поста
					// P.S. не будет работать в 10000 году
					$date = substr($post->post_date, 0, 10);
 			?>
			<a class="newsbar-article" href="<?= $post->guid; ?>">
				<img class="newsbar-article-pic" src="<?= $url; ?>">
				<span class="newsbar-article-text">
					<?= $post->post_title; ?>
				</span>
				<span class="newsbar-article-date">
					<?= $date; ?>
					<?= $content; ?>
				</span>
				<hr class="article_separator">
			</a>
			<?php 
				}
			 ?>
		</div>
		<!-- END OF NEWS-BLOCK -->

		<!-- ARTICLES-BLOCK -->
		<div class="articlesbar">
			<span class="articlesbar-title">
				Статьи
			</span>
			<?php 
				$args = array(
				  'numberposts' => 2,
				  'category' => 18
				);
				$latest_posts = get_posts( $args );
				foreach ($latest_posts as $post)
				{
			        $content = $post->post_excerpt;
			        $content = strip_shortcodes($content);
			        $content = str_replace(']]>', ']]&gt;', $content);
			        $content = strip_tags($content);
			        # If an excerpt is set in the Optional Excerpt box
			        if($content){
			            $content = apply_filters('the_excerpt', $content);
			        }
			        # If no excerpt is set
			        else {
				        $content = $post->post_content;
				        $excerpt_length = 20;
				        $words = explode(' ', $content, $excerpt_length + 1);
				        if(count($words) > $excerpt_length){
				            array_pop($words);
				        }
				        $content = implode(' ', $words);
			    	}
 			?>
			<a class="articlesbar-article" href="<?= $post->guid; ?>">
				<span class="articlesbar-article-title">
					<?= $post->post_title; ?>
				</span>
				<span class="articlesbar-article-text">
					<?= $content; ?>
				</span>
				<hr class="article_separator">
			</a>
			<?php 
				}
			 ?>
		</div>
		<!-- END OF ARTICLES-BLOCK -->
	</div>
 
<?php endif; ?>