<?php 
/*********************
このファイルではカスタマイザー関連の設定をまとめています。
色の設定はこのファイルの最下部に記載しています。
*********************/
add_action( 'customize_register', 'theme_customize_register' );

/*********************
サニタイゼーションコールバック関数
*********************/
/*checkbox*/
function theme_slug_sanitize_checkbox( $input ){
    return ( isset( $input ) ? true : false );
}

/*画像ファイルチェック*/
function theme_slug_sanitize_file( $file, $setting ) {   
    $mimes = array(
        'jpg|jpeg' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png'
    );
    $file_ext = wp_check_filetype( $file, $mimes );
    return ( $file_ext['ext'] ? $file : $setting->default );
}
/*radio*/
function theme_slug_sanitize_radio( $input, $setting ){
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
/********************* 以下カスタマイザーの関数 *********************/

function theme_customize_register($wp_customize) {
/*********************
トップページのデスクリプションを入力する項目を追加
*********************/
  $wp_customize->add_setting('home_description', array(
  'type' => 'option',
  'transport' => 'postMessage',
  array(
   'sanitize_callback' => 'wp_filter_nohtml_kses'
  )
    ));
    $wp_customize->add_control( 'home_description', array(
    'settings' => 'home_description',
    'label' => 'サイトの詳しい説明（100字以内推奨）',
    'description' => 'トップページのメタデスクリプションとして検索エンジンに伝わります。',
    'section' => 'title_tagline',
    'type' => 'textarea',
    ));
/*********************
タイトルロゴ画像の登録セクションを追加
*********************/
      $wp_customize->add_setting('logo_image_upload', array(
        'type' => 'option',
        array(
          'sanitize_callback' => 'theme_slug_sanitize_file'
        )
        ));
      if(class_exists('WP_Customize_Image_Control')):
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_image_upload', array(
          'settings' => 'logo_image_upload',
          'label' => 'ロゴ画像を登録（PNG/GIF/SVG推奨）',
          'section' => 'title_tagline',
        )));
      endif;
      //ロゴ画像だけを表示させるか
      $wp_customize->add_setting('onlylogo_checkbox', array(
        'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
      ));
        $wp_customize->add_control( 'onlylogo_checkbox', array(
        'settings' => 'onlylogo_checkbox',
        'label' => 'ロゴ画像だけを表示（文字を非表示に）',
        'section' => 'title_tagline',
        'type' => 'checkbox',
        ));
      //ロゴを中央に寄せるか
      $wp_customize->add_setting('center_logo_checkbox', array(
        'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )       
      ));
        $wp_customize->add_control( 'center_logo_checkbox', array(
        'settings' => 'center_logo_checkbox',
        'label' => '大画面表示時にもロゴを中央寄せ',
        'section' => 'title_tagline',
        'type' => 'checkbox',
        ));
/*********************
 デフォルトサムネイル画像登録
*********************/
  $wp_customize->add_section( 'default_thumbnail', array(
    'title' =>'デフォルトのサムネイル画像',
    'priority' => 50,
    'transport' => 'postMessage',
  ));
      $wp_customize->add_setting('thumb_upload', array(
        'type' => 'option',
        array(
          'sanitize_callback' => 'theme_slug_sanitize_file'
        )
        ));
      if(class_exists('WP_Customize_Image_Control')):
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'thumb_upload', array(
          'settings' => 'thumb_upload',
          'label' => '記事にアイキャッチ画像が登録されていないとき等に使用される画像です。必ず幅520px以上、高さ300px以上の画像を選びましょう（これ以下のサイズにすると表示されない場合があります）。',
          'description' => '正方形（150x150px）や、横長（520x300px）にトリミングされて使用されることがあります。',
          'section' => 'default_thumbnail',
        )));
      endif;
/*********************
ヘッダーアイキャッチ画像
*********************/
  $wp_customize->add_section( 'header_image', array(
    'title' =>'ヘッダーアイキャッチ画像',
    'priority' => 100,
  )); 
      //ヘッダーアイキャッチ画像を表示させるか
    $wp_customize->add_setting('header_image_checkbox', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'header_image_checkbox', array(
      'settings' => 'header_image_checkbox',
      'label' => 'ヘッダーアイキャッチ画像を表示',
      'description' => '<small>トップページにのみ表示される巨大なアイキャッチ画像です。</small>',
      'section' => 'header_image',
      'type' => 'checkbox',
      ));
    //画像をアップロードする
    $wp_customize->add_setting('original_image_upload', array(
      'type' => 'option',
      array(
        'sanitize_callback' => 'theme_slug_sanitize_file'
      )
      ));
    if(class_exists('WP_Customize_Image_Control')):
      $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'original_image_upload', array(
        'settings' => 'original_image_upload',
        'label' => '画像をアップロード',
        'section' => 'header_image',
      )));
    endif;
    //画像の最大横幅に制限を設けるか
    $wp_customize->add_setting('limit_header_width', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'limit_header_width', array(
      'settings' => 'limit_header_width',
      'label' => '画像の最大横幅に制限を設ける（推奨）',
      'section' => 'header_image',
      'type' => 'checkbox',
      ));
    //文字やボタンを表示せず画像のみ表示
    $wp_customize->add_setting('only_show_headerimg', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'only_show_headerimg', array(
      'settings' => 'only_show_headerimg',
      'label' => '文字やボタンを表示しない（画像のみ表示）',
      'description' => '<small>画像の縦横比が常に保たれるようになります。</small>',
      'section' => 'header_image',
      'type' => 'checkbox',
      ));
     //見出し
     $wp_customize->add_setting('header_big_txt', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'header_big_txt', array(
        'settings' => 'header_big_txt',
        'label' => '見出し',
        'section' => 'header_image',
        'description' => '<small>画像上に表示されます。</small>',
        'type' => 'text',
       ));
     //説明文
     $wp_customize->add_setting('header_sml_txt', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'header_sml_txt', array(
        'settings' => 'header_sml_txt',
        'label' => '説明文',
        'section' => 'header_image',
        'description' => '<small>画像上に表示される小さめのテキストです。</small>',
        'type' => 'textarea',
       ));
     //ボタンテキスト
     $wp_customize->add_setting('header_btn_txt', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'header_btn_txt', array(
        'settings' => 'header_btn_txt',
        'label' => 'ボタンテキスト（挿入する場合）',
        'section' => 'header_image',
        'description' => '<small>ボタンを挿入する場合に入力します。</small>',
        'type' => 'text',
       ));
     //ボタンURL
     $wp_customize->add_setting('header_btn_url', array(
      'type' => 'option',
      array('sanitize_callback' => 'esc_url_raw')
      ));
       $wp_customize->add_control( 'header_btn_url', array(
        'settings' => 'header_btn_url',
        'label' => 'ボタンURL',
        'section' => 'header_image',
        'type' => 'url',
       ));
     //ボタンの色
     $wp_customize->add_setting( 'header_btn_color', array(
     'default' => '#ff90a1',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_btn_color', array(
       'label' => 'ボタン色',
       'section' => 'header_image',
       'settings' => 'header_btn_color',
       'priority' => 19,
       )));
