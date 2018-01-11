			<footer class="footer">
				<?php if(is_active_sidebar( 'footer_left' )||
						 is_active_sidebar( 'footer_cent' )||
						 is_active_sidebar( 'footer_right' )): ?>
					<div id="inner-footer" class="wrap cf">
						<a href="#container" class="fab-btn accent-bc" rel="nofollow">
							<i class="fa fa-angle-up"></i>
						</a>
						<div class="fblock first">
							<?php if(is_active_sidebar('footer_left')) dynamic_sidebar( 'footer_left' ); ?>
						</div>
						<div class="fblock">
							<?php if(is_active_sidebar('footer_cent')) dynamic_sidebar( 'footer_cent' ); ?>		
						</div>
						<div class="fblock last">
							<?php if(is_active_sidebar('footer_right')) dynamic_sidebar( 'footer_right' ); ?>
						</div>
					</div>
				<?php endif; ?>
				<div id="footer-menu">
					<div>
						<a class="footer-menu__btn dfont" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-home fa-lg"></i> HOME</a>
					</div>
					<nav>
						<?php wp_nav_menu(array(
    					'container' => 'div',
    					'container_class' => 'footer-links cf',
    					'menu' => 'フッターリンクメニュー',
    					'menu_class' => 'nav footer-nav cf',
    					'theme_location' => 'footer-links',
    					'before' => '',
    					'after' => '',
    					'link_before' => '',
    					'link_after' => '', 
    					'depth' => 0, 
    					'fallback_cb' => 'sng_footer_links_fallback'
						)); ?>
					</nav>
					<p class="copyright dfont">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?> All rights reserved.</p>
				</div>
			</footer>
		</div>
		<?php footer_nav_menu(); //モバイルフッターメニュー?>
		<?php go_top_btn(); //トップへ戻るボタン?>
		<?php wp_footer(); ?>
	</body>
</html>