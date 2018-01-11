<?php
/*
 * SANGOの様々な表現を実現するための関数です。
   - アイキャッチ画像のURLを取得
   - パンくずリスト
   - 記事一覧のページネイション（トップ/アーカイブページ用）
   - 記事一覧カード上にカテゴリー名を出力
   - NEWマーク
   - カテゴリーページのタイトルを調整
   - 記事内に広告挿入
   - モバイル用フッター固定メニュー
   - Google Analyticsコードをフッターに挿入
   - embedコンテンツの最大幅を設定
   - エディタの整形設定
 */
/*******************************
 アイキャッチ画像のURLを取得
*******************************/

/*アイキャッチ画像のURLを取得する関数*/
function imgurl($size_name){
      $thumid = get_post_thumbnail_id(); 
      $imgsrc = wp_get_attachment_image_src( $thumid , $size_name );
      return  $imgsrc[0];}


/*サイズを指定して画像のURLを取得*/
function featured_image_src($size) {
  $registered = esc_url(get_option('thumb_upload'));//カスタマイザーで登録された画像URL

  if(has_post_thumbnail()){// 1)記事にサムネイル画像あり

      $output_src = imgurl($size);

    } elseif($registered) {// 2)サムネイル画像なし&デフォルト画像登録済み

          if($size == 'thumb-160') {//サムネイルサイズを取得

            $search = array('.jpg','.jpeg','.png','.gif','.bmp');
            $replace = array('-160x160.jpg','-160x160.jpeg','-160x160.png','-160x160.gif','-160x160.bmp');
            $output_src = str_replace($search, $replace , $registered);

          } elseif($size == 'thumb-520') {//中サイズを取得

            $search = array('.jpg','.jpeg','.png','.gif','.bmp');
            $replace = array('-520x300.jpg','-520x300.jpeg','-520x300.png','-520x300.gif','-520x300.bmp');
            $output_src = str_replace($search, $replace , $registered);

          } else {

            $output_src = $registered;

          }

    } else {//3)その他の場合テンプレートフォルダから

          if($size == 'thumb-160') {
            $output_src = get_template_directory_uri() . '/library/images/default_thumb.jpg';
          } elseif($size == 'thumb-520') {
            $output_src = get_template_directory_uri() . '/library/images/default_small.jpg';
          } else {
            $output_src = get_template_directory_uri() . '/library/images/default.jpg';
          }

    }
    return $output_src;
}//END featured_image_src

/*********************
 パンくずリスト
*********************/
if( ! function_exists( 'breadcrumb' ) ) {
  function breadcrumb(){
      global $post;
      $str ='';

        if( !is_home()&&!is_admin() ){//トップページ、管理画面では表示しない

            $str.= '<nav id="breadcrumb"><ul itemscope itemtype="http://schema.org/BreadcrumbList">';

            //ホームのぱんくず
            $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. home_url() .'" itemprop="item"><span itemprop="name">ホーム</span></a><meta itemprop="position" content="1" /></li>';

            if( is_category() ) {//カテゴリーページ
              $cat = get_queried_object();
              if($cat -> parent != 0){
                  $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
                  $i = 2;
                  foreach($ancestors as $ancestor){
                    $str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url(get_category_link($ancestor)) .'" itemprop="item"><span itemprop="name">'. esc_attr(get_cat_name($ancestor)) .'</span></a><meta itemprop="position" content="'.$i.'" /></li>';
                    $i++;
                  } //endforeach
              } //END カテゴリー

            } elseif( is_tag() ) {//タグページ
                $str .= '<li><i class="fa fa-tag"></i> タグ</li>'; 

            } elseif( is_date() ){//日付ページ
              if(is_day()){
                $str .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_year_link(get_query_var('year')).'" itemprop="item"><span itemprop="name">'.get_query_var('year').'年</span></a><meta itemprop="position" content="2" /></li>';
                $str .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_month_link(get_query_var('year'), get_query_var('monthnum')).'" itemprop="item"><span itemprop="name">'.get_query_var('monthnum').'月</span></a><meta itemprop="position" content="3" /></li>';
              } elseif(is_month()){
                $str .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_year_link(get_query_var('year')).'" itemprop="item"><span itemprop="name">'.get_query_var('year').'年</span></a><meta itemprop="position" content="2" /></li>';
              } 
            
            } elseif( is_author() ){//著者ページ
              $str .= '<li>著者</li>';
            } elseif( is_page() ){
                if($post -> post_parent != 0 ){
                    $ancestors = array_reverse(get_post_ancestors( $post->ID ));
                    $i = 2;
                    foreach($ancestors as $ancestor){
                        $str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url(get_permalink($ancestor)).'" itemprop="item"><span itemprop="name">'. esc_attr(get_the_title($ancestor)) .'</span></a><meta itemprop="position" content="'.$i.'" /></li>';
                        $i++;
                    }
                }
            } elseif( is_single() ){//投稿ページ
                $categories = get_the_category($post->ID);
                if(!$categories) return false;
                $cat = $categories[0];
                $i = 2;
                if($cat -> parent != 0){
                    $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
                    foreach($ancestors as $ancestor){
                        $str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url(get_category_link($ancestor)).'" itemprop="item"><span itemprop="name">'. esc_attr(get_cat_name($ancestor)). '</span></a><meta itemprop="position" content="'.$i.'" /></li>';
                        $i++;
                    }
                }
                $str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url(get_category_link($cat -> term_id)). '" itemprop="item"><span itemprop="name">'. esc_attr($cat-> cat_name) . '</span></a><meta itemprop="position" content="'.$i.'" /></li>';

            } else {//それ以外のページ
                $str.='<li>'. wp_title('', false) .'</li>';
            }
            $str.='</ul></nav>';
      }
      echo $str;
  }
}

