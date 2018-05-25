<?php
/**
* Header темы
* @package MediaThemeMobile
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>  class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui">
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="msapplication-config" content="/browserconfig.xml" />
	<title><?php is_home() ? bloginfo('description') : wp_title(''); ?></title>
	<meta name="application-name" content="<?php echo bloginfo('name'); ?>"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="preloader">
		<div id="status"></div>
	</div>
	<header class="page-header" id="header-fixed">
		<nav class="snap-drawers">
			<div class="snap-drawer snap-drawer-left sidebar">
				<div class="sidebar__header">
					<div class="sidebar__controls">
						<a class="sidebar__control sidebar__control--back" href="javascript:window.history.back()" title="Вернуться на предыдущую страницу"><i class="fa fa-reply"></i> Назад</a>
						<a class="sidebar__control sidebar__control--close" href="javascript:void(0)" title="Закрыть меню"><i class="fa fa-times"></i></a>
					</div>
					<a href="/" class="sidebar__logo">
						<img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="<?php echo bloginfo('name'); ?>" class="lazyload" width="190px" height="70px">
					</a>
				</div>
				<?php wp_nav_menu(
					array (
						'theme_location'    => 'mobile',
						'menu'              => 'Mobile Menu',
						'container'         => false,
						'container_class'   => '',
						'container_id'      => '',
						'menu_class'        => 'sidebar__menu',
						'menu_id'           => '',
						'echo'              => true,
						'fallback_cb'       => 'wp_page_menu',
						'before'            => '',
						'after'             => '',
						'link_before'       => '',
						'link_after'        => '',
						'items_wrap'        => '<ul class="%2$s">%3$s</ul>',
						'depth'             => 0,
						'walker'            => new babyke_nav_menu
					)); ?>
					<div class="sidebar__coopyright">
						<?php echo bloginfo('name') . " &copy" . date('Y'); ?>
					</div>
			</div>
			<div class="snap-drawer snap-drawer-right">
				<div class="sidebar__header">
					<div class="sidebar__controls">
						<a class="sidebar__control sidebar__control--back" href="javascript:window.history.back()" title="Вернуться на предыдущую страницу"><i class="fa fa-reply"></i> Назад</a>
						<a class="sidebar__control sidebar__control--close" href="javascript:void(0)" title="Закрыть меню"><i class="fa fa-times"></i></a>
					</div>
					<a href="/" class="sidebar__logo">
						<img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="<?php echo bloginfo('name'); ?>" class="lazyload" width="190px" height="70px">
					</a>
				</div>
				<div class="sidebar__divider">
					Будьте на связи
				</div>
				<ul class="sidebar__menu sidebar__menu--contacts">
					<li>
						<a href="<?php echo get_site_url();?>/contact" target="_blank">
							<i class="far fa-envelope-open"></i>
							Напишите нам
							<i class="fa fa-caret-right"></i>
						</a>
					</li>
				</ul>
				<?php wp_nav_menu(
					array (
						'theme_location'    => 'social',
						'menu'              => 'SocialLink Menu',
						'container'         => false,
						'container_class'   => '',
						'container_id'      => '',
						'menu_class'        => 'sidebar__menu sidebar__menu--social-links',
						'menu_id'           => '',
						'echo'              => true,
						'fallback_cb'       => '',
						'before'            => '',
						'after'             => '',
						'link_before'       => '',
						'link_after'        => '',
						'items_wrap'        => '<ul class="%2$s"><div class="sidebar__divider">Мы в соцсетях</div>%3$s</ul>',
						'depth'             => 0,
						'walker'						=> ''
					)); ?>
			</div>
		</nav>
	</header>
