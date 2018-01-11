<?php
/*********************
*このファイルの内容
 - エディターのスタイル設定
 - ショートコード
*********************/

/*********************
ウィジェットでショートコードを有効に
*********************/
add_filter('widget_text', 'do_shortcode' );

/*********************
編集画面上部の「スタイル」メニュー
*********************/
function sng_editor_setting($init) {
	//ビジュアルエディターの選択肢からh1見出しを削除（h1は記事本文では使用しない）
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Preformatted=pre';
	$style_formats = array(
	    array(
	    'title' => '画像のスタイル',
	    'items' => array(
			array(
				'title' => '画像を小さく',
				'selector' => 'img',
				'classes' => 'img_so_small'
			),
			array(
				'title' => '画像を少し小さく',
				'selector' => 'img',
				'classes' => 'img_small'
			),
			array(
				'title' => '画像を線で囲む',
				'selector' => 'img',
				'classes' => 'img_border'
			),
			array(
				'title' => '画像に影をつける',
				'selector' => 'img',
				'classes' => 'shadow'
			),
			array(
				'title' => '画像に大きめの影',
				'selector' => 'img',
				'classes' => 'bigshadow'
			))
		),
		array(
	    'title' => '文字のスタイル',
	    'items' => array(
			array(
				'title' => '文字小さめ',
				'inline' => 'span',
				'classes' => 'small'
			),
			array(
				'title' => '文字大きめ',
				'inline' => 'span',
				'classes' => 'big'
			),
			array(
				'title' => '文字特大',
				'inline' => 'span',
				'classes' => 'sobig'
			),
			array(
				'title' => '文字（赤）',
				'inline' => 'span',
				'classes' => 'red'
			),
			array(
				'title' => '文字（青）',
				'inline' => 'span',
				'classes' => 'blue'
			),
			array(
				'title' => '文字（緑）',
				'inline' => 'span',
				'classes' => 'green',
			),
			array(
				'title' => '文字（オレンジ）',
				'inline' => 'span',
				'classes' => 'orange'
			),
			array(
				'title' => '文字（シルバー）',
				'inline' => 'span',
				'classes' => 'silver'
			),
			array(
				'title' => '蛍光ペン（青）',
				'inline' => 'span',
				'classes' => 'keiko_blue'
			),
			array(
				'title' => '蛍光ペン（黄）',
				'inline' => 'span',
				'classes' => 'keiko_yellow'
			),
			array(
				'title' => '蛍光ペン（緑）',
				'inline' => 'span',
				'classes' => 'keiko_green'
			),
			array(
				'title' => 'ラベル（メインカラー）',
				'inline' => 'span',
				'classes' => 'labeltext main-bc'
			),
			array(
				'title' => 'ラベル（アクセントカラー）',
				'inline' => 'span',
				'classes' => 'labeltext accent-bc'
			),
			array(
				'title' => '背景をうっすら灰色に',
				'inline' => 'span',
				'classes' => 'haiiro'
			))
		),
		array(
	    'title' => '見出し',
	    'items' => array(
			array(
				'title' => '見出し1：下線',
				'block' => 'p',
				'classes' => 'hh hh1'
			),
			array(
				'title' => '見出し2：点線下線',
				'block' => 'p',
				'classes' => 'hh hh2 main-c main-bdr'
			),
			array(
				'title' => '見出し3：二重線下線',
				'block' => 'p',
				'classes' => 'hh hh3 main-bdr'
			),
			array(
				'title' => '見出し4：上下線',
				'block' => 'p',
				'classes' => 'hh hh4 main-bdr main-c'
			),
			array(
				'title' => '見出し5：塗りつぶし',
				'block' => 'p',
				'classes' => 'hh hh5 pastel-bc'
			),
			array(
				'title' => '見出し6：囲い枠',
				'block' => 'p',
				'classes' => 'hh hh6 main-c main-bdr'
			),
			array(
				'title' => '見出し7：背景塗りと下線',
				'block' => 'p',
				'classes' => 'hh hh7 pastel-bc main-bdr'
			),
			array(
				'title' => '見出し8：オレンジ見出し',
				'block' => 'p',
				'classes' => 'hh hh8'
			),
			array(
				'title' => '見出し9：影付き塗りつぶし',
				'block' => 'p',
				'classes' => 'hh hh9 pastel-bc'
			),
			array(
				'title' => '見出し10：タグ風',
				'block' => 'p',
				'classes' => 'hh hh10 pastel-bc'
			),
			array(
				'title' => '見出し11：吹き出し風',
				'block' => 'p',
				'classes' => 'hh hh11'
			),
			array(
				'title' => '見出し12：ステッチ風',
				'block' => 'p',
				'classes' => 'hh hh12'
			),	
			array(
				'title' => '見出し13：ステッチ白',
				'block' => 'p',
				'classes' => 'hh hh13'
			),
			array(
				'title' => '見出し14：角がはがれかけ',
				'block' => 'p',
				'classes' => 'hh hh14'
			),
			array(
				'title' => '見出し15：片側折れ',
				'block' => 'p',
				'classes' => 'hh hh15'
			),
			array(
				'title' => '見出し16：片側折れ（別色）',
				'block' => 'p',
				'classes' => 'hh hh16'
			),	
			array(
				'title' => '見出し17：色が変わる下線',
				'block' => 'p',
				'classes' => 'hh hh17'
			),
			array(
				'title' => '見出し18：色が変わる下線2',
				'block' => 'p',
				'classes' => 'hh hh18'
			),
			array(
				'title' => '見出し19：下線やじるし',
				'block' => 'p',
				'classes' => 'hh hh19'
			),
			array(
				'title' => '見出し20：背景ストライプ',
				'block' => 'p',
				'classes' => 'hh hh20'
			),	
			array(
				'title' => '見出し21：背景ストライプ2',
				'block' => 'p',
				'classes' => 'hh hh21'
			),
			array(
				'title' => '見出し22：ストライプ＋上下線',
				'block' => 'p',
				'classes' => 'hh hh22'
			),
			array(
				'title' => '見出し23：ストライプの下線',
				'block' => 'p',
				'classes' => 'hh hh23'
			),
			array(
				'title' => '見出し24：両端線のばし',
				'block' => 'p',
				'classes' => 'hh hh24'
			),
			array(
				'title' => '見出し25：線を交差',
				'block' => 'p',
				'classes' => 'hh hh25'
			),
			array(
				'title' => '見出し26：大カッコで囲う',
				'block' => 'p',
				'classes' => 'hh hh26'
			),
			array(
				'title' => '見出し27：一文字目だけ特大',
				'block' => 'p',
				'classes' => 'hh hh27'
			),
			array(
				'title' => '見出し28：消えていく下線',
				'block' => 'p',
				'classes' => 'hh hh28'
			),
			array(
				'title' => '見出し29：背景グラデーション',
				'block' => 'p',
				'classes' => 'hh hh29'
			),
			array(
				'title' => '見出し30：チェックマーク',
				'block' => 'p',
				'classes' => 'hh hh30'
			),
			array(
				'title' => '見出し31：シェブロンマーク',
				'block' => 'p',
				'classes' => 'hh hh31'
			),
			array(
				'title' => '見出し32：フラット塗りつぶし',
				'block' => 'p',
				'classes' => 'hh hh32'
			),
			array(
				'title' => '見出し33：角丸ぬりつぶし',
				'block' => 'p',
				'classes' => 'hh hh33'
			),
			array(
				'title' => '見出し34：肉球',
				'block' => 'p',
				'classes' => 'hh hh34'
			),
				array(
				'title' => '見出し35：リボン（1行のみ）',
				'block' => 'p',
				'classes' => 'hh hh35'
			),
			array(
				'title' => '見出し36：片側リボン（1行のみ）',
				'block' => 'p',
				'classes' => 'hh hh36'
			))
		),
		array(
	    'title' => 'ボックス',
	    'items' => array(
			array(
				'title' => '1.黒の囲み線',
				'block' => 'div',
				'classes' => 'sng-box box1',
				'wrapper' => true
			),
			array(
				'title' => '2.グレイの囲み線',
				'block' => 'div',
				'classes' => 'sng-box box2',
				'wrapper' => true
			),
			array(
				'title' => '3.薄い水色の背景',
				'block' => 'div',
				'classes' => 'sng-box box3',
				'wrapper' => true
			),
			array(
				'title' => '4.薄い水色＋上下線',
				'block' => 'div',
				'classes' => 'sng-box box4',
				'wrapper' => true
			),
			array(
				'title' => '5.二重線囲み',
				'block' => 'div',
				'classes' => 'sng-box box5',
				'wrapper' => true
			),
			array(
				'title' => '6.青の点線囲み',
				'block' => 'div',
				'classes' => 'sng-box box6',
				'wrapper' => true
			),
			array(
				'title' => '7.背景グレイ＋両端二重線',
				'block' => 'div',
				'classes' => 'sng-box box7',
				'wrapper' => true
			),
			array(
				'title' => '8.橙色の背景+左線',
				'block' => 'div',
				'classes' => 'sng-box box8',
				'wrapper' => true
			),
			array(
				'title' => '9.赤の背景+上線',
				'block' => 'div',
				'classes' => 'sng-box box9',
				'wrapper' => true
			),
			array(
				'title' => '10.ミントカラー+上線',
				'block' => 'div',
				'classes' => 'sng-box box10',
				'wrapper' => true
			),
			array(
				'title' => '11.影＋ネイビー上線',
				'block' => 'div',
				'classes' => 'sng-box box11',
				'wrapper' => true
			),
			array(
				'title' => '12.水色立体',
				'block' => 'div',
				'classes' => 'sng-box box12',
				'wrapper' => true
			),
			array(
				'title' => '13.青の立体',
				'block' => 'div',
				'classes' => 'sng-box box13',
				'wrapper' => true
			),
			array(
				'title' => '14.水色ステッチ',
				'block' => 'div',
				'classes' => 'sng-box box14',
				'wrapper' => true
			),
			array(
				'title' => '15.ピンクステッチ',
				'block' => 'div',
				'classes' => 'sng-box box15',
				'wrapper' => true
			),
			array(
				'title' => '16.水色ストライプ',
				'block' => 'div',
				'classes' => 'sng-box box16',
				'wrapper' => true
			),
			array(
				'title' => '17.シャープ型',
				'block' => 'div',
				'classes' => 'sng-box box17',
				'wrapper' => true
			),
			array(
				'title' => '18.左上と右下くるん',
				'block' => 'div',
				'classes' => 'sng-box box18',
				'wrapper' => true
			),
			array(
				'title' => '19.カギカッコ',
				'block' => 'div',
				'classes' => 'sng-box box19',
				'wrapper' => true
			),
			array(
				'title' => '20.両端ドット点線囲み',
				'block' => 'div',
				'classes' => 'sng-box box20',
				'wrapper' => true
			),
			array(
				'title' => '21.グラデーション',
				'block' => 'div',
				'classes' => 'sng-box box21',
				'wrapper' => true
			),
			array(
				'title' => '22.影付き+左に青線',
				'block' => 'div',
				'classes' => 'sng-box box22',
				'wrapper' => true
			),
			array(
				'title' => '23.丸い吹き出し',
				'block' => 'div',
				'classes' => 'sng-box box23',
				'wrapper' => true
			),
			array(
				'title' => '24.吹き出し水色',
				'block' => 'div',
				'classes' => 'sng-box box24',
				'wrapper' => true
			),
			array(
				'title' => '25.右上に折り目',
				'block' => 'div',
				'classes' => 'sng-box box25',
				'wrapper' => true
			))
		),
		array(
	    'title' => 'ボタン',
	    'items' => array(
			array(
				'title' => '浮き出し（メインカラー）',
				'selector' => 'a',
				'classes' => 'btn raised main-bc strong',
			),
			array(
				'title' => '浮き出し（アクセントカラー）',
				'selector' => 'a',
				'classes' => 'btn raised accent-bc strong',
			),
			array(
				'title' => '浮き出し（赤）',
				'selector' => 'a',
				'classes' => 'btn raised red-bc strong',
			),
			array(
				'title' => '浮き出し（青）',
				'selector' => 'a',
				'classes' => 'btn raised blue-bc strong',
			),
			array(
				'title' => '浮き出し（緑）',
				'selector' => 'a',
				'classes' => 'btn raised green-bc strong',
			),
			array(
				'title' => 'フラット塗りつぶし',
				'selector' => 'a',
				'classes' => 'btn flat1',
			),
			array(
				'title' => '水色の枠',
				'selector' => 'a',
				'classes' => 'btn flat2',
			),
			array(
				'title' => '水色の枠（二重線）',
				'selector' => 'a',
				'classes' => 'btn flat3',
			),
			array(
				'title' => '水色の枠（破線）',
				'selector' => 'a',
				'classes' => 'btn flat4',
			),
			array(
				'title' => '両端線ボタン（青&紺）',
				'selector' => 'a',
				'classes' => 'btn flat6',
			),
			array(
				'title' => '水色下線',
				'selector' => 'a',
				'classes' => 'btn flat7',
			),
			array(
				'title' => '右側まるみ',
				'selector' => 'a',
				'classes' => 'btn flat8',
			),
			array(
				'title' => '青緑の塗りつぶし',
				'selector' => 'a',
				'classes' => 'btn flat9',
			),
			array(
				'title' => '上まるみオレンジ',
				'selector' => 'a',
				'classes' => 'btn flat10',
			),
			array(
				'title' => 'ストライプ両端線',
				'selector' => 'a',
				'classes' => 'btn flat11',
			),
			array(
				'title' => 'グラデーション青',
				'selector' => 'a',
				'classes' => 'btn grad1',
			),
			array(
				'title' => 'グラデーション赤・橙',
				'selector' => 'a',
				'classes' => 'btn grad2',
			),
			array(
				'title' => 'グラデーション橙 丸',
				'selector' => 'a',
				'classes' => 'btn grad3',
			),
			array(
				'title' => 'グラデーション青 丸みなし',
				'selector' => 'a',
				'classes' => 'btn grad4',
			),
			array(
				'title' => '立体（メインカラー）',
				'selector' => 'a',
				'classes' => 'btn cubic1 main-bc',
			),
			array(
				'title' => '立体（アクセントカラー）',
				'selector' => 'a',
				'classes' => 'btn cubic1 accent-bc',
			),
			array(
				'title' => '立体（赤）',
				'selector' => 'a',
				'classes' => 'btn cubic1 red-bc',
			),
			array(
				'title' => '立体（青）',
				'selector' => 'a',
				'classes' => 'btn cubic1 blue-bc',
			),
			array(
				'title' => '立体（緑）',
				'selector' => 'a',
				'classes' => 'btn cubic1 green-bc',
			),
			array(
				'title' => '立体+影（メインカラー）',
				'selector' => 'a',
				'classes' => 'btn cubic1 main-bc shadow',
			),
			array(
				'title' => '立体+影（アクセントカラー）',
				'selector' => 'a',
				'classes' => 'btn cubic1 accent-bc shadow',
			),
			array(
				'title' => '立体+影（赤）',
				'selector' => 'a',
				'classes' => 'btn cubic1 red-bc shadow',
			),
			array(
				'title' => '立体+影（青）',
				'selector' => 'a',
				'classes' => 'btn cubic1 blue-bc shadow',
			),
			array(
				'title' => '立体+影（緑）',
				'selector' => 'a',
				'classes' => 'btn cubic1 green-bc shadow',
			),
			array(
				'title' => 'カクカク（メインカラー）',
				'selector' => 'a',
				'classes' => 'btn cubic2 main-bc',
			),
			array(
				'title' => 'カクカク（アクセントカラー）',
				'selector' => 'a',
				'classes' => 'btn cubic2 accent-bc',
			),
			array(
				'title' => 'カクカク（赤）',
				'selector' => 'a',
				'classes' => 'btn cubic2 red-bc',
			),
			array(
				'title' => 'カクカク（青）',
				'selector' => 'a',
				'classes' => 'btn cubic2 blue-bc',
			),
			array(
				'title' => 'カクカク（緑）',
				'selector' => 'a',
				'classes' => 'btn cubic2 green-bc',
			),
			array(
				'title' => 'ポップ（メインカラー）',
				'selector' => 'a',
				'classes' => 'btn cubic3 main-bc',
			),
			array(
				'title' => 'ポップ（アクセントカラー）',
				'selector' => 'a',
				'classes' => 'btn cubic3 accent-bc',
			),
			array(
				'title' => 'ポップ（赤）',
				'selector' => 'a',
				'classes' => 'btn cubic3 red-bc',
			),
			array(
				'title' => 'ポップ（青）',
				'selector' => 'a',
				'classes' => 'btn cubic3 blue-bc',
			),
			array(
				'title' => 'ポップ（緑）',
				'selector' => 'a',
				'classes' => 'btn cubic3 green-bc',
			))
		),
			array(
				'title' => '表をレスポンシブに変える',
				'selector' => 'table',
				'classes' => 'tb-responsive'
			),
			array(
				'title' => '“シンプルな引用ボックス',
				'block' => 'blockquote',
				'classes' => 'quote_silver',
				'wrapper' => true
			)			
	);

	$init['style_formats'] = json_encode( $style_formats );
	
	return $init;
	}
