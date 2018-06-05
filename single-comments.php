<?php
/**
 * Шаблон страницы с комментариями для мобильной версии
 * @package WordPress
 * @subpackage mediaThemeMobile
 */


 get_header();

 if (have_posts()) :  while (have_posts()) : the_post();
 ?>
 <main class="page-main">
   <div class="comments__section-title">
     <div>
       <?php if (get_comments_number() ) printf( _n( 'Один комментарий', 'Комментарии (всего %1$s)', get_comments_number() ),
                       number_format_i18n( get_comments_number() ) );  else echo "Написать комментарий";?></p>
     </div>
     <i class="far fa-newspaper"></i>
   </div>
   <div class="comments__title-wrapper">
     <h1 class="comments__title">
       <?php the_title(); ?>
     </h1>
     <em class="comments__title--second">
       <?php if ( get_post_meta($post->ID, 'checkextratitle', true) == '' ) echo get_post_meta($post->ID, 'extratitle', true); ?>
     </em>
   </div>
   <?php comments_template(); ?>



 </main>
 	<?php endwhile; endif; ?>

 <?php get_footer(); ?>