/*********************
ヘッダー2分割アイキャッチ（左画像、右テキスト）
*********************/
  $wp_customize->add_section( 'header_divide_image', array(
    'title' =>'2分割ヘッダーアイキャッチ',
    'priority' => 100,
  ));
    //2分割アイキャッチ画像を表示させる
    $wp_customize->add_setting('header_divide_checkbox', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'header_divide_checkbox', array(
      'settings' => 'header_divide_checkbox',
      'label' => '2分割ヘッダーアイキャッチを表示',
      'description' => '<small>左側に画像、右側にテキストが表示されるヘッダーアイキャッチです（スマホだと縦に並びます）。トップページにのみ表示されます。</small>',
      'section' => 'header_divide_image',
      'type' => 'checkbox',
      ));
    //画像をアップロードする
    $wp_customize->add_setting('divheader_image_upload', array(
      'type' => 'option',
    array(
      'sanitize_callback' => 'theme_slug_sanitize_file'
    )
      ));
    if(class_exists('WP_Customize_Image_Control')):
      $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'divheader_image_upload', array(
        'settings' => 'divheader_image_upload',
        'label' => '画像をアップロード',
        'section' => 'header_divide_image',
      )));
    endif;
     //見出し
     $wp_customize->add_setting('divheader_big_txt', array(
     'type' => 'option',
     array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'divheader_big_txt', array(
        'settings' => 'divheader_big_txt',
        'label' => '見出し',
        'section' => 'header_divide_image',
        'type' => 'text',
       ));
     //説明文
     $wp_customize->add_setting('divheader_sml_txt', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'divheader_sml_txt', array(
        'settings' => 'divheader_sml_txt',
        'label' => '説明文',
        'section' => 'header_divide_image',
        'type' => 'textarea',
       ));
     //ボタンテキスト
     $wp_customize->add_setting('divheader_btn_txt', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'divheader_btn_txt', array(
        'settings' => 'divheader_btn_txt',
        'label' => 'ボタンテキスト（挿入する場合）',
        'section' => 'header_divide_image',
        'type' => 'text',
       ));
     //ボタンURL
     $wp_customize->add_setting('divheader_btn_url', array(
      'type' => 'option',
      array('sanitize_callback' => 'esc_url_raw')
      ));
       $wp_customize->add_control( 'divheader_btn_url', array(
        'settings' => 'divheader_btn_url',
        'label' => 'ボタンURL',
        'section' => 'header_divide_image',
        'type' => 'url',
       ));
     //背景色
    $wp_customize->add_setting( 'divide_background_color', array(
     'default' => '#93d1f0',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'divide_background_color', array(
       'label' => 'テキスト部分の背景色',
       'section' => 'header_divide_image',
       'settings' => 'divide_background_color',
       'priority' => 20,
       )));
     //見出し色
    $wp_customize->add_setting( 'divide_bigtxt_color', array(
     'default' => '#FFF',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'divide_bigtxt_color', array(
       'label' => '見出しカラー',
       'section' => 'header_divide_image',
       'settings' => 'divide_bigtxt_color',
       'priority' => 20,
       )));
     //説明文の色
    $wp_customize->add_setting( 'divide_smltxt_color', array(
     'default' => '#FFF',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'divide_smltxt_color', array(
       'label' => '説明文カラー',
       'section' => 'header_divide_image',
       'settings' => 'divide_smltxt_color',
       'priority' => 20,
       )));
     //ボタンの色
    $wp_customize->add_setting( 'divide_btn_color', array(
     'default' => '#6BB6FF',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'divide_btn_color', array(
       'label' => 'ボタン色',
       'section' => 'header_divide_image',
       'settings' => 'divide_btn_color',
       'priority' => 19,
       )));
/*********************
記事一覧レイアウト
*********************/
  $wp_customize->add_section( 'card_layout', array(
    'title' =>'記事一覧レイアウト',
    'priority' => 101,
  ));
      //【PCトップページ】記事一覧のカードを横長にする
    $wp_customize->add_setting('sidelong_layout', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'sidelong_layout', array(
      'settings' => 'sidelong_layout',
      'label' => '【PC】トップページの記事一覧カードを横長にする',
      'section' => 'card_layout',
      'type' => 'checkbox',
      ));
      //【モバイルトップページ】記事一覧のカードを横長にする
    $wp_customize->add_setting('mb_sidelong_layout', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'mb_sidelong_layout', array(
      'settings' => 'mb_sidelong_layout',
      'label' => '【モバイル】トップページの記事一覧カードを横長にする',
      'section' => 'card_layout',
      'description' => '<small>モバイル＝スマホ/タブレットでの表示</small>',
      'type' => 'checkbox',
      ));
      //【PCアーカイブページ】記事一覧のカードを横長にする
    $wp_customize->add_setting('archive_sidelong_layout', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'archive_sidelong_layout', array(
      'settings' => 'archive_sidelong_layout',
      'label' => '【PC】カテゴリー/アーカイブページの記事一覧カードを横長にする',
      'section' => 'card_layout',
      'type' => 'checkbox',
      ));
      //【モバイルアーカイブページ】記事一覧のカードを横長にする
    $wp_customize->add_setting('mb_archive_sidelong_layout', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'mb_archive_sidelong_layout', array(
      'settings' => 'mb_archive_sidelong_layout',
      'label' => '【モバイル】カテゴリー/アーカイブページの記事一覧カードを横長にする',
      'section' => 'card_layout',
      'type' => 'checkbox',
      ));
/*********************
記事下にフォローボックスを表示
*********************/
  $wp_customize->add_section( 'show_like_box', array(
    'title' =>'フォローボックス（記事下）',
    'priority' => 150,
  ));
    //フォローボックスを表示する
    $wp_customize->add_setting('enable_like_box', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'enable_like_box', array(
      'settings' => 'enable_like_box',
      'label' => 'フォローボックスを表示する',
      'description' => '<small>「この記事を気に入ったらいいね」というようなボックスです。</small>',
      'section' => 'show_like_box',
      'type' => 'checkbox',
      ));
     //画像上にのせるテキスト
     $wp_customize->add_setting('like_box_title', array(
    'type' => 'option',
    array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'like_box_title', array(
        'settings' => 'like_box_title',
        'label' => '画像上にのせるテキスト',
        'description' => '<small>「Follow Me!」など。空欄でも構いません。</small>',
        'section' => 'show_like_box',
        'type' => 'text',
       ));
     //Twitter
     $wp_customize->add_setting('like_box_twitter', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'like_box_twitter', array(
        'settings' => 'like_box_twitter',
        'label' => 'Twitterのユーザー名',
        'description' => '<small>@に続くユーザー名を入力してください（@は含めない）。名前が空欄の場合には表示されません。</small>',
        'section' => 'show_like_box',
        'type' => 'text',
       ));
    //Twitterのフォロワー数を表示
    $wp_customize->add_setting('follower_count', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'follower_count', array(
      'settings' => 'follower_count',
      'label' => 'Twitterのフォロワー数を表示',
      'section' => 'show_like_box',
      'type' => 'checkbox',
      ));
     //Facebook
     $wp_customize->add_setting('like_box_fb', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'like_box_fb', array(
        'settings' => 'like_box_fb',
        'label' => 'FacebookページのURL',
        'description' => '<small>空欄の場合には表示されません。</small>',
        'section' => 'show_like_box',
        'type' => 'text',
       ));
     //Feedly
     $wp_customize->add_setting('like_box_feedly', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'like_box_feedly', array(
        'settings' => 'like_box_feedly',
        'label' => 'FeedlyのURL',
        'description' => '<small>空欄の場合には表示されません。</small>',
        'section' => 'show_like_box',
        'type' => 'text',
       ));
/*********************
関連記事
*********************/
  //セクション追加
  $wp_customize->add_section( 'sng_related_posts', array(
    'title' =>'関連記事（記事下）',
    'priority' => 149,
  ));
     //関連記事をオフに
     $wp_customize->add_setting('no_related_posts', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
      ));
       $wp_customize->add_control( 'no_related_posts', array(
        'settings' => 'no_related_posts',
        'label' => '記事下に関連記事を表示しない',
        'section' => 'sng_related_posts',
        'type' => 'checkbox',
       ));
      //関連記事のタイトル
     $wp_customize->add_setting('related_post_title', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'related_post_title', array(
        'settings' => 'related_post_title',
        'label' => '関連記事のタイトル',
        'section' => 'sng_related_posts',
        'type' => 'text',
       ));
      //関連記事のデザイン
      $wp_customize->add_setting( 
            'related_posts_type', 
            array(
              'default' => 'type_a',
              'sanitize_callback' => 'theme_slug_sanitize_radio'
            )
        );
        $wp_customize->add_control( 'related_posts_type', array(
                'label' => '関連記事のデザイン',
                'settings' => 'related_posts_type',
                'section' => 'sng_related_posts',
                'description' => '<small>それぞれの表示イメージは<a href="https://saruwakakun.com/sango/customizer#relatedfunc" target="_blank">こちら</a>から確認できます。</small>',
                'type' => 'radio',
                'choices' => array(
                    'type_a' => 'タイプA',
                    'type_b' => 'タイプB（カード）',
                    'type_c' => 'タイプC（横長）')               
                )
        );
     //モバイル表示
     $wp_customize->add_setting('related_no_slider', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
      ));
       $wp_customize->add_control( 'related_no_slider', array(
        'settings' => 'related_no_slider',
        'label' => 'モバイル表示で関連記事をスライダー表示にしない',
        'description' => '<small>スマホ/タブレット表示で関連記事を横スクロール表示にしない場合には、こちらにチェックを入れます。タイプCではチェックの有無に関わらず、スクロールなしになります。</small>',
        'section' => 'sng_related_posts',
        'type' => 'checkbox',
       ));
     //親カテゴリーに含まれる記事を出力
     $wp_customize->add_setting('related_add_parent', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
      ));
       $wp_customize->add_control( 'related_add_parent', array(
        'settings' => 'related_add_parent',
        'label' => '親カテゴリーに属する記事も含める',
        'description' => '<small>デフォルトでは同カテゴリーの記事のみが出力されます。こちらにチェックを入れると「親カテゴリー」と「親カテゴリーに含まれる子カテゴリー」の記事も合わせてランダムで出力するようになります。</small>',
        'section' => 'sng_related_posts',
        'type' => 'checkbox',
       )); 
     //関連記事の出力数
     $wp_customize->add_setting('num_related_posts', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'absint')
      ));
       $wp_customize->add_control( 'num_related_posts', array(
        'settings' => 'num_related_posts',
        'label' => '関連記事の表示数',
        'section' => 'sng_related_posts',
        'type' => 'number',
       ));
