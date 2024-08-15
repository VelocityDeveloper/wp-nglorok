<?php
/**
 * Template Name: App Nglorok Page Template
 *
 * Template for displaying a app.
 *
 * @package wp-nglorok
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html
    <?php language_attributes(); ?>
    <?php 
    if (function_exists('velocitytheme_color_scheme')){
        velocitytheme_color_scheme();
    };
    ?>
>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body>
    <div id="app" class="container-scroller">

        <?php require_once plugin_dir_path( __FILE__ ) . '/partials/app-navbar.php'; ?>

        <div class="container-fluid page-body-wrapper pt-0">

            <?php require_once plugin_dir_path( __FILE__ ) . '/partials/app-sidebar.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <?php
                    while ( have_posts() ) {
                        the_post();
                        the_content();
                    }
                    ?>
                </div>
                
                <?php require_once plugin_dir_path( __FILE__ ) . '/partials/app-footer.php'; ?>
            </div>

        </div>

    </div>
    <?php wp_footer(); ?>
</body>
</html>