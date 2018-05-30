<?php
/**
 * Главная страница (index.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */ get_header(); ?>
  <main class="page-main">
    <section class="slider-section" data-snap-ignore="true">
      <div class="slider slider__carousel owl-carousel">
        <?php
        $post_var = get_posts( array(
                        'post_type' => 'slider',
                        'orderby'   => 'ID',
                        'order' => 'DESC') );
          foreach( $post_var as $post ) { setup_postdata($post);
        ?>
        <div class="slide">
          <picture>
            <!-- Для ширины 1000px и больше -->
            <source data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1200' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_2400' ); ?> 2x" media="(min-width: 1000px)">

            <!-- Для ширины от 800px до 1000px -->
            <source data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1000' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_2000' ); ?> 2x" media="(min-width: 800px)">

            <!-- Для ширины от 600px до 800px -->
            <source data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_800' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1600' ); ?> 2x" media="(min-width: 600px)">

            <!-- Для ширины меньше 600px -->
            <img src="/wp-content/themes/babyke_mobile/images/dots_600.svg" data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_600' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1200' ); ?> 2x" alt="<?php the_title(); ?>" class="responsive-image lazyload">
          </picture>
          <div class="slide__content">
            <a class="slider__title" href="<?php echo get_post_custom_values('slider_href')[0]; ?>">
              <?php the_title(); ?>
            </a>
          </div>
        </div>
        <?php
          }
          wp_reset_postdata(); ?>
      </div>
      <div class="slide-progress"></div>
    </section>
    <div class="page-main__content">
        <?php dynamic_sidebar('main'); ?>
    </div>
  </main>
<?php get_footer(); ?>