/*********************
記事下におすすめの記事を出力
*********************/
  //セクション追加
  $wp_customize->add_section( 'recommended_posts', array(
    'title' =>'おすすめ記事（記事下）',
    'priority' => 149,
  ));
      //チェックボックスおすすめ記事を表示させるかどうか
    $wp_customize->add_setting('enable_recommend', array(
       'type' => 'option',
       'priority' => 1,
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'enable_recommend', array(
      'settings' => 'enable_recommend',
      'label' => 'おすすめ記事を記事下に表示',
      'description' => '<small>記事下に指定した投稿IDの記事を表示します。アイキャッチ画像が登録されている記事のみ指定することができます。</small>',
      'section' => 'recommended_posts',
      'type' => 'checkbox',
      ));
    //セクションの見出し
     $wp_customize->add_setting('recommend_title', array(
    'type' => 'option',
    'priority' => 2,
    'transport' => 'postMessage',
    array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'recommend_title', array(
        'settings' => 'recommend_title',
        'label' => '見出し',
        'description' => '<small>例：おすすめの記事</small>',
        'section' => 'recommended_posts',
        'type' => 'text',
       ));
     //リンク1
    $wp_customize->add_setting('recid1', array(
        'type' => 'option',
        'transport' => 'postMessage',
        array('sanitize_callback' => 'wp_filter_nohtml_kses')
        ));
       $wp_customize->add_control( 'recid1', array(
        'settings' => 'recid1',
        'label' => 'おすすめ記事(1)のID',
        'description' => '<small>例:145</small>',
        'section' => 'recommended_posts',
        'type' => 'text',
       ));
      //リンク1のタイトル
       $wp_customize->add_setting('rectitle1', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
        ));
         $wp_customize->add_control( 'rectitle1', array(
          'settings' => 'rectitle1',
          'label' => 'ーおすすめ記事(1)のタイトル',
          'description' => '<small>※空欄の場合、もともとのタイトルを表示します。</small>',
          'section' => 'recommended_posts',
          'type' => 'text',
         ));
     //リンク2
    $wp_customize->add_setting('recid2', array(
        'type' => 'option',
        'transport' => 'postMessage',
        array('sanitize_callback' => 'wp_filter_nohtml_kses')
        ));
       $wp_customize->add_control( 'recid2', array(
        'settings' => 'recid2',
        'label' => 'おすすめ記事(2)のID',
        'section' => 'recommended_posts',
        'type' => 'text',
       ));
      //リンク2のタイトル
       $wp_customize->add_setting('rectitle2', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
        ));
         $wp_customize->add_control( 'rectitle2', array(
          'settings' => 'rectitle2',
          'label' => 'ーおすすめ記事(2)のタイトル',
          'description' => '<small>※空欄の場合、もともとのタイトルを表示します。</small>',
          'section' => 'recommended_posts',
          'type' => 'text',
         ));
     //リンク3
    $wp_customize->add_setting('recid3', array(
        'type' => 'option',
        'transport' => 'postMessage',
        array('sanitize_callback' => 'wp_filter_nohtml_kses')
        ));
       $wp_customize->add_control( 'recid3', array(
        'settings' => 'recid3',
        'label' => 'おすすめ記事(3)のID',
        'section' => 'recommended_posts',
        'type' => 'text',
       ));
      //リンク3のタイトル
       $wp_customize->add_setting('rectitle3', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
        ));
         $wp_customize->add_control( 'rectitle3', array(
          'settings' => 'rectitle3',
          'label' => 'ーおすすめ記事(3)のタイトル',
          'description' => '<small>※空欄の場合、もともとのタイトルを表示します。</small>',
          'section' => 'recommended_posts',
          'type' => 'text',
         ));
     //リンク4
    $wp_customize->add_setting('recid4', array(
        'type' => 'option',
        'transport' => 'postMessage',
        array('sanitize_callback' => 'wp_filter_nohtml_kses')
        ));
       $wp_customize->add_control( 'recid4', array(
        'settings' => 'recid4',
        'label' => 'ーおすすめ記事(4)のID',
        'section' => 'recommended_posts',
        'type' => 'text',
       ));
      //リンク4のタイトル
       $wp_customize->add_setting('rectitle4', array(
      'type' => 'option',
      'transport' => 'postMessage',
       array('sanitize_callback' => 'wp_filter_nohtml_kses')
        ));
         $wp_customize->add_control( 'rectitle4', array(
          'settings' => 'rectitle4',
          'label' => 'おすすめ記事(4)のタイトル',
          'description' => '<small>※空欄の場合、もともとのタイトルを表示します。</small>',
          'section' => 'recommended_posts',
          'type' => 'text',
         ));
