<?php
/**
 * Шаблон комментариев (comments.php)
 * Выводит список комментариев и форму добавления
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>

<?php
if ( post_password_required() ) {
	return;
}
?>

<div class="comments-wrapper">
	<?php if ( have_comments() ) : ?>
		<div class="block-name-wrapper">
			<div class="block-name">
				<span><i class="fa fa-comments-o"></i>
					<?php printf( _n( 'Один комментарий', 'Комментарии (всего %1$s)', get_comments_number() ),
						number_format_i18n( get_comments_number() ) );	?>
				</span>
			</div>
		</div>

		<div class="commentlist">
			<?php
				wp_list_comments( array(
					'walker'            => null,
					'max_depth'         => '',
					'style'             => 'div',
					'callback'          => null,
					'end-callback'      => null,
					'type'              => 'comment',
					'reply_text'        => 'Ответить',
					'page'              => '',
					'per_page'          => 0,
					'avatar_size'       => 80,
					'reverse_top_level' => null,
					'reverse_children'  => '',
					'format'            => 'html5',
					'short_ping'        => false,
					'echo'              => true
				) ); ?>
		</div>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<div class="block-name-wrapper">
			<div class="block-name">
				<span><i class="fa fa-comments-o"></i>Комментаривание закрыто</span>
			</div>
		</div>
	<?php endif; ?>

	<?php

	ob_start();
	comment_form(
		array(
		'fields' => '<p class="comment-form-author">' . ( $req ? '<span class="required">*</span>' : '' ) . '<input placeholder="Ваше имя" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" placeholder="Ваш комментарий" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as' => '',
		'comment_notes_before' => '',
		'comment_notes_after' => ''
		,'id_form' => 'commentform'
		,'id_submit' => 'submit'
		,'title_reply' => __( 'Leave a Reply' )
		,'title_reply_to' => __( 'Leave a Reply to %s' )
		,'cancel_reply_link' => __( 'Cancel reply' )
		,'label_submit' => __( 'Post Comment' ) )
	 );

	$form = ob_get_clean();

	$form = str_replace('<h3 id="reply-title" class="comment-reply-title">', '<label for="comment" class="comment-reply-title"><i class="fa fa-pencil"></i>', $form );
	$form = str_replace('</h3>', '</label>', $form );

	echo $form;	 ?>

</div><!-- .comments-area -->
