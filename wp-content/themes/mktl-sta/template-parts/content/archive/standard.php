<?php
/**
 * @package Case-Themes
 */
$archive_readmore_text = Lawsight()->get_theme_opt('archive_readmore_text', esc_html__('Read More', 'Lawsight'));
$featured_img_size = Lawsight()->get_theme_opt('featured_img_size', '960x460');
$post_video_link = get_post_meta(get_the_ID(), 'post_video_link', true);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('pxl---post pxl-item--archive pxl-item--standard'); ?>>
    <?php if (has_post_thumbnail()) {
        $img  = pxl_get_image_by_size( array(
            'attach_id'  => get_post_thumbnail_id($post->ID),
            'thumb_size' => $featured_img_size,
        ) );
        $thumbnail    = $img['thumbnail'];
        echo '<div class="pxl-item--image">'; ?>
            <a href="<?php echo esc_url( get_permalink()); ?>"><?php echo pxl_print_html($thumbnail); ?></a>
            <?php if(!empty($post_video_link)) : ?>
                <a href="<?php echo esc_url($post_video_link); ?>" class="post-button-video pxl-action-popup"><i class="caseicon-play1"></i></a>
            <?php endif; ?>
        <?php echo '</div>';
    } ?>
    <div class="pxl-item--holder">
        <?php Lawsight()->blog->get_archive_meta(); ?>
        <h2 class="pxl-item--title">
            <a href="<?php echo esc_url( get_permalink()); ?>" title="<?php the_title_attribute(); ?>">
                <?php if(is_sticky()) { ?>
                    <i class="caseicon-check-mark pxl-mr-4"></i>
                <?php } ?>
                <?php the_title(); ?>
            </a>
        </h2>
        
        <div class="pxl-item--excerpt">
            <?php
                Lawsight()->blog->get_excerpt();
                wp_link_pages( array(
                    'before'      => '<div class="page-links">',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                ) );
            ?>
        </div>
        <div class="pxl-item--readmore">
            <a class="btn btn-text-parallax btn-icon-box" href="<?php echo esc_url( get_permalink()); ?>">
                <span class="pxl--btn-text"><?php echo lawsight_html($archive_readmore_text); ?></span>
                <span class="pxl--btn-icon"><i class="flaticon-up-right-arrow"></i></span>
            </a>
        </div>
    </div>
</article>