/*********************
記事下に表示させるCTA
*********************/
  $wp_customize->add_section( 'show_cta', array(
    'title' =>'CTA（記事下）',
    'priority' => 150,
  ));
    //CTAを記事下に表示する
    $wp_customize->add_setting('enable_cta', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'enable_cta', array(
      'settings' => 'enable_cta',
      'label' => 'CTAを記事下に表示する',
      'section' => 'show_cta',
      'type' => 'checkbox',
      ));
     //表示しないカテゴリー
     $wp_customize->add_setting('no_cta_cat', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
     $wp_customize->add_control( 'no_cta_cat', array(
      'settings' => 'no_cta_cat',
      'label' => 'CTAを表示しないカテゴリーのID（複数指定は半角カンマ,で区切る）',
      'section' => 'show_cta',
      'type' => 'text',
     ));
    //画像をアップロードする
    $wp_customize->add_setting('cta_image_upload', array(
      'type' => 'option',
        array(
          'sanitize_callback' => 'theme_slug_sanitize_file'
        )
      ));
    if(class_exists('WP_Customize_Image_Control')):
      $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cta_image_upload', array(
        'settings' => 'cta_image_upload',
        'label' => 'CTA用の画像をアップロード',
        'section' => 'show_cta',
      )));
    endif;
    //背景色
    $wp_customize->add_setting( 'cta_background_color', array(
     'default' => '#FFF',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cta_background_color', array(
       'label' => 'CTA全体の背景色',
       'section' => 'show_cta',
       'settings' => 'cta_background_color',
       'priority' => 20,
       )));
     //見出し色
    $wp_customize->add_setting( 'cta_bigtxt_color', array(
     'default' => '#333',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cta_bigtxt_color', array(
       'label' => '見出し色',
       'section' => 'show_cta',
       'settings' => 'cta_bigtxt_color',
       'priority' => 20,
       )));
     //説明文の色
    $wp_customize->add_setting( 'cta_smltxt_color', array(
     'default' => '#333',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cta_smltxt_color', array(
       'label' => '説明文の色',
       'section' => 'show_cta',
       'settings' => 'cta_smltxt_color',
       'priority' => 20,
       )));
     //ボタンの色
    $wp_customize->add_setting( 'cta_btn_color', array(
     'default' => '#ffb36b',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cta_btn_color', array(
       'label' => 'ボタン色',
       'section' => 'show_cta',
       'settings' => 'cta_btn_color',
       'priority' => 21,
       )));
     //見出し文
     $wp_customize->add_setting('cta_big_txt', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'cta_big_txt', array(
        'settings' => 'cta_big_txt',
        'label' => '見出し文',
        'section' => 'show_cta',
        'type' => 'text',
       ));
     //本文
     $wp_customize->add_setting('cta_sml_txt', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_kses_post')
      ));
       $wp_customize->add_control( 'cta_sml_txt', array(
        'settings' => 'cta_sml_txt',
        'label' => '説明文',
        'section' => 'show_cta',
        'type' => 'textarea',
       ));
     //ボタンテキスト
     $wp_customize->add_setting('cta_btn_txt', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'cta_btn_txt', array(
        'settings' => 'cta_btn_txt',
        'label' => 'ボタンテキスト',
        'section' => 'show_cta',
        'type' => 'text',
       ));
     //ボタンURL
     $wp_customize->add_setting('cta_btn_url', array(
      'type' => 'option',
      array('sanitize_callback' => 'esc_url_raw')
      ));
       $wp_customize->add_control( 'cta_btn_url', array(
        'settings' => 'cta_btn_url',
        'label' => 'ボタンURL',
        'section' => 'show_cta',
        'type' => 'url',
       ));