add_filter('tiny_mce_before_init', 'sng_editor_setting');

function add_sng_style( $buttons){
	array_splice($buttons,1,0,'styleselect');
	return $buttons;
}
add_filter('mce_buttons','add_sng_style');


/******************************************
* 以下ショートコード *
******************************************/
add_shortcode('rate','sng_rate_box');//評価ボックス
add_shortcode('value','sng_rate_inner');//評価ボックスの中身
add_shortcode('kanren','sng_entry_link');//横長の関連記事を出力
add_shortcode('card','sng_card_link');//カードタイプの関連記事を出力
add_shortcode('catpost','output_cards_by');//特定のカテゴリーの記事を好きな数だけ出力
add_shortcode('tagpost','output_cards_bytag');//特定のタグの記事を好きな数だけ出力
add_shortcode('sanko','sng_othersite_link');//他サイトへのリンクを出力
add_shortcode('sen','sen');//線を引く
add_shortcode('tensen','tensen');//点線を引く
add_shortcode('memo','memo_box');//補足説明
add_shortcode('alert','alert_box');//注意書き
add_shortcode('codebox','code_withtag');//コード用のBOX
add_shortcode('say','say_what');//会話形式の吹き出し
add_shortcode('cell','table_cell');//横並び表示の中身
add_shortcode('yoko2','table_two');//2列表示
add_shortcode('yoko3','table_three');//3列表示
add_shortcode('mobile','only_mobile');//モバイルでのみ表示
add_shortcode('pc','only_pc');//PCでのみ表示
add_shortcode('category','only_cat');//特定のカテゴリーでのみ表示
add_shortcode('center','text_align_center');//中身を中央寄せ
add_shortcode('box','sng_insert_box');//ボックスを挿入
add_shortcode('btn','sng_insert_btn');//ボタンを挿入
add_shortcode('list','sng_insert_list');//ul,ol,liを装飾
add_shortcode('youtube','responsive_youtube');//YouTubeをレスポンシブで挿入
add_shortcode('texton','text_on_image');//画像の上に文字をのせる
/*********************
評価ボックス
*********************/
//ボックス全体
function sng_rate_box($atts, $content = null) {
	$title = isset($atts['title']) ? '<div class="rate-title dfont main-c-b">'.esc_attr($atts['title']).'</div>' : '';
	$content = do_shortcode( shortcode_unautop( $content ) );
	if($content) {
		return $title.'<div class="rate-box">'.$content.'</div>';
	}
}
//行
function sng_rate_inner($atts, $content = null) {
	if(isset($atts[0])){
		$value = ($atts[0]);
		$s = '<i class="fa fa-star"></i>';
		$h = '<i class="fa fa-star-half-o"></i>';
		$n = '<i class="fa fa-star-o"></i>';

		if($value == '5' || $value == '5.0'){ $star = $s.$s.$s.$s.$s.' (5.0)'; }
		elseif ($value == '4.5') { $star = $s.$s.$s.$s.$h.' (4.5)'; }
		elseif ($value == '4' || $value == '4.0') { $star = $s.$s.$s.$s.$n.' (4.0)'; }
		elseif ($value == '3.5') { $star = $s.$s.$s.$h.$n.' (3.5)'; }
		elseif ($value == '3' || $value == '3.0') { $star = $s.$s.$s.$n.$n.' (3.0)'; }
		elseif ($value == '2.5') { $star = $s.$s.$h.$n.$n.' (2.5)'; }
		elseif ($value == '2' || $value == '2.0') { $star = $s.$s.$n.$n.$n.' (2.0)'; }
		elseif ($value == '1.5') { $star = $s.$h.$n.$n.$n.' (1.5)'; }
		else {$star = $s.$n.$n.$n.$n.' (1.0)';}
		$endl = (isset($atts[1])) ? ' end-rate' : ''; 
		if($content) {
			return '<div class="rateline'.$endl.'"><div class="rate-thing">'.$content.'</div><div class="rate-star dfont">'.$star.'</div></div>';
		}
	}
}

