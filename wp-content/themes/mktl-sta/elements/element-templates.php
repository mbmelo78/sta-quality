<?php 
 
if(!function_exists('lawsight_get_post_grid')){
    function lawsight_get_post_grid($posts = [], $settings = []){ 
        if (empty($posts) || !is_array($posts) || empty($settings) || !is_array($settings)) {
            return false;
        }
        switch ($settings['layout']) {
            case 'post-1':
                lawsight_get_post_grid_layout1($posts, $settings);
                break;

            case 'portfolio-1':
                lawsight_get_portfolio_grid_layout1($posts, $settings);
                break;

            case 'portfolio-2':
                lawsight_get_portfolio_grid_layout2($posts, $settings);
                break;
            case 'portfolio-3':
                lawsight_get_portfolio_grid_layout2($posts, $settings);
                break;
            case 'service-1':
                lawsight_get_service_grid_layout1($posts, $settings);
                break;


            default:
                return false;
                break;
        }
    }
}

// Start Post Grid
//--------------------------------------------------
function lawsight_get_post_grid_layout1($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : '600x438';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && (count($grid_masonry) > 1)) {
                if($grid_masonry[$key]['col_xl_m'] == 'col-66') {
                    $col_xl_m = '66-pxl';
                } else {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                }
                if($grid_masonry[$key]['col_lg_m'] == 'col-66') {
                    $col_lg_m = '66-pxl';
                } else {
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                }
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = ''; 
            $current_user = wp_get_current_user();
            $post_video_link = get_post_meta($post->ID, 'post_video_link', true); ?>
            <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                <div class="pxl-post--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s">
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)):
                        $img_id = get_post_thumbnail_id($post->ID);
                        $img          = pxl_get_image_by_size( array(
                            'attach_id'  => $img_id,
                            'thumb_size' => $images_size
                        ) );
                        $thumbnail    = $img['thumbnail'];
                        ?>
                        <div class="pxl-post--featured hover-imge-effect2">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                            <?php if(!empty($post_video_link)) : ?>
                                <a href="<?php echo esc_url($post_video_link); ?>" class="post-button-video pxl-action-popup"><i class="caseicon-play1"></i></a>
                            <?php endif; ?>
                            
                            <div class="item-overlay"></div>
                            <a class="item-more" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"> <i class="ct-icon-plus fa fa-plus"></i></a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="pxl-post--meta">
                    <?php if($show_date == 'true'): ?>
                            <div class="pxl-post--date pxl-mr-10">
                                <i class="fas fa-calendar-alt pxl-mr-7"></i>
                                <?php echo get_the_date('F d', $post->ID); ?>,<?php echo get_the_date('Y', $post->ID); ?>        
                            </div>
                        <?php endif; ?>
                        <?php if($show_author == 'true'): ?>
                            <div class="pxl-post--author pxl-mr-10">
                                <i class="fas fa-user-alt pxl-mr-7"></i>
                                <?php echo esc_html__('by', 'Lawsight'); ?>&nbsp;<?php echo esc_attr($current_user->user_login); ?>
                            </div>
                        <?php endif; ?>
                        <?php if($show_comment) : ?>
                            <div class="pxl-item--comment pxl-mr-10">
                                <i class="flaticon-chat text-gradient pxl-mr-7"></i>
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>#comments">
                                    <?php echo comments_number(esc_html__('No Comments', 'Lawsight'),esc_html__('1 Comment', 'Lawsight'),esc_html__('% Comments', 'Lawsight')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h3 class="pxl-post--title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_html(get_the_title($post->ID)); ?></a></h3>
                    <?php if($show_excerpt == 'true'): ?>
                        <div class="pxl-post--content">
                            <?php echo wp_trim_words( $post->post_excerpt, $num_words, $more = null ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($show_button == 'true') : ?>
                        <div class="pxl-post--button">
                            <a class="btn" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                <?php if(!empty($button_text)) {
                                    echo esc_attr($button_text);
                                } else {
                                    echo esc_html__('Read More', 'Lawsight');
                                } ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php
        endforeach;
    endif;
}

// End Post Grid
//--------------------------------------------------

// Start Portfolio Grid
//--------------------------------------------------
function lawsight_get_portfolio_grid_layout1($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : '600x600';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            if($key == 0) {
                $item_class = "pxl-grid-item col-xl-6 col-lg-6 col-md-4 col-sm-6 col-12";
            } else {
                $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                if(isset($grid_masonry) && !empty($grid_masonry[$key]) && (count($grid_masonry) > 1)) {
                    if($grid_masonry[$key]['col_xl_m'] == 'col-66') {
                        $col_xl_m = '66-pxl';
                    } else {
                        $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                    }
                    if($grid_masonry[$key]['col_lg_m'] == 'col-66') {
                        $col_lg_m = '66-pxl';
                    } else {
                        $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                    }
                    $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                    $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                    $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                    $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                    
                    $img_size_m = $grid_masonry[$key]['img_size_m'];
                    if(!empty($img_size_m)) {
                        $images_size = $img_size_m;
                    }
                } elseif (!empty($img_size)) {
                    $images_size = $img_size;
                }
            }
            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID); 
            if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="pxl-post--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s">
                        <?php $img_id = get_post_thumbnail_id($post->ID);
                        $img          = pxl_get_image_by_size( array(
                            'attach_id'  => $img_id,
                            'thumb_size' => $images_size
                        ) );
                        $thumbnail    = $img['thumbnail'];
                        ?>
                        <div class="pxl-post--featured hover-imge-effect3">
                            <?php echo wp_kses_post($thumbnail); ?>
                            <?php if($show_button == 'true'): ?>
                                <div class="pxl-post--readmore"></div>
                                <div class="pxl-post--button"><i class="ct-icon-plus fa fa-plus"></i></div>
                                <a class="pxl-post--link" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"></a>
                            <?php endif; ?>
                        </div>
                        <div class="item-overley">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><i class="ct-icon-plus fa fa-plus"></i></a>
                            </div>
                        <div class="pxl-post--holder">
                            <div class="pxl-post--meta">
                                <?php if($show_category == 'true'): ?>
                                    <div class="pxl-post--category link-none">
                                        <?php the_terms( $post->ID, 'portfolio-category', '', ' ' ); ?>
                                    </div>
                                <?php endif; ?>
                                <h5 class="pxl-post--title"><?php echo esc_html(get_the_title($post->ID)); ?></h5>
                            </div>
                            <?php if($show_button == 'true'): ?>
                                <a class="pxl-post--readmore pxl-fl-middle <?php if($button_box_gradient == 'style-2') : ?>pxl-gradient-rotate<?php endif; ?>" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                    <i class="flaticon-right-arrow-2"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach;
    endif;
}