/*********************
ヘッダーお知らせ欄
*********************/
  $wp_customize->add_section( 'header_info', array(
    'title' =>'ヘッダーお知らせ欄',
    'priority' => 150,
  ));
     //ボタンテキスト
     $wp_customize->add_setting('header_info_text', array(
      'type' => 'option',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'header_info_text', array(
        'settings' => 'header_info_text',
        'description' => '<small>入力すると表示されるようになります。FontAwesomeのアイコンも使用できます。</small>',
        'label' => 'お知らせ文',
        'section' => 'header_info',
        'type' => 'text',
       ));
     //背景色1
    $wp_customize->add_setting( 'header_info_c1', array(
     'default' => '#738bff',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_info_c1', array(
       'label' => '背景色1',
       'description' => '<small>背景のグラデーションの片側の色です。</small>',
       'section' => 'header_info',
       'settings' => 'header_info_c1',
       )));
     //背景色2
    $wp_customize->add_setting( 'header_info_c2', array(
     'default' => '#85e3ec',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_info_c2', array(
       'label' => '背景色2',
       'description' => '<small>グラデーションのもう片側の色です。グラデーションにしない場合には、両方の色を合わせてください。</small>',
       'section' => 'header_info',
       'settings' => 'header_info_c2',
       )));
     //文字色
    $wp_customize->add_setting( 'header_info_c', array(
     'default' => '#FFF',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_info_c', array(
       'label' => '文字色',
       'section' => 'header_info',
       'settings' => 'header_info_c',
       )));
     //リンク先
     $wp_customize->add_setting('header_info_url', array(
      'type' => 'option',
      array('sanitize_callback' => 'esc_url_raw')
      ));
       $wp_customize->add_control( 'header_info_url', array(
        'settings' => 'header_info_url',
        'label' => 'リンク先URL',
        'section' => 'header_info',
        'type' => 'url',
       ));
/*********************
トップへ戻るボタン
*********************/
  $wp_customize->add_section( 'to_top', array(
    'title' =>'トップへ戻るボタン',
    'priority' => 150,
  ));
    //表示する
    $wp_customize->add_setting('show_to_top', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'show_to_top', array(
      'settings' => 'show_to_top',
      'label' => '【モバイル表示】トップへ戻るボタンを表示する',
      'description' => '<small>記事ページ/固定ページにのみ表示されます。</small>',
      'section' => 'to_top',
      'type' => 'checkbox',
      ));
    //表示する
    $wp_customize->add_setting('pc_show_to_top', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'pc_show_to_top', array(
      'settings' => 'pc_show_to_top',
      'label' => '【PC表示】トップへ戻るボタンを表示する',
      'description' => '<small>記事/固定ページにのみ表示されます。</small>',
      'section' => 'to_top',
      'type' => 'checkbox',
      ));
    //ボタンの色
    $wp_customize->add_setting( 'to_top_color', array(
     'default' => '#5ba9f7',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'to_top_color', array(
       'label' => 'ボタン色',
       'description' => '<small>ボタンは半透明になるため、濃い目の色を選びましょう。</small>',
       'section' => 'to_top',
       'settings' => 'to_top_color',
       'priority' => 21,
       )));
/*********************
フッター固定メニュー
*********************/
  $wp_customize->add_section( 'footer_fixed', array(
    'title' =>'フッター固定メニュー（モバイルのみ）',
    'priority' => 150,
    'description' => '<small>［外観］⇒［メニュー］で「モバイル用フッター固定メニュー」を作成・登録するとモバイル（スマホ・タブレット）で表示されるようになります。詳しい設定方法は<a href="https://saruwakakun.com/sango/mb_footer" target="_blank">カスタマイズガイド</a>で解説しています。<br>こちらでは、細かな設定を行うことができます。</small>'
  ));
    //シェアボタン
    $wp_customize->add_setting('footer_fixed_share', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'footer_fixed_share', array(
      'settings' => 'footer_fixed_share',
      'label' => 'シェアボタン機能を使用する',
      'description' => '<small>さらにシェアボタン用のメニューを追加する必要があります。詳しい設定はカスタマイズガイドをご覧ください。</small>',
      'section' => 'footer_fixed',
      'type' => 'checkbox',
      ));
    //フォローボタン
    $wp_customize->add_setting('footer_fixed_follow', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'footer_fixed_follow', array(
      'settings' => 'footer_fixed_follow',
      'label' => 'フォローボタン機能を使用する',
      'description' => '<small>さらにフォローボタン用のメニューを追加する必要があります。</small>',
      'section' => 'footer_fixed',
      'type' => 'checkbox',
      ));
    //背景色
    $wp_customize->add_setting( 'footer_fixed_bc', array(
     'default' => '#FFF',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_fixed_bc', array(
       'label' => 'メニューの背景色',
       'section' => 'footer_fixed',
       'settings' => 'footer_fixed_bc',
       'priority' => 21,
       )));
    //メニューのテキストカラー
    $wp_customize->add_setting( 'footer_fixed_c', array(
     'default' => '#a2a7ab',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_fixed_c', array(
       'label' => 'メニューの文字/アイコン色',
       'section' => 'footer_fixed',
       'settings' => 'footer_fixed_c',
       'priority' => 21,
       )));
    //アクティブカラー
    $wp_customize->add_setting( 'footer_fixed_actc', array(
     'default' => '#6bb6ff',
     'sanitize_callback' => 'sanitize_hex_color'
     ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_fixed_actc', array(
       'label' => 'アクティブカラー',
       'section' => 'footer_fixed',
       'settings' => 'footer_fixed_actc',
       'description' => '<small>メニューがタップされたときなどの文字/アイコン色です。メインカラーと合わせるのがおすすめです。</small>',
       'priority' => 21,
       )));

