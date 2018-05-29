<?php
function true_remove_default_widget() {
	unregister_widget('WP_Widget_Archives'); // Архивы
	unregister_widget('WP_Widget_Calendar'); // Календарь
  unregister_widget('WP_Widget_Media_Image');      // Изображение
  unregister_widget('WP_Widget_Media_Video');      // Видео
  unregister_widget('WP_Widget_Media_Audio');      // Аудио
	unregister_widget('WP_Widget_Meta'); // Мета
	unregister_widget('WP_Widget_Pages'); // Страницы
	unregister_widget('WP_Widget_Recent_Comments'); // Свежие комментарии
	unregister_widget('WP_Widget_Recent_Posts'); // Свежие записи
	unregister_widget('WP_Widget_RSS'); // RSS
	unregister_widget('WP_Widget_Search'); // Поиск
	unregister_widget('WP_Widget_Tag_Cloud'); // Облако меток
}

add_action( 'widgets_init', 'true_remove_default_widget', 20 );

class mobilePosts extends WP_Widget {
	function __construct() {
		parent::__construct(
      'mobilePosts',
      'Сетка из четырех постов', // заголовок виджета
      array( 'description' => 'Показывает четыре последних поста выбранных категорий' ) // описание
    );
  }

	function form( $instance ){
    echo '<p> Выберите необходимые категории </p> ';
    $args = array(
									'parent'  => 0
    );
    $categories = get_categories($args);
    $arrlength=count($categories);
    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$this->get_field_id($categories[$x]->slug)] = '';
    $instance = wp_parse_args( (array) $instance, $tempArray );
		for( $x=0; $x<$arrlength; $x++) $tempCheckFlag[$categories[$x]->slug] = $instance[$categories[$x]->slug]  ? 'checked="checked"' : '';
    for( $x=0; $x<$arrlength; $x++) {
			echo '<p><input class ="checkbox" type="checkbox" value="1" id="'.$this->get_field_id($categories[$x]->slug).'" name="'.$this->get_field_name($categories[$x]->slug).'"'.$tempCheckFlag[$categories[$x]->slug].'>'.$categories[$x]->name.'</p>';
    }
	}

	public function update( $new_instance, $old_instance ) {
		$args = array(
        'parent'  => 0
    );
    $categories = get_categories( $args );   // returns an array of category objects
    $arrlength=count($categories);

    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$categories[$x]->slug] = '';
    $instance = $old_instance;
    $new_instance = wp_parse_args( (array) $new_instance, $tempArray );
    for( $x=0; $x<$arrlength; $x++ ){
        $instance[$categories[$x]->slug] = $new_instance[$categories[$x]->slug] ? 1 : 0;
    }
		return $instance;
	}

	public function widget( $args, $instance ) {
		?>
			<ul class="posts_grid">
				<?php
					foreach($instance as $key=>$value)
						if ($value) {
							$cat = get_category_by_slug($key);
							$sub_cats = get_categories( array(
								'child_of' => $cat->cat_ID,
								'hide_empty' => 0
							) );
							if( $sub_cats ){
								foreach( $sub_cats as $cat ){
									$categories_array[] = $cat->cat_ID;
								}
							}
						}
					global $post;
					$mypost = get_posts(
		                  array(
		                    'category__in'      => array(17,16,4),
		                    'post_type'         => 'post',
		                    'orderby'           => 'date',
		                    'posts_per_page'    => 4
		                    ) );
		      $side = 'left';
		      $side_count = 0;
		      $lastcol = '';
					foreach( $mypost as $post ) : setup_postdata($post); ?>
						<li class="post post--<?php echo $side; ?>">
							<a class="post__image" href="<?php the_permalink() ?>">
								<picture>
								<?php
									if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_mob' )))) {
								?>
									<img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="100" height="100">
								<?php }  else { ?>
										<img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_150.svg"
										data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_mob' ); ?> 1x,
										<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'medium' ); ?> 2x" alt="<?php the_title(); ?>"
										alt="<?php the_title(); ?>" class="responsive-image lazyload" width="100" height="100" />
								<?php  }?>
								</picture>
							</a>
							<div class="post__content">
								<h2 class="post__title">
									<a href="<?php the_permalink() ?>"><?php the_title('', '', true); ?></a>
								</h2>
								<p class="post__excerpt post__excerpt--mobile">
									<?php
										if ( has_excerpt() ){ the_excerpt(); }
										else { kama_excerpt("maxchar=50"); }
									?>
								</p>
								<p class="post__excerpt post__excerpt--tablet">
									<?php
										if ( has_excerpt() ){ the_excerpt(); }
										else { kama_excerpt("maxchar=150"); }
									?>
								</p>
							</div>
						</li>
						<?php
							$side_count = $side_count + 1;
							if ($side_count & 1) {
								$side = 'right';
								$lastcol = ' last-column';
							}
							else {
								$side = 'left';
								$lastcol = '';
							}
						?>
					<?php endforeach; ?>
			</ul>
		<?php
	}
}

