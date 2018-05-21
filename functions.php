<?php
 /*
  * Функции шаблона (function.php)
  * @package WordPress
  * @subpackage MediaTheme
 */

 add_theme_support('title-tag'); // теперь тайтл управляется самим вп

 add_action('wp_print_styles', 'add_styles'); // приклеем ф-ю на добавление стилей в хедер
 if (!function_exists('add_styles')) { // если ф-я уже есть в дочерней теме - нам не надо её определять

 	function add_styles() { // добавление стилей
 	    if(is_admin()) return false; // если мы в админке - ничего не делаем
 	    wp_enqueue_style( 'font_awesome', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css' );
 			$font_args = array(
 				'family' => 'Roboto:700,500italic,500,400,400italic,300,300italic|Roboto+Condensed:400,300,300italic,400italic,700,700italic',
 				'subset' => 'latin,cyrillic'
 			);
 			wp_enqueue_style( 'google_fonts', add_query_arg( $font_args, "//fonts.googleapis.com/css" ), array(), null );
 				wp_enqueue_style( 'main', get_template_directory_uri().'/style.css' ); // основные стили шаблона
 	}
 }

 add_action('wp_footer', 'add_scripts');
 if (!function_exists('add_scripts')) {
 	function add_scripts() {
 	    if(is_admin()) return false;
 	    wp_deregister_script('jquery');
 	    wp_enqueue_script('jquery','//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js','','',true);
 	    wp_enqueue_script('main', get_template_directory_uri().'/js/main.js','','',true);
 	}
 }


?>
