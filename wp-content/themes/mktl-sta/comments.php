<?php
/**
 * @package Case-Themes
 */

if ( post_password_required() ) {
    return;
    } ?>

    <div id="comments" class="comments-area">

        <?php
        if ( have_comments() ) : ?>
            <div class="comment-list-wrap">

                <h2 class="comments-title">
                    <?php
                        $comment_count = get_comments_number();
                        if ( 1 === intval($comment_count) ) {
                            echo esc_html__( '1 Comment', 'Lawsight' );
                        } else {
                            echo esc_attr( $comment_count ).' '.esc_html__('Comments', 'Lawsight');
                        }
                    ?>
                </h2>

                <?php the_comments_navigation(); ?>

                <ul class="comment-list">
                    <?php
                        wp_list_comments( array(
                            'style'      => 'ul',
                            'short_ping' => true,
                            'callback'   => 'lawsight_comment_list',
                            'max_depth'  => 3
                        ) );
                    ?>
                </ul>

                <?php the_comments_navigation(); ?>
            </div>
            <?php if ( ! comments_open() ) : ?>
                <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'Lawsight' ); ?></p>
            <?php
            endif;

        endif;

    $args = array(
            'id_form'           => 'commentform',
            'id_submit'         => 'submit',
            'class_submit'         => 'btn btn-text-parallax btn-icon-box',
            'title_reply'       => esc_attr__( 'Leave A Reply', 'Lawsight'),
            'title_reply_to'    => esc_attr__( 'Leave A Comment To ', 'Lawsight') . '%s',
            'cancel_reply_link' => esc_attr__( 'Cancel Comment', 'Lawsight'),
            'submit_button'     => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" /><span class="pxl--btn-text">%4$s</span><span class="pxl--btn-icon"><i class="flaticon-up-right-arrow"></i></span></button>',
            'comment_notes_before' => '',
            'fields' => apply_filters( 'comment_form_default_fields', array(

                    'author' =>
                    '<div class="row"><div class="comment-form-author col-lg-4 col-md-4 col-sm-12">'.
                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                    '" size="30" placeholder="'.esc_attr__('Name*', 'Lawsight').'"/></div>',

                    'email' =>
                    '<div class="comment-form-email col-lg-4 col-md-4 col-sm-12">'.
                    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                    '" size="30" placeholder="'.esc_attr__('Email*', 'Lawsight').'"/></div>',

                    // 'phone' =>
                    // '<div class="comment-form-phone col-lg-6 col-md-6 col-sm-12">'.
                    // '<input id="email" name="phone" type="text" value="" size="30" placeholder="'.esc_attr__('Phone Number', 'Lawsight').'"/></div>',

                    'website' =>
                    '<div class="comment-form-website col-lg-4 col-md-4 col-sm-12">'.
                    '<input id="website" name="url" type="text" value="" size="30" placeholder="'.esc_attr__('Website*', 'Lawsight').'"/></div></div>',
            )
            ),
            'comment_field' =>  '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="'.esc_attr__('Your Comment...', 'Lawsight').'" aria-required="true">' .
            '</textarea></div>',
    );
    comment_form($args); ?>
</div>