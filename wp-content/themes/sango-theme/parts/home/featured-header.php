<?php 
/*このファイルはトップページのヘッダー下にアイキャッチ画像を表示させるためのものです。
	カスタマイザーから画像やテキストを変更できます。*/

//①カスタマイザーでヘッダー画像（分割なし）を表示
if(get_option('header_image_checkbox') && !is_paged()) {
	
	if(get_option('only_show_headerimg')): //画像のみ表示するオプション?>
		<div class="<?php if (get_option('limit_header_width')) echo 'maximg'; ?>">
			<img src="<?php echo esc_url(get_option('original_image_upload'));?>"/>
		</div>
	<?php else : //ボタン・テキストも表示する場合?>
		<div id="header-image" class="<?php if (get_option('limit_header_width')) echo 'maximg'; ?>" style="background-image: url(<?php echo esc_url(get_option('original_image_upload')); ?>);">
			<div class="header-image__text">
				<?php if(get_option('header_big_txt')): ?>
					<p class="header-image__headline dfont"><?php echo esc_attr(get_option('header_big_txt')); ?></p>
				<?php endif; ?>
				<?php if(get_option('header_sml_txt')): ?>
					<p class="header-image__descr"><?php echo esc_attr(get_option('header_sml_txt')); ?></p>
				<?php endif; ?>
				<?php if(get_option('header_btn_txt')): ?>
					<p class="header-image__btn"><a class="raised rippler rippler-default" href="<?php echo esc_url(get_option('header_btn_url')); ?>" style="background: <?php echo get_theme_mod( 'header_btn_color', '#ff90a1'); ?>;"><?php echo esc_attr(get_option('header_btn_txt')); ?></a></p>
				<?php endif; ?>
			</div>
		</div>
<?php endif;//END画像のみ表示するオプション
		}//END ヘッダー画像のカスタマイザー ?>
<?php //②2分割ヘッダー
if(get_option('header_divide_checkbox') && !is_paged()): ?>
		<div id="divheader" class="maximg" style="background: <?php echo get_theme_mod( 'divide_background_color', '#93d1f0'); ?>;">
			<div class="divheader__img">
				<img src="<?php echo esc_url(get_option('divheader_image_upload'));?>" />
			</div>
			<div class="divheader__text">
				<?php if(get_option('divheader_big_txt')): ?>
					<p class="divheader__headline" style="color: <?php echo get_theme_mod( 'divide_bigtxt_color', '#FFF'); ?>;"><?php echo esc_attr(get_option('divheader_big_txt')); ?></p>
				<?php endif; ?>
				<?php if(get_option('divheader_sml_txt')): ?>
					<p class="divheader__descr" style="color: <?php echo get_theme_mod( 'divide_smltxt_color', '#FFF'); ?>;"><?php echo esc_attr(get_option('divheader_sml_txt')); ?></p>
				<?php endif; ?>
				<?php if(get_option('divheader_btn_txt')): ?>
					<p class="divheader__btn"><a class="raised rippler rippler-default" href="<?php echo esc_url(get_option('divheader_btn_url')); ?>" style="background: <?php echo get_theme_mod( 'divide_btn_color', '#6BB6FF'); ?>;"><?php echo esc_attr(get_option('divheader_btn_txt')); ?></a></p>
				<?php endif; ?>
			</div>
		</div>
<?php endif;//END 2分割ヘッダー ?>