/*********************
細かな設定
*********************/
  $wp_customize->add_section( 'other_options', array(
    'title' =>'詳細設定',
    'priority' => 150,
  ));
      //記事下のシェアボタンを別デザインに
    $wp_customize->add_setting('another_social', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'another_social', array(
      'settings' => 'another_social',
      'label' => 'シェアボタンを別デザインにする（Google+なし）',
      'section' => 'other_options',
      'type' => 'checkbox',
      ));
     //FABをオフにする
    $wp_customize->add_setting('no_fab', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'no_fab', array(
      'settings' => 'no_fab',
      'label' => '記事タイトル下の円形シェアボタンをオフにする',
      'section' => 'other_options',
      'type' => 'checkbox',
      ));
      //タイトル下にシェアボタンを設置
    $wp_customize->add_setting('open_fab', array(
      'type' => 'option',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'open_fab', array(
      'settings' => 'open_fab',
      'label' => 'タイトル下にシェアボタンを並べて表示',
      'description' => '<small>タイトル下に普通に並べて表示したいときにチェックを入れてください</small>',
      'section' => 'other_options',
      'type' => 'checkbox',
      ));
      //スマホ閲覧時にサイドバーを非表示に
    $wp_customize->add_setting('no_sidebar_mobile', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'no_sidebar_mobile', array(
      'settings' => 'no_sidebar_mobile',
      'label' => 'スマホ/タブレットではサイドバーを非表示にする',
      'description' => '<small>投稿/固定ページでサイドバーが非表示になります。</small>',
      'section' => 'other_options',
      'type' => 'checkbox',
      ));   
    //リップルエフェクトをオフにする
    $wp_customize->add_setting('no_ripple', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'no_ripple', array(
      'settings' => 'no_ripple',
      'label' => 'リップルエフェクトをオフにする',
      'description' => '<small>ボタンを押したときに波紋のように広がる効果のことです。オフにすると少し軽くなります。なお、リップルエフェクトはONにしていてもデバイス（ブラウザ）によって効かないことがあります。</small>',
      'section' => 'other_options',
      'type' => 'checkbox',
      ));
     //アイキャッチ画像を使用しない
    $wp_customize->add_setting('no_eyecatch', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
    ));
      $wp_customize->add_control( 'no_eyecatch', array(
      'settings' => 'no_eyecatch',
      'label' => '記事のタイトル下にアイキャッチ画像を表示しない',
      'section' => 'other_options',
      'type' => 'checkbox',
      ));
     //フォントサイズ（スマホ）
     $wp_customize->add_setting('mb_font_size', array(
      'type' => 'option',
      'default' => '107',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'absint')
      ));
       $wp_customize->add_control( 'mb_font_size', array(
        'settings' => 'mb_font_size',
        'label' => 'スマホでのフォントサイズ',
        'description' => '<small>幅481px以下のブラウザでのフォントサイズを指定します。デフォルトは「107」です。レイアウト崩れを防ぐため、一部の文字サイズは変わりません（記事一覧のカード内などは固定）。</small>',
        'section' => 'other_options',
        'type' => 'number',
       ));
     //フォントサイズ（タブレット）
     $wp_customize->add_setting('tb_font_size', array(
      'type' => 'option',
      'default' => '107',
      array('sanitize_callback' => 'absint')
      ));
       $wp_customize->add_control( 'tb_font_size', array(
        'settings' => 'tb_font_size',
        'label' => 'タブレットでのフォントサイズ',
        'description' => '<small>幅482〜1029pxでのフォントサイズを指定します。デフォルト値は「107」です。</small>',
        'section' => 'other_options',
        'type' => 'number',
       ));
     //フォントサイズ（デスクトップ）
     $wp_customize->add_setting('pc_font_size', array(
      'type' => 'option',
      'default' => '107',
      array('sanitize_callback' => 'absint')
      ));
       $wp_customize->add_control( 'pc_font_size', array(
        'settings' => 'pc_font_size',
        'label' => 'PCでのフォントサイズ',
        'description' => '<small>幅1030px〜のフォントサイズを指定します。デフォルト値は「107」です。</small>',
        'section' => 'other_options',
        'type' => 'number',
       ));
     //記事一覧にNEWマークをつける日数
     $wp_customize->add_setting('new_mark_date', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'absint')
      ));
       $wp_customize->add_control( 'new_mark_date', array(
        'settings' => 'new_mark_date',
        'label' => '何日前の記事までNEWマークをつけるか',
        'description' => '<small>例えば「2」にすると、2日前以降に更新された記事に一覧ページでNEWがつきます。デフォルトは「3」。表示しない場合は0にします。</small>',
        'section' => 'other_options',
        'type' => 'number',
       ));
     //Google Analytics
     $wp_customize->add_setting('ga_code', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
       $wp_customize->add_control( 'ga_code', array(
        'settings' => 'ga_code',
        'label' => 'Google Analytics',
        'description' => '<small>トラッキングID（UA-********-*のようなコード）を貼り付けてください。プラグインで設定済の場合は空欄のままにしましょう。</small>',
        'section' => 'other_options',
        'type' => 'text',
       ));
    //ツイートされたときにアカウント名を含める
    $wp_customize->add_setting('include_tweet_via', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
      $wp_customize->add_control( 'include_tweet_via', array(
      'settings' => 'include_tweet_via',
      'label' => 'シェアボタンからのツイートに表示するアカウント名',
      'description' => '<small>@を含めずに入力。表示しない場合は空欄のままにしてください。</small>',
      'section' => 'other_options',
      'type' => 'text',
      ));
    //app id
    $wp_customize->add_setting('fb_app_id', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
      $wp_customize->add_control( 'fb_app_id', array(
      'settings' => 'fb_app_id',
      'label' => 'Facebookのapp id',
      'description' => '<small>「fb:app_id」を設定したい方は入力してください（半角数字のみ）。</small>',
      'section' => 'other_options',
      'type' => 'text',
      ));

     //絵文字を読み込まない
     $wp_customize->add_setting('disable_emoji_js', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
      ));
       $wp_customize->add_control( 'disable_emoji_js', array(
        'settings' => 'disable_emoji_js',
        'label' => '絵文字用のJSを読み込まない',
        'description' => '<small>WordPressの初期設定では絵文字を使用するためのJavascriptが読み込まれます。サイト内で絵文字を使わない場合にはチェックを入れましょう。</small>',
        'section' => 'other_options',
        'type' => 'checkbox',
       ));
     //自動整形を一括オフに
     $wp_customize->add_setting('never_wpautop', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
      ));
       $wp_customize->add_control( 'never_wpautop', array(
        'settings' => 'never_wpautop',
        'label' => '自動整形をオフに（ビジュアルエディタ含む）',
        'description' => '<small>記事出力時に自動でpタグが出力されたり、spanタグが消えたりしたときにはこちらにチェックを入れてみてください。WordPress初期設定の自動整形機能などをオフにします。</small>',
        'section' => 'other_options',
        'type' => 'checkbox',
       ));
    //日付を非表示に
     $wp_customize->add_setting('remove_pubdate', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'default' => '',
          'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        )
      ));
       $wp_customize->add_control( 'remove_pubdate', array(
        'settings' => 'remove_pubdate',
        'label' => '日付を非表示にする',
        'description' => '<small>記事一覧上/投稿ページ上の日付を非表示にします。特に理由がない限りチェックをつける必要はありません。</small>',
        'section' => 'other_options',
        'type' => 'checkbox',
       ));
