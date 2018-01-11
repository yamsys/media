<?php get_header(); ?>
	<?php get_template_part('parts/home/featured-header');//アイキャッチを出力 ?>
		<div id="content">
			<div id="inner-content" class="wrap cf">
				<main id="main" class="m-all t-2of3 d-5of7 cf">
					<?php 
					if(is_active_sidebar( 'home_top' )) dynamic_sidebar( 'home_top' );
					get_template_part('parts/post-grid');//記事一覧を表示 
					if(is_active_sidebar( 'home_bottom' )) dynamic_sidebar( 'home_bottom' );
					?>
				</main>
				<?php get_sidebar(); ?>
			</div>
		</div>
<?php get_footer(); ?>
