<?php
$source = $widget->get_setting('source', '');
$orderby = $widget->get_setting('orderby', 'date');
$order = $widget->get_setting('order', 'desc');
$limit = $widget->get_setting('limit', 4);
$post_ids = $widget->get_setting('post_ids', '');
extract(pxl_get_posts_of_grid('post', [
    'source' => $source,
    'orderby' => $orderby,
    'order' => $order,
    'limit' => $limit,
    'post_ids' => $post_ids,
]));

$show_date = $widget->get_setting('show_date', '');
$show_author = $widget->get_setting('show_author', '');
$show_comment = $widget->get_setting('show_comment', '');
$show_excerpt = $widget->get_setting('show_excerpt', '');
$num_words = $widget->get_setting('num_words', '');
$show_button = $widget->get_setting('show_button', '');
$button_text = $widget->get_setting('button_text', '');


if (is_array($posts)): ?>
    <div class="pxl-recent-news pxl-recent-news1">
        <?php foreach ($posts as $key => $post): 
            $author = get_user_by('id', $post->post_author);
            $comment_count = get_comments_number($post->ID); ?>
            <div class="pxl-post-item">
                <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)):
                    $img_id = get_post_thumbnail_id($post->ID);
                    $img          = pxl_get_image_by_size( array(
                        'attach_id'  => $img_id,
                        'thumb_size' => '640x400'
                    ) );
                    $thumbnail    = $img['thumbnail'];
                    $thumbnail_url    = $img['url'];
                    ?>
                    <div class="pxl-post--featured bg-image" style="background-image: url(<?php echo esc_url($thumbnail_url); ?>);">
                        <a class="pxl-post--link" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"></a>
                        <?php if($show_date == 'true'): ?>
                            <div class="pxl-post--date">
                                <div class="pxl-date--inner">
                                    <i class="caseicon-calendar-alt pxl-mr-5"></i>
                                    <?php echo get_the_date('F', $post->ID); ?>,
                                    <?php echo get_the_date('d', $post->ID); ?>
                                    <?php echo get_the_date('Y', $post->ID); ?>
                                </div>  
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="pxl-post--holder">
                    <h5 class="pxl-post--title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_html(get_the_title($post->ID)); ?></a></h5>
                    <?php if($show_author == 'true' || $show_comment == 'true') : ?>
                        <div class="pxl-post--meta">
                            <?php if($show_author == 'true'): ?>
                                <div class="pxl-post--author pxl-mr-22">
                                    <a href="<?php echo esc_url(get_author_posts_url($post->post_author, $author->user_nicename)); ?>">
                                        <i class="flaticon-user pxl-mr-6 text-gradient"></i><?php echo esc_html__('By', 'lawsight').' '.esc_html($author->display_name); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if($show_comment == 'true'): ?>
                                <div class="pxl-post--comment">
                                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>#comments">
                                        <i class="flaticon-chat pxl-mr-6 text-gradient"></i>
                                        <?php echo esc_attr($comment_count ); ?>
                                        <?php if($comment_count > 1) { echo esc_html__('Comments', 'lawsight'); } ?>
                                        <?php if($comment_count == 1 || $comment_count == 0) { echo esc_html__('Comment', 'lawsight'); } ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if($show_excerpt == 'true'): ?>
                        <div class="pxl-post--excerpt">
                            <?php echo wp_trim_words( $post->post_excerpt, $num_words, $more = null ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($show_button == 'true') : ?>
                        <div class="pxl-post--readmore">
                            <a class="btn btn-text-parallax btn-icon-box" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                <span class="pxl--btn-text"><?php if(!empty($button_text)) {
                                    echo esc_attr($button_text);
                                } else {
                                    echo esc_html__('Read More', 'lawsight');
                                } ?></span>
                                <span class="pxl--btn-icon"><i class="flaticon-up-right-arrow"></i></span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>