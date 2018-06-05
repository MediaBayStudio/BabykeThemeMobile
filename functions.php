<?php
 /*
  * Функции шаблона (function.php)
  * @package WordPress
  * @subpackage MediaTheme
 */

 add_theme_support('title-tag'); // теперь тайтл управляется самим вп
 add_theme_support('post-thumbnails');
 load_template( locate_template('widgets.php'), $require_once );
 load_template( locate_template('sidebars.php'), $require_once );

 /* Меню */
 function theme_register_nav_menu() {
 	register_nav_menu( 'mobile', 'Мобильное меню' );
 	register_nav_menu( 'contacts', 'Меню ссылок на соцсети' );
 }
 add_action( 'after_setup_theme', 'theme_register_nav_menu' );

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

 class Babyke_Nav_Menu extends Walker {

 	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

 	public $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

 	public function start_lvl( &$output, $depth = 0, $args = array() ) {
 		$indent = str_repeat("\t", $depth);
 		$output .= "\n$indent<ul class=\"submenu\">\n";
 	}

 	public function end_lvl( &$output, $depth = 0, $args = array() ) {
 		$indent = str_repeat("\t", $depth);
 		$output .= "$indent</ul>\n";
 	}

 	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
 		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

 		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
 		$classes[] = 'menu-item-' . $item->ID;

 		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

 		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
 		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

 		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
 		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

 		$output .= $indent . '<li'. $class_names .'>';

 		$atts = array();
 		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
 		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
 		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
 		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

 		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

 		$attributes = '';
 		foreach ( $atts as $attr => $value ) {
 			if ( ! empty( $value ) ) {
 				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
 				$attributes .= ' ' . $attr . '="' . $value . '"';
 			}
 		}

 		$title = apply_filters( 'the_title', $item->title, $item->ID );

 		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

 		$item_output = $args->before;
 		$item_output .= '<a'. $attributes .'>';
 		$item_output .= $args->link_before . $title . $args->link_after;
 		$item_output .= '</a>';
 		$item_output .= $args->after;

 		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
 	}

 	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
 		$output .= "</li>\n";
 	}
 }

 add_filter('single_template', 'dh_comments_template');
 function dh_comments_template($template) {
     global $wp_query;
     if ( $_GET['comments'] == 'on' and
         file_exists(TEMPLATEPATH . '/single-comments.php') )
             $template = TEMPLATEPATH . '/single-comments.php';
     return $template;
 }
?>
