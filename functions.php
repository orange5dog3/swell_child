<?php

/* 子テーマのfunctions.phpは、親テーマのfunctions.phpより先に読み込まれることに注意してください。 */


/**
 * 親テーマのfunctions.phpのあとで読み込みたいコードはこの中に。
 */
// add_filter('after_setup_theme', function(){
// }, 11);


/**
 * 子テーマでのファイルの読み込み
 */
add_action('wp_enqueue_scripts', function() {
	
	$timestamp = date( 'Ymdgis', filemtime( get_stylesheet_directory() . '/style.css' ) );
	wp_enqueue_style( 'child_style', get_stylesheet_directory_uri() .'/style.css', [], $timestamp );

	/* その他の読み込みファイルはこの下に記述 */

}, 11);


// headerをページ毎に変更--------------------------------
function custom_nav_args_header($args){
	// ヘッダーメニューのみを対象にする
	if ( isset($args['theme_location']) && $args['theme_location'] === 'header_menu' ) {
		
		// トップページだけ専用メニューにする
		if ( is_page( array('14') ) ){
			$args['menu'] = 'header nav top';
			$args['container'] = '';
			$args['items_wrap'] = '%3$s';
			$args['link_before'] = ''; $args['link_after'] = '';
			return $args;
		} else {
			$args['menu'] = 'header nav else';
			$args['container'] = '';
			$args['items_wrap'] = '%3$s';
			$args['link_before'] = ''; $args['link_after'] = '';
			return $args;
		}
	}
	
	return $args;
}
add_filter('wp_nav_menu_args', 'custom_nav_args_header');

// footerをページ毎に変更--------------------------------
function custom_nav_args_footer($args){
	if ( isset($args['theme_location']) && $args['theme_location'] === 'footer_menu' ) {
		if ( is_page('14') ){
			$args['menu'] = 'footer nav top';
		} else {
			$args['menu'] = 'footer nav else';
		}
	}
	return $args;
}
add_filter('wp_nav_menu_args', 'custom_nav_args_footer');





// ボタンエフェクト-------------------------------
function enqueue_child_theme_btn_styles() {
    wp_enqueue_style(
        'custom-btn-effect',
        get_stylesheet_directory_uri() . '/assets/css/btn_effect.css',
        array(),
        null,
        'all'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_child_theme_btn_styles');

// アニメーション遅延-------------------------------
function enqueue_child_theme_animation_styles() {
    wp_enqueue_style(
        'custom-animation-delay',
        get_stylesheet_directory_uri() . '/assets/css/animation_delay.css',
        array(),
        null,
        'all'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_child_theme_animation_styles');

// ハンバーガーメニュー-------------------------------
function enqueue_child_theme_hamburger_styles() {
    wp_enqueue_style(
        'custom-hamburger',
        get_stylesheet_directory_uri() . '/assets/css/hamburger.css',
        array(),
        null,
        'all'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_child_theme_hamburger_styles');

// お問い合わせフォーム-------------------------------
function enqueue_contact_form_styles() {
    wp_enqueue_style(
        'custom-contact-form-style',
        get_stylesheet_directory_uri() . '/assets/css/contact_form.css',
        array(),
        filemtime(get_stylesheet_directory() . '/assets/css/contact_form.css'),
        'all'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_contact_form_styles');

function shortcode_custom_contact_form() {
    // テンプレートファイルを直接読み込み
    $template_path = get_stylesheet_directory() . '/template-parts/contact_form.php';
    
    if (!file_exists($template_path)) {
        return '<p>Contact form template not found at: ' . $template_path . '</p>';
    }
    
    ob_start();
    include $template_path;
    return ob_get_clean();
}
add_shortcode('contact-form', 'shortcode_custom_contact_form');