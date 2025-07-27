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
function custom_nav_args($args){
	

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
add_filter('wp_nav_menu_args', 'custom_nav_args');
