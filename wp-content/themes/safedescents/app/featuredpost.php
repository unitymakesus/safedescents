<?php

namespace App;

/**
 * Adds a meta box to the post editing screen
 */
function prfx_featured_meta() {
    add_meta_box( 'prfx_meta', __( 'Featured Posts', 'prfx-textdomain' ), 'prfx_meta_callback', 'post', 'side', 'high' );
}
add_action( 'add_meta_boxes', __NAMESPACE__. '\\prfx_featured_meta' );
