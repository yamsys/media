<?php if (have_posts()){ //記事あり
/*記事一覧表示は以下の2種類（カスタマイザーから設定）
  1）横長のタイプ
  2) 縦長のカードタイプ
*/
 	//(1)横長の場合
	if( (!wp_is_mobile() && get_option('sidelong_layout') && is_home() && is_front_page() )/*PCトップ*/
	|| (wp_is_mobile() && get_option('mb_sidelong_layout') && is_home() )/*モバイルトップ*/
	|| (!wp_is_mobile() && get_option('archive_sidelong_layout') && is_archive() )/*PCアーカイブ*/
	|| (wp_is_mobile() && get_option('mb_archive_sidelong_layout') && is_archive() ) ):/*モバイルアーカイブ*/ ?>
		<div class="sidelong cf">
			<?php while (have_posts()) : the_post(); ?>
					<article class="sidelong__article">
							<a class="sidelong__link" href="<?php the_permalink() ?>">
								<p class="sidelong__img">
									<img src="<?php echo featured_image_src('thumb-160'); ?>" alt="<?php the_title(); ?>">
								</p>
								<div class="sidelong__article-info">
									<?php if(!get_option('remove_pubdate')):?>
									<time class="updated entry-time dfont" datetime="<?php the_time('Y-m-d'); ?>"><?php echo get_post_time('Y.m.d D');?></time>
									<?php endif; ?>
									<h2><?php the_title(); ?></h2>
								</div>
							</a>
							<?php newmark();//newマーク ?>
					</article>
			<?php endwhile; ?>
		</div>
		<?php sng_page_navi(); ?>
  	<?php else : //(2)カードタイプの場合?>
		<div class="cardtype cf">
			<?php while (have_posts()) : the_post(); ?>
				<article class="cardtype__article">
						<a class="cardtype__link" href="<?php the_permalink() ?>">
							<p class="cardtype__img">
								<img src="<?php echo featured_image_src('thumb-520'); ?>" alt="<?php the_title(); ?>">
							</p>
							<div class="cardtype__article-info">
								<?php if(!get_option('remove_pubdate')):?>
								<time class="updated entry-time dfont" datetime="<?php the_time('Y-m-d'); ?>"><?php echo get_post_time('Y.m.d D');?></time>
								<?php endif; ?>
								<h2><?php the_title(); ?></h2>
							</div>
						</a>
						<?php 
						if(!is_archive()) output_catogry_link();//カテゴリーを出力
						newmark();//newマーク
						?>
				</article>
			<?php endwhile; ?>
		</div>
		<?php sng_page_navi(); ?>
	<?php endif; //ENDカードタイプ
} else {//記事なし
	get_template_part('content', 'not-found');
}
wp_reset_query();
?>