/*********************
パブリッシャーを登録
*********************/
  $wp_customize->add_section( 'register_publisher', array(
    'title' =>'パブリッシャーを登録',
    'priority' => 160,
  ));
     //発行組織名
     $wp_customize->add_setting('publisher_name', array(
      'type' => 'option',
      'transport' => 'postMessage',
      array('sanitize_callback' => 'wp_filter_nohtml_kses')
      ));
     $wp_customize->add_control( 'publisher_name', array(
      'settings' => 'publisher_name',
      'label' => '発行組織名',
      'description' => '<small>パブリッシャー情報は構造化データで使用されます。個人の場合は、サイト名をそのまま発行組織名にしても良いでしょう。</small>',
      'section' => 'register_publisher',
      'type' => 'text',
     ));     
    //画像をアップロードする
    $wp_customize->add_setting('publisher_img', array(
      'type' => 'option',
      'transport' => 'postMessage',
        array(
          'sanitize_callback' => 'theme_slug_sanitize_file'
        )
      ));
    if(class_exists('WP_Customize_Image_Control')):
      $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'publisher_img', array(
        'settings' => 'publisher_img',
        'label' => '発行組織を表す画像（ロゴなど）',
        'description' => '<small>サイトのロゴ画像と同じものを使っても構いません。</small>',
        'section' => 'register_publisher',
      )));
    endif;
/*********************
色の設定項目を追加（head内への反映はこのファイルの最下部）
*********************/
  //メインカラー
  $wp_customize->add_setting( 'main_color', array(
   'default' => '#6bb6ff',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_color', array(
     'label' => 'メインカラー',
     'description' => '<small>テーマの大部分に使用される色です。背景が白でも目立つ色にしましょう。設定色の詳しい意味は<a href="https://saruwakakun.com/sango/custom-color" target="_blank">色変更の方法</a>で解説しています。</small>',
     'section' => 'colors',
     'settings' => 'main_color',
    )));
  //下地色
  $wp_customize->add_setting( 'pastel_color', array(
   'default' => '#c8e4ff',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pastel_color', array(
     'label' => '薄めの下地色',
     'description' => '<small>一部の背景に使われます。メインカラーと合う薄めの色を選びましょう。</small>',
     'section' => 'colors',
     'settings' => 'pastel_color',
    )));
  //アクセントカラー
  $wp_customize->add_setting( 'accent_color', array(
   'default' => '#ffb36b',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
     'label' => 'アクセントカラー',
     'description' => '<small>テーマのごく一部に使われます。メインカラーと並べたときに目立つ色を選びましょう。</small>',
     'section' => 'colors',
     'settings' => 'accent_color',
    )));
  //リンク色
  $wp_customize->add_setting( 'link_color', array(
   'default' => '#4f96f6',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
     'label' => 'リンク色',
     'description' => '<small>記事内などのリンクに使用される色です。</small>',
     'section' => 'colors',
     'settings' => 'link_color',
    )));
  //ヘッダー背景色
  $wp_customize->add_setting( 'header_bc', array(
   'default' => '#7fbae9',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bc', array(
     'label' => 'ヘッダー背景色',
     'description' => '<small>ヘッダーの塗りつぶし色です。ページ最下部のフッターにも使われます。</small>',
     'section' => 'colors',
     'settings' => 'header_bc',
    )));
  //ヘッダーロゴ
  $wp_customize->add_setting( 'header_c', array(
   'default' => '#FFF',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_c', array(
     'label' => 'ヘッダータイトル色',
     'section' => 'colors',
     'settings' => 'header_c',
    )));
  //ヘッダーロゴ
  $wp_customize->add_setting( 'header_menu_c', array(
   'default' => '#FFF',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_menu_c', array(
     'label' => 'ヘッダーメニュー色',
     'description' => '<small>パソコン表示での表示されるヘッダーメニューの文字色です。</small>',
     'section' => 'colors',
     'settings' => 'header_menu_c',
    )));
  //ウィジェットのタイトル色
  $wp_customize->add_setting( 'wid_title_c', array(
   'default' => '#6bb6ff',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wid_title_c', array(
     'label' => 'ウィジェットのタイトル色',
     'description' => '<small>サイドバーなどのウィジェットのタイトル色に使われます。</small>',
     'section' => 'colors',
     'settings' => 'wid_title_c',
    )));
  //ウィジェットのタイトル背景
  $wp_customize->add_setting( 'wid_title_bc', array(
   'default' => '#c8e4ff',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wid_title_bc', array(
     'label' => 'ウィジェットタイトルの背景色',
     'description' => '<small>サイドバーなどのウィジェットタイトルの背景色に使われます。</small>',
     'section' => 'colors',
     'settings' => 'wid_title_bc',
    )));
  //フッターの塗りつぶし色
  $wp_customize->add_setting( 'sng_footer_bc', array(
   'default' => '#e0e4eb',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sng_footer_bc', array(
     'label' => 'フッターウィジェットの背景色',
     'description' => '<small>フッターウィジェットを追加したときに使われる背景色です。</small>',
     'section' => 'colors',
     'settings' => 'sng_footer_bc',
    )));
  //フッターの文字色
  $wp_customize->add_setting( 'sng_footer_c', array(
   'default' => '#3c3c3c',
   'sanitize_callback' => 'sanitize_hex_color'
  ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sng_footer_c', array(
     'label' => 'フッターウィジェットの文字色',
     'section' => 'colors',
     'settings' => 'sng_footer_c',
    )));
}//END theme_customize_register function

