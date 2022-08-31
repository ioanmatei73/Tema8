<?php

function wpr_software_shortcode( $attr ) {

    $arg = shortcode_atts( array(
        'h1' => 'true',
        'background' => 'red',
        'h1_text' => 'Acesta este un shortcode'
    ), 
    $attr );

    ob_start();
    
    ?>
    
    <?php 
    if( 'true' === $arg[ 'h1' ]){ ?><h1><?php echo $arg[ 'h1_text' ]; ?></h1><?php } ?>
    <p style="background-color: <?php echo $arg[ 'background' ] ?>">Lorem ipsum</p>

    <?php

    return ob_get_clean();

}

add_shortcode('software_shortcode', 'wpr_software_shortcode');
