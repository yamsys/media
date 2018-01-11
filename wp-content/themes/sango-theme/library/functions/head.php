<?php 
/***************************************
head内に出力されるメタタグ系を制御する関数を
このファイルにまとめています。
- titleタグに出力されるタイトルの変更
- meta robot出力
- OGPタグ出力
- ページ分割した記事でrel next/prevを表示
****************************************/

/*********************
titleタグを変更
*********************/

	function sng_document_title_separator( $sep ) {
	  $sep = '|';
	  return $sep; 
	}

	//著者ページとアーカイブページのタイトルを変更
	function sng_document_title_parts( $title_part ) {
	 	if ( is_author() ) {
	  		$title_part['title'] .= 'の書いた記事';
	  	} elseif ( is_archive() ) {
	  		$title_part['title'] = '「'.$title_part['title'].'」の記事一覧';
	  	}
		return $title_part;
	}

//タイトル全体を書き換え
function sng_pre_get_document_title( $title ){
  global $post;
  if (is_category() && output_archive_title()) {
    $title = output_archive_title();
  } elseif( $post && get_post_meta( $post->ID, 'sng_title', true ) && is_singular()) { // 修正
   $title = esc_attr(get_post_meta( $post->ID, 'sng_title', true ));
  }
  return $title;
}

add_theme_support( 'title-tag' );
add_filter( 'document_title_separator', 'sng_document_title_separator' );
add_filter( 'document_title_parts', 'sng_document_title_parts');
add_filter( 'pre_get_document_title', 'sng_pre_get_document_title' );


/*********************
meta robotsを制御
*********************/
//前提：カスタムフィールド（custom_field.php）で記事ごとに設定する


function sng_meta_robots() {
    global $post;
    $rogots_tags = '';

    if ( is_page() || is_single() ) { //記事・固定ページの場合

        $robots_r  = get_post_meta( $post->ID, "noindex_options", true );
        if( is_array($robots_r) ) {
          $rogots_tags = ( in_array('noindex', $robots_r) && !in_array('nofollow', $robots_r)) ? 'noindex,follow' : implode( ",", $robots_r ); }

    } elseif( is_paged() || is_tag() || is_date()){ //トップやアーカイブの2ページ目以降はindexせず、followだけ。タグページは1ページ目からnoindex

        $rogots_tags = 'noindex,follow';
    
    } elseif( is_search() ){ //検索結果はインデックスしない

        $rogots_tags = 'noindex,nofollow';
    
    } elseif( is_category() ){ //カテゴリーページ

    	//初期設定ではインデックス。下記のコメントアウトを外すとnoindexになります。
        //$rogots_tags = 'noindex,follow';
    
    }

    if($rogots_tags) echo '<meta name="robots" content="'.$rogots_tags.'" />';//出力
} //END meta_robots()

add_action( 'wp_head', 'sng_meta_robots' );


/*********************
メタタグ&OGPタグを出力
*********************/
//表示するのはトップページ＆カテゴリーページ＆著者ページのみ＆投稿ページのみ

