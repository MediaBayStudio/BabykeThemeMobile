<?php
/**
 * Главная страница (index.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
get_header(); ?>
<div id="content" class="snap-content main-wrapper">
  <div id="toolbar">
    <a href="#" class="toolbar__deploy sidebar-deploy--left">
      <i class="fas fa-bars" aria-hidden="true"></i>
    </a>
    <a href="/" class="toolbar__header">
      <h1>Babyke</h1>
    </a>
    <div class="toolbar__icons">
      <div class="toolbar__font-controls">
        <div class="toolbar__control">
          <a class="up-font-deploy" title="Увеличить размер шрифта">
            <i class="fa fa-plus"></i>
          </a>
        </div>
        <div class="toolbar__control">
          <a class="down-font-deploy" title="Увеличить размер шрифта">
            <i class="fa fa-minus"></i>
          </a>
        </div>
      </div>
      <a class="toolbar__deploy sidebar-deploy--right">
        <i class="fa fa-envelope"></i>
      </a>
      <a href="javascript:window.history.back()" class="toolbar__deploy" title="Вернуться на предыдущую страницу">
        <i class="fa fa-reply"></i>
      </a>
    </div>
  </div>
  <main class="page-main">
    <section class="slider-section" data-snap-ignore="true">
    <?php
      $post_var = get_posts(
                  array(
                    'post_type' => 'slider',
                    'orderby'   => 'ID',
                    'order' => 'DESC'
                  ));
      foreach( $post_var as $post ) {
        setup_postdata($post); ?>
        <div class="slide">
          <div class="slide__title">
            <a class="slide__button" href="<?php echo get_post_custom_values('slider_href')[0]; ?>">
              <?php the_title(); ?>
            </a>
          </div>
        </div>
        <picture class="slide__image">
          <!-- Для ширины 1000px и больше -->
          <source data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1200' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_2400' ); ?> 2x" media="(min-width: 1000px)">

          <!-- Для ширины от 800px до 1000px -->
          <source data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1000' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_2000' ); ?> 2x" media="(min-width: 800px)">

          <!-- Для ширины от 600px до 800px -->
          <source data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_800' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1600' ); ?> 2x" media="(min-width: 600px)">

          <!-- Для ширины меньше 600px -->
          <img src="/wp-content/themes/babyke_mobile/images/dots_600.svg" data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_600' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1200' ); ?> 2x" alt="<?php the_title(); ?>" class="responsive-image lazyload">
        </picture>
        <?php }
        wp_reset_postdata(); ?>
    </section>
  </main>
</div>
<?php get_footer(); ?>
