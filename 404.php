<?php
/**
 * Страница 404 ошибки (404.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
 get_header(); ?>

 <main class="page-main">
   <section class="slider-section" data-snap-ignore="true">
     <img data-src="<?php echo get_stylesheet_directory_uri(); ?>/images/404.jpg" alt='Ошибка 404' class="lazyload" />
   </section>
   <div class="page-main__content">
       <?php dynamic_sidebar('main'); ?>
   </div>
 </main>

 <?php get_footer(); ?>
