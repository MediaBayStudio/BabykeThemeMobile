<?php
register_sidebar (array(
				'name' => 'Главная страница',
				'id' => 'main',
				'before_widget' => '<section class="main-posts main-posts--%2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<div class=""><span>',
				'after_title'   => '</span></div>'));
?>