/*********************
関連記事
*********************/
function sng_entry_link($atts) {
	$output = '';
	$id = isset($atts['id']) ? esc_attr($atts['id']) : null;
	if($id){
		$ids = (explode(',',$id));//一旦配列に
	}
	$target = isset($atts['target']) ? ' target="_blank"' : "";

	if(isset($ids)) {
	foreach ($ids as $eachid) {
		$img = (get_the_post_thumbnail($eachid)) ? get_the_post_thumbnail($eachid, 'thumb-160') : '<img src="'.featured_image_src('thumb-160').'">';
		$url = esc_url(get_permalink($eachid)); //URL
		$title = esc_attr(get_the_title($eachid));
		if($url && $title) {
			$output .= <<<EOF
			<a class="linkto table" href="{$url}"{$target}>
	            <figure class="tbcell">{$img}</figure>
	            <div class="tbcell">{$title}</div>
          	</a>
EOF;
			}
      } //endforeach
  }	else {$output = '関連記事のIDを正しく入力してください';}
      return $output;
} //END get_entry_link


/*********************
カードタイプの関連記事
*********************/
function sng_card_link($atts) {
	$id = isset($atts['id']) ? esc_attr($atts['id']) : null;
	$output = '';
	if($id){
		$ids = (explode(',',$id));//一旦配列に
	}
	$target = isset($atts['target']) ? ' target="_blank"' : "";
	if(isset($ids)) {
	foreach ($ids as $eachid) {
			$img = (get_the_post_thumbnail($eachid)) ? get_the_post_thumbnail($eachid, 'thumb-520') : '<img src="'.featured_image_src('thumb-520').'">';
			$url = esc_url(get_permalink($eachid)); //URL
			$title = esc_attr(get_the_title($eachid));
			if($url && $title) {
			$output .= <<<EOF
	          <a class="c_linkto" href="{$url}"{$target}>
	            <figure>{$img}</figure>
	            <div>{$title}</div>
	          </a>
EOF;
			 }//endif
      } //endforeach
      }	else {$output = '関連記事のIDを正しく入力してください';}
      return $output;
} //END get_entry_link

