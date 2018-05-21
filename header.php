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
		<div class="snap-drawers">
			<div class="snap-drawer snap-drawer-left sidebar">
				<div class="sidebar__header">
					<a href="javascript:window.history.back()" title="Вернуться на предыдущую страницу" class="goback menu-icon"><i class="fa fa-reply"></i> Назад</a>
					<a class="sidebar-close menu-icon" href="javascript:void(0)" title="Закрыть меню"><i class="fa fa-times"></i></a>
					<a href="/" class="sidebar__logo">
						<img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="Babyke" class="lazyload">
					</a>
				</div>
			</div>
			<div class="snap-drawer snap-drawer-right">

			</div>
		</div>

	        <div id="content" class="snap-content">
	            <div id="toolbar">
	                <a href="#" id="open-left"></a>
	                <h1>Default</h1>
	            </div>
	        </div>
	</header>