function lawsight_get_portfolio_grid_layout2($posts = [], $settings = []){ 
    extract($settings);
    
    $images_size = !empty($img_size) ? $img_size : '600x600';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && (count($grid_masonry) > 1)) {
                if($grid_masonry[$key]['col_xl_m'] == 'col-66') {
                    $col_xl_m = '66-pxl';
                } else {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                }
                if($grid_masonry[$key]['col_lg_m'] == 'col-66') {
                    $col_lg_m = '66-pxl';
                } else {
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                }
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $img_id = get_post_thumbnail_id($post->ID);
            $portfolio_excerpt = get_post_meta($post->ID, 'portfolio_excerpt', true);
            if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="pxl-post--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s">
                        <?php $img_id = get_post_thumbnail_id($post->ID);
                        $img          = pxl_get_image_by_size( array(
                            'attach_id'  => $img_id,
                            'thumb_size' => $images_size
                        ) );
                        $thumbnail    = $img['thumbnail'];
                        $gradient_from = Lawsight()->get_opt('gradient_color', ['from' => '#6000ff'])['from'];
                        $gradient_to = Lawsight()->get_opt('gradient_color', ['to' => '#fe0054'])['to'];
                        ?>
                        <div class="pxl-post--featured">
                            <div class="item-overley">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><i class="ct-icon-plus fa fa-plus"></i></a>
                            </div>
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                            <?php if($show_button == 'true'): ?>
                                <div class="pxl-post--readmore"></div>
                                <div class="pxl-post--button"><i class="ct-icon-plus fa fa-plus"></i></div>
                                <a class="pxl-post--link" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"></a>
                            <?php endif; ?>
                        </div>
                        <div class="pxl-post--holder">
                            <svg class="pxl-post--angle" xmlns="http://www.w3.org/2000/svg" width="100%" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none"><path stroke="" stroke-width="0" d="M0 100 L100 0 L200 100"></path></svg>
                            <h5 class="pxl-post--title"><?php echo esc_html(get_the_title($post->ID)); ?></h5>
                            <?php if($show_category == 'true'): ?>
                                <div class="pxl-post--category link-none">
                                    <?php the_terms( $post->ID, 'portfolio-category', '', ' ' ); ?>
                                </div>
                            <?php endif; ?>
                            <?php if($show_excerpt == 'true' && !empty($portfolio_excerpt)): ?>
                                <div class="pxl-post--content">
                                    <?php echo wp_trim_words( $portfolio_excerpt, $num_words, $more = null ); ?>
                                </div>
                            <?php endif; ?>
                          
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach;
    endif;
}