/*********************
特定のカテゴリーの記事を好きな数だけ出力
*********************/
function output_cards_by($atts){
	$num = isset($atts['num']) ? esc_attr($atts['num']) : '4';//出力数。入力なしなら4
	$catid = isset($atts['catid']) ? explode(',',$atts['catid']) : null; //どのカテゴリーの記事を出力するか（複数指定を配列に）
	$notin = isset($atts['notin']) ? explode(',',$atts['notin']) : null; //除外するカテゴリー
	if(isset($atts['orderby'])) {
		$orderby = ($atts['orderby']=='rand') ? 'rand' : 'date';//日付順かランダムか
	} else {
		$orderby = 'date';
	}
	if(isset($atts['type'])) {
		$type = ($atts['type']=='card') ? 'card' : 'kanren';//出力するカードタイプ
	} else {
		$type = 'kanren';
	}

	if($catid) {
    	$output_posts = get_posts(array(
	      'category__in' => $catid,
	      'numberposts' => $num,
	      'orderby'=> $orderby
	      ));
	} else {
		$output_posts = get_posts(array(
		  'category__not_in' => $notin,
	      'numberposts' => $num,
	      'orderby'=> $orderby
	      ));		
	}
    	$output = "";
	    if($output_posts && $type=="card"){

	    	foreach($output_posts as $post){
	    		$output .= sng_card_link(array('id'=>$post->ID));
	    	}

	    } elseif($output_posts && $type=="kanren"){

	    	foreach($output_posts as $post){
	    		$output .= sng_entry_link(array('id'=>$post->ID));
	    	}

	    }//endif output_posts
	    return $output;
    
}

