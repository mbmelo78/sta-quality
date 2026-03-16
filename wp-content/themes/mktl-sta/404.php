<?php
/**
 * @package Case-Themes
 */
get_header(); ?>
<div class="container">
    <div class="row content-row">
        <div id="pxl-content-area" class="pxl-content-area col-12">
            <main id="pxl-content-main" class="pxl-text-center">
                <div class="pxl-error-inner bg-image">
                    <h3 class="pxl-error-title">
                        <?php echo esc_html__('Oops! Page Not Found!', 'Lawsight'); ?>
                    </h3>
                    <div class="pxl-heading">
                        <div class="pxl-gap">
				            <span>
					            <i></i><i></i><i></i><i></i>
				            </span>
                        </div>
                    </div>
                    <p class ="p-error" >Sorry, we can’t seem to find what you’re looking for.</p>
                    <div class="pxl-error-image"><img src="<?php echo esc_url(get_template_directory_uri().'/assets/img/image--404.png'); ?>" /></div>
                    <a class="btn" href="<?php echo esc_url(home_url('/')); ?>">
                        <span class="pxl--btn-text"><?php echo esc_html__('GO HOME NOW', 'Lawsight'); ?></span>
                    </a>
                </div>
            </main>
        </div>
    </div>
</div>
<?php get_footer();