/******************************
色の設定を反映させる
********************************/
//カスタマイザーに登録された色やフォントサイズを取得してhead内に出力
function sng_customizer_css() {
  $link = get_theme_mod( 'link_color', '#4f96f6');
  $main_c = get_theme_mod( 'main_color', '#6bb6ff');
  $pastel_c = get_theme_mod( 'pastel_color', '#c8e4ff');
  $accent_c = get_theme_mod( 'accent_color', '#ffb36b');
  $header_bc = get_theme_mod( 'header_bc', '#7fbae9');
  $header_c = get_theme_mod( 'header_c', '#FFF');
  $header_menu_c = get_theme_mod( 'header_menu_c', '#FFF');
  $wid_c = get_theme_mod( 'wid_title_c', '#6bb6ff');
  $wid_bc = get_theme_mod( 'wid_title_bc', '#c8e4ff');
  $footer_c = get_theme_mod( 'sng_footer_c', '#3c3c3c');
  $footer_bc = get_theme_mod( 'sng_footer_bc', '#e0e4eb');
  $body_bc = get_theme_mod( 'background_color', '#eaedf2');
  //トップへ戻るボタン
  $totop_bc = get_theme_mod( 'to_top_color', '#5ba9f7');
  //お知らせ欄
  $info_text = get_theme_mod( 'header_info_c', '#FFF');
  $info_bc1 = get_theme_mod( 'header_info_c1', '#738bff');
  $info_bc2 = get_theme_mod( 'header_info_c2', '#85e3ec');
  //モバイルフッター固定メニュー
  $footer_fixed_bc = get_theme_mod( 'footer_fixed_bc', '#FFF');
  $footer_fixed_c = get_theme_mod( 'footer_fixed_c', '#a2a7ab');
  $footer_fixed_actc = get_theme_mod( 'footer_fixed_actc', '#6bb6ff');
  //フォントサイズ
  $mb_size = get_option('mb_font_size') ? get_option('mb_font_size') : '107';
  $tb_size = get_option('tb_font_size') ? get_option('tb_font_size') : '107';
  $pc_size = get_option('pc_font_size') ? get_option('pc_font_size') : '107';
?>
<style>
a {color: <?php echo $link; ?>;}
.main-c {color: <?php echo $main_c; ?>;}
.main-bc {background-color: <?php echo $main_c; ?>;}
.main-bdr,#inner-content .main-bdr {border-color:  <?php echo $main_c; ?>;}
.pastel-bc , #inner-content .pastel-bc {background-color: <?php echo $pastel_c; ?>;}
.accent-c {color: <?php echo $accent_c; ?>;}
.accent-bc {background-color: <?php echo $accent_c; ?>;}
.header,#footer-menu,.drawer__title {background-color: <?php echo $header_bc; ?>;}
#logo a {color: <?php echo $header_c; ?>;}
.desktop-nav li a , .mobile-nav li a, #footer-menu a ,.copyright, #drawer__open,.drawer__title {color: <?php echo $header_menu_c; ?>;}
.drawer__title .close span, .drawer__title .close span:before {background: <?php echo $header_menu_c; ?>;}
.desktop-nav li:after {background: <?php echo $header_menu_c; ?>;}
.mobile-nav .current-menu-item {border-bottom-color: <?php echo $header_menu_c; ?>;}
.widgettitle {color: <?php echo $wid_c; ?>;background-color:<?php echo $wid_bc; ?>;}
.footer {background-color: <?php echo $footer_bc; ?>;}
.footer, .footer a, .footer .widget ul li a {color: <?php echo $footer_c; ?>;}
.body_bc {background-color: <?php echo $body_bc; ?>;}
/*Main Color*/
#toc_container .toc_title, #footer_menu .raised, .pagination a, .pagination span, #reply-title:before , .entry-content blockquote:before ,.main-c-before li:before ,.main-c-b:before{color: <?php echo $main_c; ?>;}
/*Main Color Background*/
#searchsubmit, #toc_container .toc_title:before, .cat-name, .pre_tag > span, .pagination .current, #submit ,.withtag_list > span,.main-bc-before li:before {background-color: <?php echo $main_c; ?>;}
/*Main Color Border*/
#toc_container, h3 ,.li-mainbdr ul,.li-mainbdr ol {border-color: <?php echo $main_c; ?>;}
/*Accent Color*/
.search-title .fa-search ,.acc-bc-before li:before {background: <?php echo $accent_c; ?>;}
/*Accent Color border*/
.li-accentbdr ul, .li-accentbdr ol {border-color: <?php echo $accent_c; ?>;}
/*Pastel Color Background*/
.pagination a:hover ,.li-pastelbc ul, .li-pastelbc ol {background: <?php echo $pastel_c; ?>;}
/*FontSize*/
body {font-size: <?php echo $mb_size; ?>%;}
@media only screen and (min-width: 481px) {
body {font-size: <?php echo $tb_size; ?>%;}
}
@media only screen and (min-width: 1030px) {
body {font-size: <?php echo $pc_size; ?>%;}
}
/*Others*/
.totop {background: <?php echo $totop_bc; ?>;}
.header-info a {color: <?php echo $info_text; ?>; background: linear-gradient(95deg,<?php echo $info_bc1; ?>,<?php echo $info_bc2; ?>);}
.fixed-menu ul {background: <?php echo $footer_fixed_bc; ?>;}
.fixed-menu a {color: <?php echo $footer_fixed_c; ?>;}
.fixed-menu .current-menu-item a , .fixed-menu ul li a.active {color: <?php echo $footer_fixed_actc; ?>;}
</style>
<?php
}
add_action( 'wp_head', 'sng_customizer_css',101);
?>