/*********************
特定のタグの記事を好きな数だけ出力
*********************/
function output_cards_bytag($atts){
	$num = isset($atts['num']) ? esc_attr($atts['num']) : '4';//出力数。入力なしなら4
	$tagid = isset($atts['id']) ? explode(',',$atts['id']) : null; //どのタグの記事を出力するか（複数指定を配列に）
	if(isset($atts['orderby'])) {
		$orderby = ($atts['orderby']=='rand') ? 'rand' : 'date';//日付順かランダムか
	} else {
		$orderby = 'date';
	}
	if(isset($atts['type'])) {
		$type = ($atts['type']=='card') ? 'card' : 'kanren';//出力するカードタイプ
	} else {
		$type = 'kanren';
	}

	if($tagid) {
    $output_posts = get_posts(array(
      'tag__in' => $tagid,
      'numberposts' => $num,
      'orderby'=> $orderby
      ));
    	$output = "";
	    if($output_posts && $type=="card"){

	    	foreach($output_posts as $post){
	    		$output .= sng_card_link(array('id'=>$post->ID));
	    	}

	    } elseif($output_posts && $type=="kanren"){

	    	foreach($output_posts as $post){
	    		$output .= sng_entry_link(array('id'=>$post->ID));
	    	}

	    }//endif output_posts
	    return $output;
    }//endif num && tagid
}