function sng_meta_ogp() {
    global $post;
    $insert = '';
    $ogp_url = '';
    $ogp_img = '';
    $descr = '';

    //メタデスクリプションとOGPデスクリプション（メタデスクリプションは記入が無ければ出力しない）
    if( is_singular() && get_post_meta( $post->ID, 'sng_meta_description', true ) ) {
	    	//投稿ページでデスクリプションが入力されている場合
	    	$descr = get_post_meta( $post->ID, 'sng_meta_description', true );
	    	$insert = '<meta name="description" content="'.esc_attr($descr).'" />';

	    } elseif ( is_front_page() || is_home() ) {
	    	//トップページの場合
	    	$my_descr = get_option('home_description');
	    	$descr = $my_descr ? $my_descr : get_bloginfo('description');
	    	$insert = $my_descr ? '<meta name="description" content="'.esc_attr($my_descr).'" />' : '';

	    } elseif( get_the_archive_description() && is_category() ) {
	    	//カテゴリーページで本文が入力されている場合⇒タグを除いて出力
	    	$r = get_the_archive_description();//まだタグ付
				$descr = str_replace('&nbsp;', " ", strip_tags($r));
				$descr = str_replace(array("\r\n","\r","\n"), '', $descr);

	    } elseif(is_category()) {
	    	//カテゴリーページで本文が入力されていない場合は以下の文を出力
	    	$descr = get_bloginfo('name').'の「'.single_cat_title( '', false ).'」についての投稿一覧です。';
	    
	    } elseif( is_author() && get_the_author_meta('description')) {
	    	//著者ページの場合
	    	$descr = get_the_author_meta('description');	
	    } elseif(is_singular()) {
	    	setup_postdata($post);
	    	$descr = get_the_excerpt();
	    	wp_reset_postdata();
	    }


    $title = "";
    if( is_front_page() || is_home() ) {//トップページ
     $catchy = (get_bloginfo('description')) ? '｜'.get_bloginfo('description') : "";//キャッチフレーズ
     $title = get_bloginfo('name').$catchy;
    } elseif( is_category() ) {//カスタムフィールドにタイトルが入力されているかどうかの場合分け
     $title = (output_archive_title()) ? output_archive_title() : '「'.single_cat_title( '', false ).'」の記事一覧';
    } elseif( is_author() ) {//著者ページ
     $title = get_the_author_meta('display_name').'の書いた記事一覧';
    } elseif( $post ) {//投稿ページ
     $title = $post->post_title;
    }
 	
 	//ページタイプ
    $ogp_type = ( is_front_page() || is_home() ) ? 'website' : 'article';

    //表示中のURL
    if ( is_front_page() || is_home() ) {//トップページ
	    	$ogp_url = home_url();
	    } elseif ( is_category() ) {//カテゴリーページ
	    	$ogp_url = get_category_link( get_query_var('cat') );
	   	} elseif ( is_author() ) {//著者ページ
	   		$ogp_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
	   	} elseif (is_singular()) {//投稿ページ
	   		$ogp_url = get_permalink();
	   	}

    //og画像のURL
    if ( is_front_page() || is_home() || is_category() || is_author()) {//トップページとカテゴリー・著者ページ
	    	//デフォルト画像を使う。登録されていなければ、ロゴ画像
	    	$ogp_img = (get_option('thumb_upload')) ? get_option('thumb_upload') : get_option('logo_image_upload');
	   	} elseif (is_singular()) {
	   		$ogp_img = featured_image_src('large');
	   	}


   	//出力するOGPタグをまとめる
    $insert .= '<meta property="og:title" content="'.esc_attr($title).'" />' . "\n";
    $insert .= '<meta property="og:description" content="'.esc_attr($descr).'" />' . "\n";
    $insert .= '<meta property="og:type" content="'.$ogp_type.'" />' . "\n";
    $insert .= '<meta property="og:url" content="'.esc_url($ogp_url).'" />' . "\n";
    $insert .= '<meta property="og:image" content="'.esc_url($ogp_img).'" />' . "\n";
    $insert .= '<meta property="og:site_name" content="'.esc_attr(get_bloginfo('name')).'" />' . "\n";
    $insert .= '<meta name="twitter:card" content="summary_large_image" />' . "\n";

    //facebookのappdid
    if(get_option('fb_app_id')) {
    	$insert .= '<meta property="fb:app_id" content="'.get_option('fb_app_id').'">';
    }

    if( is_front_page() || is_home() || is_singular() || is_category() || is_author()){
    	echo $insert;
    }
   
} //END sng_meta_ogp

add_action('wp_head','sng_meta_ogp');


/*********************
分割した記事でrel next/prevを表示
*********************/
function rel_next_prev(){
	if(is_singular()){
		global $post;
		global $page;//現在のページ番号
		$pages = substr_count($post->post_content,'<!--nextpage-->') + 1;//総ページ数

		if ( $pages > 1 ) { //複数ページあるとき

			if ( $page == $pages ) {//最後のページの場合
				if ( $page == 2 ) {//2ページ目の場合
					echo '<link rel="prev" href="'.esc_url(get_permalink()).'">';
				} else {//最後2ページ目以外
					next_prev_permalink("prev",$page);
				}

			} else {//最後ではない場合
				if ( $page == 1 || $page == 0) { //1ページ目の場合
					next_prev_permalink("",$page);
				} elseif ( $page == 2 ) {//2ページ目＆最後のページでない
					echo '<link rel="prev" href="'.esc_url(get_permalink()).'">';
					next_prev_permalink("next",$page);
				} else { //3ページ目以降＆最後のページではないとき
						next_prev_permalink("prev",$page);
						next_prev_permalink("",$page);
				}
			}
		}
	}
}
add_action( 'wp_head', 'rel_next_prev' );

	//ページのnext/prevのリンクを出力（上記関数で利用）
	function next_prev_permalink($direction,$page) {

		if($direction == "prev") {
			$num = $page - 1;
		} else {
			$num = ($page == 0) ? $page + 2 : $page + 1 ;
		}

		if (get_option('permalink_structure') == '' ) {
	      $url = add_query_arg('page', $num, get_permalink());
	    } else {
	      $url = trailingslashit(get_permalink()).user_trailingslashit($num, 'single_paged');
	    }

	    if($direction == "prev") {
	    	$output = '<link rel="prev" href="'.$url.'">';
	    } else {
	    	$output = '<link rel="next" href="'.$url.'">';
	    }
	    echo $output;
	}
?>