/*********************
 記事一覧のページネイション
  ⇒ トップページやアーカイブページで使用
*********************/
function sng_page_navi() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;
  echo '<nav class="pagination dfont">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '<i class="fa fa-chevron-left"></i>',
    'next_text'    => '<i class="fa fa-chevron-right"></i>',
    'type'         => 'list',
    'end_size'     => 1,
    'mid_size'     => 1
  ) );
  echo '</nav>';
} /* end page navi */

/*********************
 リンク付きでカテゴリー名を出力
 ⇒ トップページの記事一覧のサムネイル上に
*********************/
function output_catogry_link() {
  $cat = get_the_category();
  if(!$cat) return false;
  $cat = $cat[0];
  $catId = $cat->cat_ID;
  $catName = esc_attr($cat->cat_name);
  $catLink = esc_url(get_category_link($catId));
  if($catLink && $catName) echo '<a class="dfont cat-name catid'.$catId.'" href="'.$catLink.'">'.$catName.'</a>';
} 

/*********************
記事一覧にNEWマークを出力
*********************/
function newmark() {
  if(get_option('new_mark_date') == '0') {
    $days = null;
  } elseif(get_option('new_mark_date')) {
    $days = esc_attr(get_option('new_mark_date'));
  } else {
    $days = '3';
  }
  $daysInt = ((int)$days-1)*86400;
  $today = time();
  $entry = get_the_time('U');
  $dayago = $today-$entry;
    if (($dayago < $daysInt) && $days) {
    echo '<div class="dfont newmark accent-bc">NEW</div>';
    }
} 