/*********************
他サイトへのリンクカード
*********************/
function sng_othersite_link($atts) {
	$href = isset($atts['href']) ? esc_url($atts['href']) : null;
	$title = isset($atts['title']) ? esc_attr($atts['title']) : null;
	$site = isset($atts['site']) ? '<span>'.esc_attr($atts['site']).'</span>' : "";
	$target = isset($atts['target']) ? 'target="_blank"' : "";
	$rel = isset($atts['rel']) ? ' rel="nofollow"' : "";
	if($href && $title) {//タイトルとURLがある場合のみ出力
		$output = <<<EOF
		<a class="reference table" href="{$href}" {$target}{$rel}>
			<div class="tbcell">参考</div>
			<p class="tbcell">{$title}{$site}</p>
		</a>
EOF;
	return $output;
	} else {
		return '<span class="red">参考記事のタイトルとURLを入力してください</span>';}
} //END sng_othersite_link


/*********************
線・点線を出力
*********************/
function sen($atts) { return '<hr>';}
function tensen($atts) { return '<hr class="dotted">';}

/*********************
補足説明（メモ）
*********************/

function memo_box($atts, $content = null) {
	$title =  isset($atts) ? '<div class="memo_ttl dfont"> '.esc_attr($atts['title']).'</div>' : '';
	if($content){
		$content = do_shortcode( shortcode_unautop( $content ) );
		$output = <<<EOF
		<div class="memo">{$title}{$content}</div>
EOF;
	return $output;
	}
}

