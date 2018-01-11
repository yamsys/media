<?php 
/**
* Template Name: トップページ用（タイトルなど出力無し）
* Template Post Type: page
*/
get_header(); ?>
			<div id="content" class="page-forfront">
				<div id="inner-content" class="wrap cf">
					<main id="main">
						<div class="entry-content">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					                  <?php
					                    the_content();
					                  ?>
						<?php endwhile; ?>
						<?php else : ?>
							<?php get_template_part('content', 'not-found'); ?>
						<?php endif; ?>
						</div>
					</main>
				</div>
			</div>
<?php get_footer(); ?>