/*********************
 カテゴリーページのタイトル
*********************/
//カテゴリーページ用の「オリジナルタイトルの入力欄」を表示
  function add_archive_title($term) {
     $termid = $term->term_id;
     $taxonomy = $term->taxonomy;
     $term_meta = get_option( $taxonomy . '_' . $termid );
    ?>
     <tr class="form-field">
        <th scope="row"><label for="term_meta[category_title]">ページタイトル</label></th>
        <td>
          <textarea name="term_meta[category_title]" id="term_meta[category_title]" rows="1" cols="50" class="large-text"><?php echo isset($term_meta['category_title']) ? esc_attr( $term_meta['category_title'] ) : ''; ?></textarea>
          <p class="description">カテゴリーページのタイトルを入力します。空欄の場合、カテゴリー名がページタイトルとなります。</p>
        </td>
     </tr>
    <?php
    }

    //オリジナルタイトルを保存
    function save_archive_title( $term_id ) {
     global $taxonomy;
     if ( isset( $_POST['term_meta'] ) ) {
      $term_meta = get_option( $taxonomy . '_' . $term_id );
      $term_keys = array_keys($_POST['term_meta']);
      foreach ($term_keys as $key){
       if (isset($_POST['term_meta'][$key])){
        $term_meta[$key] = stripslashes_deep( $_POST['term_meta'][$key] );
       }
      }
      update_option( $taxonomy . '_' . $term_id, $term_meta );
     }
    }

    //オリジナルカテゴリータイトルがあれば返す
    function output_archive_title(){
        if(is_category()){
          $term_info = get_term(get_query_var('cat'), "category");
          $term_meta = get_option( $term_info->taxonomy . '_' . $term_info->term_id );
        }

        if(isset($term_meta['category_title'])){
          return esc_attr( $term_meta['category_title'] );}
    }

  /*アーカイブの説明欄でHTMLタグを使えるように*/
  remove_filter( 'pre_term_description', 'wp_filter_kses' );

  /*子カテゴリーがある場合に一覧リンクを表示*/
  function output_categories_list(){
    $catinfo = get_category(get_query_var('cat')); 
    $children = wp_list_categories('show_option_none=&echo=0&show_count=0&depth=1&title_li=&child_of=' . $catinfo->cat_ID);
    if (!empty($children)) { ?>
    <div class="cat_list"><ul>
      <?php echo $children; ?>
    </ul></div>
    <?php }
    }

add_action('category_edit_form_fields','add_archive_title'); //カテゴリー
add_action( 'edited_term', 'save_archive_title' ); //値を保存



/*********************
「日/月/年」の記事一覧、という文字を生成
*********************/
function sng_date_title() {
  $title = get_query_var( 'year' ).'年 ';
  if( is_day() ){
      $title .= get_query_var( 'monthnum' ).'月 ';
      $title .= get_query_var( 'day' ).'日';
    } elseif( is_month() ) {
      $title .= get_query_var( 'monthnum' ).'月 ';
    } else {
    }
    $title .= 'の記事一覧';
    return $title;
}

/*********************
 カテゴリーページの表示タイトルを変更
*********************/
  add_filter( 'get_the_archive_title', function ($title) {
      if ( is_category() ) {
              $title = single_cat_title( '', false );//カテゴリー
          } elseif ( is_tag() ) {
              $title = single_tag_title( '', false );//タグ
          } elseif ( is_date() ) {//日付
              $title = get_query_var( 'year' ).'年';
              if( is_day() ){
                $title .= get_query_var( 'monthnum' ).'月';
                $title .= get_query_var( 'day' ).'日';
              } elseif( is_month() ) {
                $title .= get_query_var( 'monthnum' ).'月';
              } 
          }
        return $title;
      });


/*********************
記事中の1番目のh2見出し下に広告を配置
*********************/
function ads_before_headline($the_content) { 
  global $post;
  if ( is_single() && is_active_sidebar('ads_in_contents') && !get_post_meta( $post->ID, 'disable_ads', true )) {//見出し前広告のウィジェットがアクティブのとき
    if( !defined('H2S') ){
      define('H2S', '/<h2.*?>/i');
    }
    preg_match_all( H2S, $the_content, $matches );

    //ウィジェットを$adに格納
    ob_start();
      dynamic_sidebar('ads_in_contents');
    $ad = ob_get_contents();
    ob_end_clean();
      if($matches) {//H2見出しが本文中にあるかどうか
          if ( isset($matches[0][0]) ) {//1番目のH2見出し手前に広告を挿入
            $the_content = preg_replace( H2S, $ad.$matches[0][0], $the_content, 1);
          }
      }
  }
  return $the_content;
}
add_filter('the_content','ads_before_headline');

/*************************
フッターにアナリティクスのコードを挿入
**************************/
/*IDはカスタマイザーで設定*/
function add_GA_code() {
  if(get_option('ga_code')) : //Analyticsのトラッキング ?>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
          ga('create', '<?php echo esc_html(get_option('ga_code')); ?>', 'auto');
          ga('send', 'pageview');
        </script>
  <?php endif;
} 
add_action('wp_footer', 'add_GA_code');