class mobileNewsFeed extends WP_widget {
	function __construct() {
		parent::__construct(
			'mobileNewsFeed',
			'Лента постов', // заголовок виджета
			array( 'description' => 'Показывает ленту постов из выбранных категорий с пагинацией внизу' ) // описание
		);
	}

	function form( $instance ){
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else
			$title = __( '', 'Последние статьи' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
     echo '<p> Выберите необходимые категории </p> ';
    $args = array(
									'parent'  => 0
    );
    $categories = get_categories($args);
    $arrlength=count($categories);
    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$this->get_field_id($categories[$x]->slug)] = '';
    $instance = wp_parse_args( (array) $instance, $tempArray );
		for( $x=0; $x<$arrlength; $x++) $tempCheckFlag[$categories[$x]->slug] = $instance[$categories[$x]->slug]  ? 'checked="checked"' : '';
    for( $x=0; $x<$arrlength; $x++) {
			echo '<p><input class ="checkbox" type="checkbox" value="1" id="'.$this->get_field_id($categories[$x]->slug).'" name="'.$this->get_field_name($categories[$x]->slug).'"'.$tempCheckFlag[$categories[$x]->slug].'>'.$categories[$x]->name.'</p>';
    }
	}

	public function update( $new_instance, $old_instance ) {
		$args = array(
        'parent'  => 0
    );
    $categories = get_categories( $args );   // returns an array of category objects
    $arrlength=count($categories);

    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$categories[$x]->slug] = '';
    $instance = $old_instance;
    $new_instance = wp_parse_args( (array) $new_instance, $tempArray );
    for( $x=0; $x<$arrlength; $x++ ){
        $instance[$categories[$x]->slug] = $new_instance[$categories[$x]->slug] ? 1 : 0;
    }
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Последние новости';
		return $instance;
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		?>
		<div class="feed__wrapper">
			<h1 class="section_title"><?php echo $title; ?></h1>
			<i class="far fa-newspaper"></i>
		</div>
		<ul class="feed">
			<?php
				array_pop($instance);
				foreach($instance as $key=>$value)
					if ($value) {
						$cat = get_category_by_slug($key);
						$sub_cats = get_categories( array(
							'child_of' => $cat->cat_ID,
							'hide_empty' => 0
						) );
						if( $sub_cats ){
							foreach( $sub_cats as $cat ){
								$categories_array[] = $cat->cat_ID;
							}
						}
					}
					$custom_query_args = array (
															'category__in' => $categories_array, // записи из категорий
															'post_type' => 'post', // тип записей
															'posts_per_page' => '4', // количество записей на странице
															'orderby' => 'date' ); // сортировка
					/* Получаем текущую страницу нумерации и добавляем ее к массиву пользовательских параметров */
					$custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