/*********************
注意書き
*********************/

function alert_box($atts, $content = null) {
	$title =  isset($atts) ? '<div class="memo_ttl dfont"> '.esc_attr($atts['title']).'</div>' : '';
	if($content){
		$content = do_shortcode( shortcode_unautop( $content ) );
		$output = <<<EOF
		<div class="memo alert">{$title}{$content}</div>
EOF;
	return $output;
	}
}

/*********************
タグ付きのソースコード枠
*********************/
function code_withtag($atts, $content = null) {
	$title =  isset($atts['title']) ? '<span><i class="fa fa-code"></i> '.esc_attr($atts['title']).'</span>' : '';
	if($content){
		$output = <<<EOF
		<div class="pre_tag">{$title}{$content}</div>
EOF;
	return $output;
	}
}


/*********************
会話ふきだし
*********************/
function say_what($atts, $content = null) {
	if($atts) {
		$img = (isset($atts['img'])) ? esc_url($atts['img']) : null;
		$name = (isset($atts['name'])) ? esc_attr($atts['name']) : '';
		if(isset($atts['from'])){
			$from = ($atts['from']=="right") ? "right" : "left";//入力が無ければleftに
		} else {
			$from = "left";
		}
		if($img && $from =="right"){//右に吹き出し
			$output = <<<EOF
				<div class="say {$from}">
					<div class="chatting"><div class="sc">{$content}</div></div>
					<p class="faceicon"><img src="{$img}"><span>{$name}</span></p>	
				</div>
EOF;
		} else {//左に吹き出し
			$output = <<<EOF
				<div class="say {$from}">
					<p class="faceicon"><img src="{$img}"><span>{$name}</span></p>
					<div class="chatting"><div class="sc">{$content}</div></div>
				</div>
EOF;

		}//endif

	return $output;

	}// endif $atts
}

/*********************
テーブルのセル(後述の関数で利用)
*********************/
function table_cell($atts, $content = null) {
	$content = do_shortcode( shortcode_unautop( $content ) );
	if($content) {
		return '<div class="cell">'.$content.'</div>';
	}
}

/*********************
2列横並び
*********************/
function table_two($atts , $content = null) {
	$layout = ($atts && $atts[0] == "responsive") ? "tbrsp" : "";
	$content = do_shortcode( shortcode_unautop( $content ) );
	if($content) {
		return '<div class="shtb2 '.$layout.'">'.$content.'</div>';
	}
}

