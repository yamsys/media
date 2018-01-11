<?php
/*
 *このファイルでは各種CSSやJSファイルを読み込むための関数を記載しています。
  - 各種CSS/JS
  - 追尾サイドバー
  - トップへ戻るボタン
 */

//各種スタイル/スクリプトを読み込み
//関数の実行はfunction.phpで
function sng_scripts_and_styles() {
  global $wp_styles; 
  if (!is_admin()) {

  	  //modernizr
  		wp_register_script( 'sng-modernizr', get_template_directory_uri() . '/library/js/modernizr.custom.min.js', array(), '2.5.3', false );

  		//メイン
  		wp_register_style( 'sng-stylesheet', get_template_directory_uri() . '/style.css', array(), '', 'all' );

	    //主に投稿ページで使われるスタイル（ショートコード等）
	    wp_register_style( 'sng-option', get_template_directory_uri() . '/entry-option.css', array('sng-stylesheet'), '', 'all' );

	    // GoogleFonts：フォントを変えたいときは以下のURLを置き換えてください。
	    wp_register_style( 'sng-googlefonts', '//fonts.googleapis.com/css?family=Quicksand:500,700', array(), '', 'all' );

	    // Font Awesome
	    wp_register_style( 'sng-fontawesome', get_template_directory_uri() . '/library/fontawesome/css/font-awesome.min.css', array(), '', 'all' );

	    // WPデフォルトのjqueryを読み込まず、googleのCDNで読み込み
	    wp_deregister_script( 'jquery' ); 
	    wp_enqueue_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js',array(), '', false); 
  		// enqueue styles and scripts
  		wp_enqueue_script( 'sng-modernizr' );
  		wp_enqueue_style( 'sng-stylesheet' );
	    wp_enqueue_style( 'sng-option' );
	    wp_enqueue_style( 'sng-googlefonts' );
	    wp_enqueue_style( 'sng-fontawesome' );

	    // コメント用
	    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
	      	wp_enqueue_script( 'comment-reply' );
	    }
	    /* Ripple Effect リップルエフェクト用のCSS/Jsを読み込み*/
	    if(!get_option('no_ripple')) {
	      wp_enqueue_style( 'ripple-style', get_template_directory_uri(). '/library/ripple/rippler.min.css');
	      wp_enqueue_script( 'ripple-js', get_template_directory_uri(). '/library/ripple/jquery.rippler.js', array(), false, true );
	    }

	} //endif is admin
}//END sng_scripts_and_styles

/*********************
 追尾サイドバーウィジェット
*********************/
function fixed_sidebar_js() {
  global $post;
  /*投稿,固定ページ & PC表示 & 1カラムではない && 追尾サイドバーがアクティブのときのみJSを出力*/
  if(is_singular() && !wp_is_mobile() && !get_post_meta( $post->ID, 'one_column_options', true ) && is_active_sidebar( 'fixed_sidebar' )){
  echo <<< EOM
<script>
(function(){
   $(function(){
     var fixed = $('#fixed_sidebar'),
     beforefix = $('#notfix'),
     main = $('#main'),
     beforefixTop = beforefix.offset().top;
     fixTop = fixed.offset().top,
     mainTop = main.offset().top,
     w = $(window);
     var adjust = function(){
       var fixHeight = fixed.outerHeight(true),
       fixWidth = fixed.outerWidth(false),
       beforefixHeight = beforefix.outerHeight(true),
       mainHeight = main.outerHeight(),
       winTop = w.scrollTop();
        fixTop = fixed.css('position') === 'static' ? beforefixTop + beforefixHeight: fixTop;
       if(winTop + fixHeight > mainTop + mainHeight){
        fixed.removeClass('sidefixed');
      } else if(winTop >= fixTop){
        fixed.addClass('sidefixed');
        fixed.css('width',fixWidth)
      }else{
        fixed.removeClass('sidefixed');
       }
     }
     w.on('scroll', adjust);
   });
})(jQuery);
</script>
EOM;
  }}
add_action( 'wp_footer', 'fixed_sidebar_js', 100 );

//上へ戻るボタン（footer.phpで実行）
function go_top_btn() {
  if(is_singular()){
    if(wp_is_mobile() && get_option('show_to_top') || !wp_is_mobile() && get_option('pc_show_to_top') ){
      echo '<a href="#" class="totop" rel="nofollow"><i class="fa fa-chevron-up"></i></a>';
    }
  }
}
//上へ戻るボタンのJS
function go_top_btn_js() {
  if(is_singular()){
    if(wp_is_mobile() && get_option('show_to_top') || !wp_is_mobile() && get_option('pc_show_to_top') ){
  echo <<< EOM
<script>
$(document).ready(function() {
      $(window).scroll(function() {
        if ($(this).scrollTop() > 700) {
          $('.totop').fadeIn(300);
        } else {
          $('.totop').fadeOut(300);
        }
      });
      $('.totop').click(function(event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, 300);
      })
    });
</script>
EOM;
    }
  }
}
add_action( 'wp_footer', 'go_top_btn_js', 100 );
?>