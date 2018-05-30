<?php
/**
 * Шаблон рубрики (category.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
get_header(); ?>


<main class="page-main">
  <section class="categories">
    <div class="categories__header">
      <?php
      $cat_id = get_query_var('cat');
      $filename = get_stylesheet_directory_uri() . '/images/cat/' . $cat_id . 'r.svg';
      $urlHeaders = @get_headers($filename);
      // проверяем ответ сервера на наличие кода: 200 - ОК
      if(strpos($urlHeaders[0], '200')) {
        // Если есть - выводим картинку в SVG
        echo "<img src=" . get_bloginfo( 'template_directory' ) . "/images/dots_600.svg width='150' height='150' data-src='" . $filename . "' alt='" . get_cat_name($cat_id) . "' class='lazyload categories__image' />";
        echo "</a>";
      }
      else {
        if (function_exists('z_taxonomy_image_url')){
            // Получаем URL картинки категории
            $cat_img_src = z_taxonomy_image_url($cat_id);
            // Получаем имя файла
            $file_name = end( explode("/", $cat_img_src) );
            // Узнаем расширение файла
            $file_extension = end( explode(".", $file_name) );
            // Если SVG
            if ($file_extension == 'svg') {
                // Выводим картинку в SVG
                echo get_bloginfo( 'template_directory' ) . "/images/dots_600.svg  data-src='" . $cat_img_src . "' alt='" . $category->name . "' class='lazyload categories__image' />";
            }
            // Если растровая картинка
            else if ($file_extension == 'png'||$file_extension == 'jpg'||$file_extension == 'jpeg') {
                // Выводим сжатую растровую картинку ?>
                <picture>
                  <!-- Для ширины 1000px и больше -->
                  <source data-srcset="<?php echo z_taxonomy_image_url( $cat_id, 'responsive_1200' ); ?> 1x, <?php echo z_taxonomy_image_url( $cat_id, 'responsive_2400' ); ?> 2x" media="(min-width: 1000px)">
                  <!-- Для ширины от 800px до 1000px -->
                  <source data-srcset="<?php echo z_taxonomy_image_url( $cat_id, 'responsive_1000' ); ?> 1x, <?php echo z_taxonomy_image_url( $cat_id, 'responsive_2000' ); ?> 2x" media="(min-width: 800px)">
                  <!-- Для ширины от 600px до 800px -->
                  <source data-srcset="<?php echo z_taxonomy_image_url( $cat_id, 'responsive_800' ); ?> 1x, <?php echo z_taxonomy_image_url( $cat_id, 'responsive_1600' ); ?> 2x" media="(min-width: 600px)">
                  <!-- Для ширины меньше 600px -->
                  <img  src="/wp-content/themes/babyke_mobile/images/dots_600.svg" data-srcset="<?php echo z_taxonomy_image_url( $cat_id, 'responsive_600' ); ?> 1x, <?php echo z_taxonomy_image_url( $cat_id, 'responsive_1200' ); ?> 2x" alt="<?php echo get_cat_name($cat_id); ?>" class="responsive-image lazyload categories__image">
                </picture>

            <?php  }
            // Если другой формат - выводим заглушку
            else
                echo "<img src=" . get_bloginfo( 'template_directory' ) . "/images/dots_150.svg  data-src='" . get_bloginfo('template_url') . '/images/no-image.svg' . "' alt='" . get_cat_name($cat_id) . "' class='responsive-image lazyload categories__image' />";
        }
        // Если плагин поддержки изображений для категорий не установлен - выводим заглушку
        else
          echo "<img src=" . get_bloginfo( 'template_directory' ) . "/images/dots_150.svg  data-src='" . get_bloginfo('template_url') . '/images/no-image.svg' . "' alt='" . get_cat_name($cat_id) . "' class='lazyload' />";
      }
      ?>
      <h1 class="categories__title"><?php echo get_cat_name($cat_id); ?></h1>
      <?php if ( category_description($cat_id) != NULL ) { ?>
        <div class="categories__description">
          <?php echo category_description($cat_id); ?>
          <a href="javascript:void(0)" id="more-less-options-button">Читать полностью</a>
        </div>
      <?php }; ?>
    </div>
    <div class="cat-slider__wrapper">
      <h1 class="section_title">Последние статьи</h1>
      <i class="far fa-newspaper"></i>
    </div>
    <ul class="categories__wrapper">
      <?php
      /* Получаем массив, содержащий ID родительской и вложенных категорий */
      $categories = get_categories( array('child_of'=>$cat_id) );
      $cat_child[0] = $cat_id;
      $i = 1;
      foreach( $categories as $category ){
        $cat_child[$i] = $category->cat_ID;
        $i++;
      }
      /* Указываем параметры для фильтрации */
      $custom_query_args_article = array (
                  'category__in' => $cat_child,
                  'post_type' => 'post', // тип записей
                  'posts_per_page' => '4', // количество записей на странице
                  'orderby' => 'date' ); // сортировка

      /* Получаем текущую страницу нумерации и добавляем ее к массиву пользовательских параметров */
      $custom_query_args_article['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

      /* Создаем пользовательские запросы */
      $custom_query_article = new WP_Query( $custom_query_args_article );

      /* Fix: cохраняем текущее значение wp_query, обнуляем его и задаем пользовательские параметры */
      $temp_query = $wp_query;
      $wp_query = NULL;
      $wp_query = $custom_query_article;

      /* Запускаем пользовательский цикл */
      if ( $custom_query_article->have_posts() ) :
        while ( $custom_query_article->have_posts() ) : $custom_query_article->the_post(); ?>
          <li class="category">
            <a href="<?php the_permalink(); ?>">
              <picture>
                <?php
                  if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_300' )))) {
                ?>
                  <img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="300" height="170" class="category__image">
                <?php }  else { ?>
                  <img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_300.svg"
                  data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_300' ); ?> 1x,
                  <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_600' ); ?> 2x"
                  alt="<?php the_title(); ?>" class="responsive-image lazyload category__image" width="300" height="170" />
                <?php  }?>
              </picture>
            </a>
            <div class="category__content">
              <h2>
                <a class="category__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>
              <em class="category__title--second">
                <?php if ( get_post_meta($post->ID, 'checkextratitle', true) == '' ) {
                  echo get_post_meta($post->ID, 'extratitle', true);} ?>
              </em>
              <p class="feed__excerpt">
                <?php
                  if ( has_excerpt() ){ the_excerpt(); }
                  else { kama_excerpt("maxchar=200"); }
                ?>
              </p>
            </div>
          </li>
        <?php  endwhile; endif;
        /* Конец цикла */
        /* Возвращаем значение текущего поста переменной post */
        wp_reset_postdata(); ?>
    </ul>
    <?php
    /* Выводим пагинацию */
    echo '<div class="articles-nav">';
    $next_url = get_next_posts_link('На следующую страницу');
    $next_url = str_replace('babyke.ru', $_SERVER["SERVER_NAME"], $next_url );
    echo $next_url;
    echo '</div>';
    echo '<div class="decoration"></div>';

    /* Сброс wp_query и возвращение первоначального значения */
    $wp_query = NULL;
    $wp_query = $temp_query;
    ?>
  </section>
</main>
<?php get_footer(); ?>