/*********************
3列横並び
*********************/
function table_three($atts , $content = null) {
	$layout = ($atts && $atts[0] == "responsive") ? "tbrsp" : "";
	$content = do_shortcode( shortcode_unautop( $content ) );
	if($content) {
		return '<div class="shtb3 '.$layout.'">'.$content.'</div>';
	}
}

/*********************
モバイルでのみ表示
*********************/
function only_mobile($atts , $content = null) {
	if($content && wp_is_mobile()) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		return $content;
	}
}

/*********************
PCでのみ表示
*********************/
function only_pc($atts , $content = null) {
	if($content && !wp_is_mobile()) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		return $content;
	}
}
/*********************
特定のカテゴリーでのみ表示
*********************/
function only_cat($atts , $content = null) {
	$cat_id = (isset($atts['id'])) ? $atts['id'] : null;
	$cat_id = explode(',',$cat_id);
	if($content && in_category($cat_id)) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		return $content;
	}
}

/*********************
中身を中央寄せにするコード
*********************/
function text_align_center($atts , $content = null) {
if($content) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		return '<div class="center">'.$content.'</div>';
	}
}

/*********************
ボックスデザインのショートコード
*********************/
function sng_insert_box($atts , $content = null) {
	if(isset($atts) && $content) {
		$class = (isset($atts['class'])) ? esc_attr($atts['class']) : null;
		$title = (isset($atts['title'])) ? esc_attr($atts['title']) : null;
		$content = do_shortcode( shortcode_unautop( $content ) );
		$output = '';
		if(!$title && $class) {//タイトルが無いとき
			$output = <<<EOF
			<div class="sng-box {$class}">{$content}</div>
EOF;
		} elseif($title && $class) {//タイトルがあるとき
			$output = <<<EOF
			<div class="sng-box {$class}"><div class="box-title">{$title}</div>{$content}</div>
EOF;
		}
		return $output;			
	}//end if atts && content
}

/*********************
ボタンデザインのショートコード
*********************/
function sng_insert_btn($atts , $content = null) {
	if(isset($atts) && $content) {
		$href = (isset($atts['href'])) ? 'href="'.esc_url($atts['href']).'"' : null;
		$class = (isset($atts['class'])) ? esc_attr($atts['class']) : null;

		$target = '';
		if(isset($atts['target'])) {
			$target = ($atts['target'] == "_blank") ? ' target="_blank"' : "";
		}

		$rel = '';
		if(isset($atts['rel'])) {
			$rel = ($atts['rel'] == "nofollow") ? ' rel="nofollow"' : "";
		}

		$yoko = '';
		if(isset($atts['0'])) {
			$yoko = ($atts['0'] == "yoko") ? "yoko" : null;//横並びさせるか
		}
		
		if($class) {
			$output = (!$yoko) ? '<p>' : '';//横並びならpなし
			$output .= <<<EOF
			<a {$href} class="btn {$class}"{$target}{$rel}>{$content}</a>
EOF;
			if(!$yoko) {$output .= '</p>';}//横並びならpなし
				return $output;
		}//end if class
	}//end if atts && content
}

/*********************
ul ol liのショートコード
*********************/
function sng_insert_list($atts , $content = null) {
if($content) {
	//ul内にpタグが入ってしまう場合に以下のコメントアウトを解除
	//$search = array('<p>','</p>');
	//$content = str_replace($search,'',$content);
	$class = (isset($atts['class'])) ? esc_attr($atts['class']) : null;
	$title = (isset($atts['title'])) ? '<div class="list-title">'.esc_attr($atts['title']).'</div>' : null;
	return '<div class="'.$class.'">'.$title.$content.'</div>';
	}//endif content
}
/*********************
YouTubeをレスポンシブに
*********************/
function responsive_youtube($atts , $content = null){
	if($content) return '<div class="youtube">'.$content.'</div>';
}

/*********************
画像の上に文字をのせる
*********************/
function text_on_image($atts , $content = null) {
	$src = (isset($atts['img'])) ? esc_url($atts['img']) : null;
	$title = (isset($atts['title'])) ? esc_attr($atts['title']) : "";
	if($src){
$output = <<<EOF
			<div class="textimg"><p class="dfont">{$title}</p><img src="{$src}"></div>
EOF;
			return $output;		
	}
}
?>