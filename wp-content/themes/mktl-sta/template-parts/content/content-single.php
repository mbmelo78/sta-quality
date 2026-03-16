<?php
/**
 * Template part for displaying posts in loop
 *
 * @package Case-Themes
 */
$post_tag = Lawsight()->get_theme_opt( 'post_tag', true );
$post_navigation = Lawsight()->get_theme_opt( 'post_navigation', false );
$post_social_share = Lawsight()->get_theme_opt( 'post_social_share', false );
$tags_list = get_the_tag_list();
$sg_post_title = Lawsight()->get_theme_opt('sg_post_title', 'default');
$sg_featured_img_size = Lawsight()->get_theme_opt('sg_featured_img_size', '900x533');
$post_video_link = get_post_meta(get_the_ID(), 'post_video_link', true);
?>
<article id="pxl-post-<?php the_ID(); ?>" <?php post_class('pxl---post'); ?>>
    <?php if (has_post_thumbnail()) {
        $img  = pxl_get_image_by_size( array(
            'attach_id'  => get_post_thumbnail_id($post->ID),
            'thumb_size' => $sg_featured_img_size,
        ) );
        $thumbnail    = $img['thumbnail']; ?>
        <div class="pxl-item--image">
            <?php echo wp_kses_post($thumbnail); ?>
            <?php if(!empty($post_video_link)) : ?>
                <a href="<?php echo esc_url($post_video_link); ?>" class="post-button-video pxl-action-popup"><i class="caseicon-play1"></i></a>
            <?php endif; ?>        
        </div>
    <?php } ?>

    

    <?php if(is_singular('post') && $sg_post_title == 'custom_text') { ?>
        <h2 class="pxl-item--title">
            <?php the_title(); ?>
        </h2>
    <?php } ?>

    <div class="pxl-item-box-shardow">
    <?php Lawsight()->blog->get_post_metas(); ?>
    <div class="pxl-item--content clearfix">
        <?php
            the_content();
            wp_link_pages( array(
                'before'      => '<div class="page-links">',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
            ) );
        ?>
    </div>
    </div>
    <?php if($post_tag && $tags_list || $post_social_share ) :  ?>
        <div class="pxl--post-footer">
            <?php if($post_tag) { Lawsight()->blog->get_tagged_in(); } ?>
            <?php if($post_social_share) { Lawsight()->blog->get_socials_share(); } ?>
        </div>
    <?php endif; ?>
    <?php if($post_navigation) { Lawsight()->blog->get_post_nav(); } ?>
</article><!-- #post -->