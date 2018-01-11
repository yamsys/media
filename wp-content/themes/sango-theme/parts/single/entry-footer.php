<footer class="article-footer">
    <aside>
    	<div class="footer-contents">
        	<?php insert_social_buttons(); //シェアボタン?>
        	<?php insert_like_box();//フォローボックス?>
        	<div class="footer-meta dfont">
               	<?php if(get_the_category_list()): //カテゴリー一覧を出力 ?>               	
               	 	<p class="footer-meta_title">CATEGORY :</p>
               	 	<?php echo get_the_category_list(); ?>
               	<?php endif;
               		if(get_the_tags()) : //タグ一覧を出力?>
               		<div class="meta-tag">
               		<p class="footer-meta_title">TAGS :</p> 
               		<?php the_tags('<ul><li>','</li><li>','</li></ul>');?>
               		</div>
              	<?php endif; ?>
          	</div>
        	<?php insert_cta(); //CTA ?>
        	<?php sng_recommended_posts(); //おすすめ記事 ?>
        	<?php dynamic_sidebar( 'ads_footer' ); //関連記事広告 ?>
          <?php if(!get_option('no_related_posts')) related_posts(); //関連記事 ?>
        </div>
        <?php insert_author_info();//この記事を書いた人 ?>
    </aside>
</footer>