/*******************************
 モバイル用フッター固定メニュー
*******************************/
function footer_nav_menu(){
if(wp_is_mobile() && has_nav_menu('mobile-fixed')) {//モバイルのみ
  echo '<nav class="fixed-menu">';
  wp_nav_menu(array(
   'container' => false, 
   'theme_location' => 'mobile-fixed', 
     'depth' => 1
     )); 
  echo '</nav>';

  //フォローボタン機能
  if(get_option('footer_fixed_follow')){
    $tw =  (get_option('like_box_twitter')) ? 'https://twitter.com/'.esc_attr(get_option('like_box_twitter')) : null;
    $fb = (get_option('like_box_fb')) ? esc_url(get_option('like_box_fb')) : null;
    $fdly = (get_option('like_box_feedly')) ? esc_url(get_option('like_box_feedly')) : null;
?>
  <div class="fixed-menu__follow dfont">
    <span>Follow</span>
      <?php if($tw) : ?>
        <a href="<?php echo $tw; ?>" class="follow-tw" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i> Twitter</a>
      <?php endif;
            if($fb) : ?>
        <a href="<?php echo $fb; ?>" class="follow-fb" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i> Facebook</a>
      <?php endif; 
            if($fdly) : ?>
        <a href="<?php echo $fdly; ?>" class="follow-fdly" target="_blank" rel="nofollow"><i class="fa fa-rss"></i> Feedly</a>
      <?php endif; ?>
  </div>
<?php } //END フォローボタン

  //シェアボタン機能
  if(get_option('footer_fixed_share')) { ?>
    <div class="fixed-menu__share sns-dif normal-sns">
      <?php insert_social_buttons(); ?>
    </div>
<?php } //END シェアボタン ?>
  <script>
    $(document).ready(function() {
      $(".archive a[href = '#sng_share']").closest('li').css('display','none');
      $(".fixed-menu a[href = '#']").click(function(event) {
          event.preventDefault();
          $('html, body').animate({scrollTop: 0}, 300);
      })
      $("a[href = '#sng_share']").click(function(event) {
          event.preventDefault();
          $(".fixed-menu__share , a[href = '#sng_share']").toggleClass("active");
          $(".fixed-menu__follow, a[href = '#sng_follow']").removeClass("active");
      })
      $("a[href = '#sng_follow']").click(function(event) {
          event.preventDefault();
          $(".fixed-menu__follow, a[href = '#sng_follow']").toggleClass("active");
          $(".fixed-menu__share, a[href = '#sng_share']").removeClass("active");
      })
    });
  </script>
<?php
  }
}
/*********************************
 embedコンテンツの最大幅の指定
***********************************/
if ( ! isset( $content_width ) ) {
  $content_width = 680;
}

/*********************
WordPress初期設定の絵文字を読み込む設定を停止
*********************/
if(get_option('disable_emoji_js')){
  remove_action('wp_head', 'print_emoji_detection_script', 7 );
  remove_action('wp_print_styles', 'print_emoji_styles');
}
/*********************
エディターの自動整形をオフに
*********************/
if(get_option('never_wpautop')){
function override_mce_options( $init_array ) {
    global $allowedposttags;
    $init_array['valid_elements']          = '*[*]';
    $init_array['extended_valid_elements'] = '*[*]';
    $init_array['valid_children']          = '+a[' . implode( '|', array_keys( $allowedposttags ) ) . ']';
    $init_array['indent']                  = true;
    $init_array['wpautop']                 = false;
    $init_array['force_p_newlines']        = false;
    return $init_array;
}
add_filter( 'the_content', 'shortcode_unautop', 10 );
add_filter( 'tiny_mce_before_init', 'override_mce_options' );
remove_filter('the_content', 'wpautop');
remove_filter( 'the_excerpt', 'wpautop' );
}
/*********************
ショートコードをはさむpタグを削除
*********************/
/*ビジュアルエディタを使用している場合のため。必要に応じて削除してください。*/
function delete_p_shortcode($content = null) {
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );
    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'delete_p_shortcode');
/*********************
サイドバーのカテゴリーリンクに含まれるtitleタグを消去
*********************/
function sng_widget_categories_args( $cat_args ) {
    $cat_args['use_desc_for_title'] = 0;
    return $cat_args;
}
add_filter( 'widget_categories_args', 'sng_widget_categories_args' );
?>