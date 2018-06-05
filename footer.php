<?php
/**
 * Шаблон подвала (footer.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
	<footer class="footer">
		<a href="javascript:void(0)" class="footer__button footer__button--share">
			Поделиться
			<i class="fa fa-share-alt"></i>
		</a>
		<a href="javascript:void(0)" class="footer__button footer__button--up">
			Наверх
			<i class="fa fa-arrow-up"></i>
		</a>
	</footer>
</div>
<div class="share">
	<p class="share__title">Поделиться</p>
	<div class="share__wrapper">
		<a class="share__social" href="https://vk.com/share.php?url=<?php echo get_current_URL(); ?>&title=<?php echo get_current_title(); ?>&description=<?php echo get_current_description(); ?>&image=<?php echo get_current_img(); ?>&utm_source=share2">
			<i class="fab fa-vk share__icon share__icon--vk"></i>
			Вконтакте
		</a>
		<a class="share__social"  href="https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=<?php echo get_current_URL(); ?>&utm_source=share2" class="ok_share">
			<i class="fab fa-odnoklassniki share__icon share__icon--ok"></i>
			<span class="ok_title">Одноклассники</span>
		</a>
		<a class="share__social"  href="https://connect.mail.ru/share?url=<?php echo get_current_URL(); ?>&title=<?php echo get_current_title(); ?>&description=<?php echo get_current_description(); ?>&image_url=<?php echo get_current_img(); ?>&utm_source=share2">
			<i class="far fa-smile share__icon share__icon--mail"></i>
			Мой Мир
		</a>
		<a class="share__social"  href="https://plus.google.com/share?url=<?php echo get_current_URL(); ?>&utm_source=share2">
			<i class="fab fa-google-plus-g share__icon share__icon--google"></i>
			Google
		</a>
		<a class="share__social"  href="https://www.facebook.com/sharer.php?src=sp&u=<?php echo get_current_URL(); ?>&utm_source=share2">
			<i class="fab fa-facebook-f share__icon share__icon--fb"></i>
			Facebook
		</a>
		<a class="share__social"  href="https://twitter.com/intent/tweet?text=<?php echo get_current_title(); ?>&url=<?php echo get_current_URL(); ?>&utm_source=share2">
			<i class="fab fa-twitter share__icon share__icon--twi"></i>
			Twitter
	</div>
			<a href="javascript:void(0)" class="share__close">Закрыть</a>
</div>
<?php wp_footer(); ?>
</body>
</html>
