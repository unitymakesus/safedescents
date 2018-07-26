<?php

namespace App;

// Team Post Type
function team_post_type() {
	$labels = array(
		'name' => _x("Team", "post type general name"),
		'singular_name' => _x("Team", "post type singular name"),
		'menu_name' => 'Team Profiles',
		'add_new' => _x("Add New", "team item"),
		'add_new_item' => __("Add New Profile"),
		'edit_item' => __("Edit Profile"),
		'new_item' => __("New Profile"),
		'view_item' => __("View Profile"),
		'parent_item_colon' => ''
	);

	register_post_type('team' , array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		'menu_icon' => 'dashicons-admin-users',
		'rewrite' => false,
		'supports' => array('title', 'editor', 'thumbnail')
	) );

  register_taxonomy( strtolower($singular), 'team', array(
    'public' => false,
    'show_ui' => true,
    'show_in_nav_menus' => false,
    'hierarchical' => false,
    'query_var' => true,
    'rewrite' => false,
    'labels' => $labels
  ) );
}

add_action( 'init', __NAMESPACE__.'\\team_post_type' );


// Team post type as shortcode
add_shortcode('team', function() {
	$team = new \WP_Query([
		'post_type' => 'team',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
	]);

  ob_start();
	if ($team->have_posts()) :
		echo '<section class="team row">';
		while ($team->have_posts()) : $team->the_post();
		?>
      <article id="<?php echo $post->ID?>" class="teammember col-xs-12 col-md-6" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post_id, 'large' ); ?>);">
          <div class="teammember-name">
            <h5><?php echo the_title(); ?></h5>
          </div>
          <div class="teammember-content">
            <?php echo the_content(); ?>
          </div>
      </article>
    <?php
		endwhile;

		echo '</div>';

	endif; wp_reset_postdata();

	return ob_get_clean();
});

function sdpolicy_register_order_type() {
    $labels = array(
        'name' => __('Orders', 'safe-descents'),
        'singular_name' => __('Order', 'safe-descents'),
        'menu_name' => __('Policy Orders', 'safe-descents'),
        'name_admin_bar' => __('Order', 'safe-descents'),
        'add_new' => __('Add New', 'safe-descents'),
        'add_new_item' => __('Add New Order', 'safe-descents'),
        'new_item' => __('New Order', 'safe-descents'),
        'edit_item' => __('Edit Order', 'safe-descents'),
        'view_item' => __('View Order', 'safe-descents'),
        'all_items' => __('All Orders', 'safe-descents'),
        'search_items' => __('Search Orders', 'safe-descents'),
        'parent_item_colon' => __('Parent Orders:', 'safe-descents'),
        'not_found' => __('No Orders found.', 'safe-descents'),
        'not_found_in_trash' => __('No orders found in Trash.', 'safe-descents')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => false,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => 'editor'
    );

    register_post_type('sdpolicy_order', $args);
}
add_action( 'init', __NAMESPACE__.'\\sdpolicy_register_order_type' );

function sdpolicy_order_columns($columns) {
    unset($columns['title']);
    unset($columns['date']);
    $edited_columns = array(
        'title' => __('Order', 'safe-descents'),
        'txn_id' => __('Transaction ID', 'safe-descents'),
        'name' => __('Name', 'safe-descents'),
        'email' => __('Email', 'safe-descents'),
        'amount' => __('Total', 'safe-descents'),
        'date' => __('Date', 'safe-descents')
    );
    return array_merge($columns, $edited_columns);
}
add_filter('manage_wpstripeco_order_posts_columns', __NAMESPACE__ . '\\sdpolicy_order_columns');

function sdpolicy_custom_column($column, $post_id) {
    switch ($column) {
        case 'title' :
            echo $post_id;
            break;
        case 'txn_id' :
            echo get_post_meta($post_id, '_txn_id', true);
            break;
        case 'name' :
            echo get_post_meta($post_id, '_name', true);
            break;
        case 'email' :
            echo get_post_meta($post_id, '_email', true);
            break;
        case 'amount' :
            echo get_post_meta($post_id, '_amount', true);
            break;
    }
}
add_action('manage_wpstripeco_order_posts_custom_column', __NAMESPACE__ . '\\sdpolicy_custom_column', 10, 2);

function sdpolicy_save_meta_box_data($post_id) {
    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */
    // Check if our nonce is set.
    if (!isset($_POST['wpstripecheckout_meta_box_nonce'])) {
        return;
    }
    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['wpstripecheckout_meta_box_nonce'], 'wpstripecheckout_meta_box')) {
        return;
    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }
}
add_action('save_post', __NAMESPACE__ . '\\sdpolicy_save_meta_box_data');
