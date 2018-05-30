<?php
/**
 * Шаблон обычной страницы (page.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
 get_header();
 if (have_posts()) :  while (have_posts()) : the_post();
 ?>

 <main class="page-main">
	 <article class="article">
     <picture>
     <?php
       if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_1200' )))) {
     ?>
       <img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" class="article__image">
     <?php }  else { ?>
       <source srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1200' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_2400' ); ?> 2x" media="(min-width: 1000px)">
       <!-- Для ширины от 800px до 1000px -->
       <source srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1000' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_2000' ); ?> 2x" media="(min-width: 800px)">
       <!-- Для ширины от 600px до 800px -->
       <source srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_800' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1600' ); ?> 2x" media="(min-width: 600px)">
       <!-- Для ширины меньше 600px -->
       <img src="/wp-content/themes/babyke_mobile/images/dots_600.svg" srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_600' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1200' ); ?> 2x" alt="<?php the_title(); ?>" class="responsive-image article__image">
     <?php  }?>
     </picture>
     <div class="article__wrapper">
       <h1 class="article__title"><?php the_title(); ?></h1>
       <em class="article__title--second">
         <?php
         if ( get_post_meta($post->ID, 'checkextratitle', true) == '' )
          echo get_post_meta($post->ID, 'extratitle', true); ?>
        </em>
         <div class="article__content"><?php the_content(); ?></div>
     </div>
	 </article>
 </main>
 	<?php endwhile; endif; ?>

 <?php get_footer(); ?>