					/* Создаем пользовательские запросы */
					$custom_query = new WP_Query( $custom_query_args );

					/* Fix: cохраняем текущее значение wp_query, обнуляем его и задаем пользовательские параметры */
					$temp_query = $wp_query;
					$wp_query = NULL;
					$wp_query = $custom_query;

					/* Запускаем пользовательский цикл */
					if ( $custom_query->have_posts() ) :
						while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
						<li class="feed__post">
							<a href="<?php the_permalink() ?>">
								<picture>
									<?php
										if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_300' )))) {
									?>
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="300" height="170">
									<?php }  else { ?>
										<img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_300.svg"
										data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_300' ); ?> 1x,
										<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_600' ); ?> 2x"
										alt="<?php the_title(); ?>" class="responsive-image lazyload" width="300" height="170" />
									<?php  }?>
								</picture>
							</a>
	            <div class="feed__content">
	              <a class="feed__title" href="<?php the_permalink() ?>"><h2><?php the_title('', '', true); ?></h2></a>
	              <em class="feed__title--second">
	                <?php if ( get_post_meta($post->ID, 'checkextratitle', true) == '' ) { echo get_post_meta($post->ID, 'extratitle', true);} ?>
	              </em>
	              <p class="feed__excerpt">
	                <?php
	                  if ( has_excerpt() ){ the_excerpt(); }
	                  else { kama_excerpt("maxchar=200"); }
	                ?>
	              </p>
	            </div>
	          </li>
						<?php
						endwhile;
					endif;

					/* Возвращаем значение текущего поста переменной post */
	        wp_reset_postdata();

	        /* Выводим пагинацию */
	        echo '<div class="articles-nav">';
	        $next_url = get_next_posts_link('На следующую страницу');
	        $next_url = str_replace('babyke.ru', $_SERVER["SERVER_NAME"], $next_url );
	        echo $next_url;
	        echo '</div>';

	        /* Сброс wp_query и возвращение первоначального значения */
	        $wp_query = NULL;
	        $wp_query = $temp_query; ?>
			</ul>
		<?php
	}
}

class mobileCategoriesSlider extends WP_widget {
	function __construct() {
		parent::__construct(
      'mobileCategoriesSlider',
      'Слайдер категорий', // заголовок виджета
      array( 'description' => 'Слайдер категорий' ) // описание
    );
  }

	function form( $instance ){
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else
			$title = __( '', 'Категории' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
     echo '<p> Выберите необходимые категории </p> ';
    $args = array(
									'parent'  => 0
    );
    $categories = get_categories($args);
    $arrlength=count($categories);
    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$this->get_field_id($categories[$x]->slug)] = '';
    $instance = wp_parse_args( (array) $instance, $tempArray );
		for( $x=0; $x<$arrlength; $x++) $tempCheckFlag[$categories[$x]->slug] = $instance[$categories[$x]->slug]  ? 'checked="checked"' : '';
    for( $x=0; $x<$arrlength; $x++) {
			echo '<p><input class ="checkbox" type="checkbox" value="1" id="'.$this->get_field_id($categories[$x]->slug).'" name="'.$this->get_field_name($categories[$x]->slug).'"'.$tempCheckFlag[$categories[$x]->slug].'>'.$categories[$x]->name.'</p>';
    }
	}

