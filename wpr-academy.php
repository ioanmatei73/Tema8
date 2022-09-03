<?php

/*
Plugin Name: WPR Academy plugin
Author: Ioan Matei
Version: 1.0.0
Text-domain: wpr-academy
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin URL.
define( 'WPR_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
// Plugin path.
define( 'WPR_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

include_once( WPR_PATH . '/includes/shortcodes.php' );

function search() {
    search_scripts();
    ob_start(); ?>

    <div id="wpr-filter" class="navigation">
    <select id="hobbies">
        <option class="active" value="">All hobbies</option>
        <?php
        $hobbies = get_terms( array(
            'taxonomy'   => 'hobby',
            'hide_empty' => true,
        ) );
        foreach ( $hobbies as $hobby ) {
            ?>
            <option value="<?php echo $hobby->term_id; ?>">
                <?php echo $hobby->name; ?>
            </option>
            <?php
        }
        ?>
    </select>
    
    <input type="text" id="keyword" class="input_search" name="s" placeholder="Search ..." value=""></input>
    
    <?php return ob_get_clean();
}

add_shortcode( 'shortcode_search', 'search' );

add_action( 'wp_ajax_search', 'search_callback' );
add_action( 'wp_ajax_nopriv_search', 'search_callback' );

function search_callback() {
    header( "Content-Type: application/json" );
    $hobbies = $_GET[ 'hobby' ];
    $keyw = $_GET[ 'keyw' ];
    $people = array();

    $eng_search = 
        array(
            'post_type'   => 'engineer',
            'numberposts' => - 1, 
            's' => $keyw, 
            'tax_query' => array(
                array(
                    'taxonomy' => 'hobby',
                    'field' => 'term_id', 
                    'terms' => $hobbies
                )
            )
        );

    $eng = new WP_Query( $eng_search );

    if ( $eng->have_posts() ) {
        while ( $eng->have_posts() ) { 
            $eng->the_post();
            $people[] = array(
                'title'     => get_the_title(),
                'content'   => get_the_content(),
                'img_src'   => wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ),
                'hobby'     => $hobbies
            );
        }
        wp_reset_query();
    }  
    echo wp_json_encode( $people );
    wp_die();
}

function search_scripts() {
    wp_enqueue_script( 'search', WPR_URL . '/assets/search.js', array('jquery'), '1.0', true );
    wp_localize_script( 
        'search', 
        'WPR', 
        array( 
            'ajax_url'   => admin_url( 'admin-ajax.php' ),
            'ajax_nonce' => wp_create_nonce( 'search' ) 
        )
    );
}