// End Portfolio Grid
//--------------------------------------------------

// Start Service Grid
//--------------------------------------------------
function lawsight_get_service_grid_layout1($posts = [], $settings = []){ 
    extract($settings);

    $images_size = !empty($img_size) ? $img_size : '600x472';

    if (is_array($posts)):
        foreach ($posts as $key => $post):
            $item_class = "pxl-grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            if(isset($grid_masonry) && !empty($grid_masonry[$key]) && (count($grid_masonry) > 1)) {
                if($grid_masonry[$key]['col_xl_m'] == 'col-66') {
                    $col_xl_m = '66-pxl';
                } else {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                }
                if($grid_masonry[$key]['col_lg_m'] == 'col-66') {
                    $col_lg_m = '66-pxl';
                } else {
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                }
                $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                $item_class = "pxl-grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                
                $img_size_m = $grid_masonry[$key]['img_size_m'];
                if(!empty($img_size_m)) {
                    $images_size = $img_size_m;
                }
            } elseif (!empty($img_size)) {
                $images_size = $img_size;
            }

            if(!empty($tax))
                $filter_class = pxl_get_term_of_post_to_class($post->ID, array_unique($tax));
            else 
                $filter_class = '';

            $service_external_link = get_post_meta($post->ID, 'service_external_link', true);
            $service_icon_type = get_post_meta($post->ID, 'service_icon_type', true);
            $service_icon_font = get_post_meta($post->ID, 'service_icon_font', true);
            $service_icon_img = get_post_meta($post->ID, 'service_icon_img', true); ?>
            <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                <div class="pxl-post--inner <?php echo esc_attr($pxl_animate); ?>" data-wow-duration="1.2s">
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)):
                        $img_id = get_post_thumbnail_id($post->ID);
                        $img          = pxl_get_image_by_size( array(
                            'attach_id'  => $img_id,
                            'thumb_size' => $images_size
                        ) );
                        $thumbnail    = $img['thumbnail'];
                        ?>
                        <div class="pxl-post--featured">
                            <?php echo wp_kses_post($thumbnail); ?>
                            <?php if($service_icon_type == 'icon' && !empty($service_icon_font)) : ?>
                                <div class="pxl-post--icon pxl-fl-middle">
                                    <i class="<?php echo esc_attr($service_icon_font); ?>"></i>
                                </div>
                            <?php endif; ?>
                            <?php if($service_icon_type == 'image' && !empty($service_icon_img)) : 
                                $icon_img = pxl_get_image_by_size( array(
                                    'attach_id'  => $service_icon_img['id'],
                                    'thumb_size' => 'full',
                                ));
                                $icon_thumbnail = $icon_img['thumbnail'];
                                ?>
                                <div class="pxl-post--icon pxl-fl-middle">
                                    <?php echo wp_kses_post($icon_thumbnail); ?>
                                </div>
                            <?php endif; ?>
                            <a class="pxl-post--link" href="<?php if(!empty($service_external_link)) { echo esc_url($service_external_link); } else { echo esc_url(get_permalink( $post->ID )); } ?>"></a>
                        </div>
                    <?php endif; ?>
                    <div class="pxl-post--holder">
                        <h3 class="pxl-post--title">
                            <a href="<?php if(!empty($service_external_link)) { echo esc_url($service_external_link); } else { echo esc_url(get_permalink( $post->ID )); } ?>"><?php echo esc_html(get_the_title($post->ID)); ?></a>
                        </h3>
                        <?php if($show_button == 'true') : ?>
                            <div class="pxl-post--readmore">
                                <div class="pxl-post--category"><?php the_terms( $post->ID, 'service-category', '', ' ' ); ?></div>
                                <i class="flaticon-long-arrow-right rtl-reverse"></i>
                                <a class="pxl-post--link" href="<?php if(!empty($service_external_link)) { echo esc_url($service_external_link); } else { echo esc_url(get_permalink( $post->ID )); } ?>"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach;
    endif;
}
// End Service Grid
//-------------------------------------------------