	public function update( $new_instance, $old_instance ) {
		$args = array(
        'parent'  => 0
    );
    $categories = get_categories( $args );   // returns an array of category objects
    $arrlength=count($categories);

    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$categories[$x]->slug] = '';
    $instance = $old_instance;
    $new_instance = wp_parse_args( (array) $new_instance, $tempArray );
    for( $x=0; $x<$arrlength; $x++ ){
        $instance[$categories[$x]->slug] = $new_instance[$categories[$x]->slug] ? 1 : 0;
    }
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Категории';
		return $instance;
	}


	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		?>
		<div class="cat-slider__wrapper">
			<h1 class="section_title"><?php echo $title; ?></h1>
			<i class="fas fa-book"></i>
		</div>
		<div class="slider__wrapper">
			<div class="staff-slider owl-carousel owl-theme" data-snap-ignore="true">
				<?php
					array_shift($instance);
					foreach($instance as $key=>$value)
						if ($value) {
							$cat = get_category_by_slug($key);
							$categories_array[] = $cat->cat_ID;
						}
						$args = 'include=' . implode(',', $categories_array) . '&orderby=none';
						$categories = get_categories($args);
						if( $categories ){
							foreach( $categories as $category ){ ?>
								<div class="staff-item">
										<?php
										// Адреса наших svg файлов
										$filename = get_stylesheet_directory_uri() . '/images/cat/' . $category->term_id . '.svg';
										$urlHeaders = @get_headers($filename);
										// проверяем ответ сервера на наличие кода: 200 - ОК
										if(strpos($urlHeaders[0], '200')) {
											// Если есть - выводим картинку в SVG
											echo "<a href='/" . $category->slug . "'>";
											echo "<img src=" . get_bloginfo( 'template_directory' ) . "/images/dots_150.svg width='150' height='150' data-src='" . $filename . "' alt='" . $category->name . "' class='lazyload' />";
											echo "</a>";
										}
										else {
											if (function_exists('z_taxonomy_image_url')){
	                        // Получаем URL картинки категории
	                        $cat_img_src = z_taxonomy_image_url($category->term_id);
	                        // Получаем имя файла
	                        $file_name = end( explode("/", $cat_img_src) );
	                        // Узнаем расширение файла
	                        $file_extension = end( explode(".", $file_name) );
	                        // Если SVG
	                        if ($file_extension == 'svg') {
	                            // Выводим картинку в SVG
	                            echo get_bloginfo( 'template_directory' ) . "/images/dots_150.svg width='150' height='150' data-src='" . $cat_img_src . "' alt='" . $category->name . "' class='lazyload' />";
	                        }
	                        // Если растровая картинка
	                        else if ($file_extension == 'png'||$file_extension == 'jpg'||$file_extension == 'jpeg') {
	                            // Выводим сжатую растровую картинку ?>
	                            <img src="<?php echo get_bloginfo( 'template_directory' );?>/images/dots_150.svg" data-srcset="<?php echo z_taxonomy_image_url($category->term_id, 'thumbnail'); ?> 1x, <?php echo z_taxonomy_image_url($category->term_id, 'medium'); ?> 2x" alt="<?php echo $category->name; ?>"width='150' height='150' class="responsive-image lazyload cat-img--loaded" >
	                        <?php  }
	                        // Если другой формат - выводим заглушку
	                        else
	                            echo "<img src=" . get_bloginfo( 'template_directory' ) . "/images/dots_150.svg
															data-src='" . get_bloginfo('template_url') .'/images/no-image.svg' . "' alt='" . get_cat_name($cat_id) . "'width='150' height='150' class='cat_thumb lazyload' />";
	                    }
	                    // Если плагин поддержки изображений для категорий не установлен - выводим заглушку
	                    //else
	                    //	echo "<img src=" . get_bloginfo( 'template_directory' ) . "/images/dots_150.svg width='150' height='150' data-src='" . get_bloginfo('template_url') . '/images/no-image.svg' . "' alt='" . $category->name . "' class='cat_thumb lazyload' />";
										}
										?>
										<a class="staff__name" href="/<?php echo $category->slug; ?>"><?php echo $category->name; ?></a>
								</div>
						<?php } } ?>
			</div>
		</div>
		<?php
	}
}

function register_widgets() {
	register_widget( 'mobilePosts' );
	register_widget( 'mobileNewsFeed' );
	register_widget( 'mobileCategoriesSlider' );
}
add_action( 'widgets_init', 'register_widgets' );
?>