// Start Product Grid
//--------------------------------------------------
// End Product Grid
//--------------------------------------------------

add_action( 'wp_ajax_lawsight_load_more_post_grid', 'lawsight_load_more_post_grid' );
add_action( 'wp_ajax_nopriv_lawsight_load_more_post_grid', 'lawsight_load_more_post_grid' );
function lawsight_load_more_post_grid(){
    if ( ! check_ajax_referer( '_ajax_nonce', 'wpnonce' ) || empty( sanitize_text_field( wp_unslash($_POST['wpnonce'] ))) ) {
        wp_send_json(
            array(
                'status' => false,
                'message' => esc_attr__('Nonce error, please reload.', 'Lawsight'),
                'data' => array(),
            )
        );
    }
    
    try{
        if(!isset($_POST['settings'])){
            throw new Exception(__('Something went wrong while requesting. Please try again!', 'Lawsight'));
        }
    
        $settings = isset($_POST['settings']) ? $_POST['settings'] : null;
       
        $source = isset($settings['source']) ? $settings['source'] : '';
        $term_slug = isset($settings['term_slug']) ? $settings['term_slug'] : '';
        if( !empty($term_slug) && $term_slug !='*'){
            $term_slug = str_replace('.', '', $term_slug);
            $source = [$term_slug.'|'.$settings['tax'][0]]; 
        }
        if( isset($_POST['handler_click']) && sanitize_text_field(wp_unslash( $_POST[ 'handler_click' ] )) == 'filter'){
            set_query_var('paged', 1);
            $settings['paged'] = 1;
        }else{
            set_query_var('paged', $settings['paged']);
        }
        extract(pxl_get_posts_of_grid($settings['post_type'], [
                'source' => $source,
                'orderby' => isset($settings['orderby'])?$settings['orderby']:'date',
                'order' => isset($settings['order'])?$settings['order']:'desc',
                'limit' => isset($settings['limit'])?$settings['limit']:'6',
                'post_ids' => isset($settings['post_ids'])?$settings['post_ids']: [],
                'post_not_in' => isset($settings['post_not_in'])?$settings['post_not_in']: [],
            ],
            $settings['tax']
        ));

        ob_start();
            lawsight_get_post_grid($posts, $settings);
        $html = ob_get_clean();

        $pagin_html = '';
        if( isset($settings['pagination_type']) && $settings['pagination_type'] == 'pagination' ){ 
            ob_start();
                Lawsight()->page->get_pagination( $query,  true );
            $pagin_html = ob_get_clean();
        }
        wp_send_json(
            array(
                'status' => true,
                'message' => esc_attr__('Load Successfully!', 'Lawsight'),
                'data' => array(
                    'html' => $html,
                    'pagin_html' => $pagin_html,
                    'paged' => $settings['paged'],
                    'posts' => $posts,
                    'max' => $max,
                ),
            )
        );
    }
    catch (Exception $e){
        wp_send_json(array('status' => false, 'message' => $e->getMessage()));
    }
    die;
}
 