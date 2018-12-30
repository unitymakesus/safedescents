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
}

add_action( 'init', __NAMESPACE__.'\\team_post_type' );

// Partner Post Type
function partner_post_type() {
	$labels = array(
		'name' => _x("Partner", "post type general name"),
		'singular_name' => _x("Partner", "post type singular name"),
		'menu_name' => 'Partners',
		'add_new' => _x("Add New", "partner item"),
		'add_new_item' => __("Add New Partner"),
		'edit_item' => __("Edit Partner"),
		'new_item' => __("New Partner"),
		'view_item' => __("View Partner"),
		'parent_item_colon' => ''
	);

	register_post_type('partner' , array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		'menu_icon' => 'dashicons-groups',
		'rewrite' => false,
        'show_in_rest' => true,
        'rest_base' => 'partner-api',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
		'supports' => array('title', 'editor', 'thumbnail')
	) );
}

add_action( 'init', __NAMESPACE__.'\\partner_post_type' );


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
        'public' => false,
        'show_ui' => true,
        'query_var' => false,
        'rewrite' => false,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
				'show_in_menu' => true,
				'show_in_admin_bar' => false,
				'menu_icon' => 'dashicons-cart',
				'supports' => array('title', 'custom-fields')
    );

    register_post_type('sdpolicy_order', $args);
}
add_action( 'init', __NAMESPACE__.'\\sdpolicy_register_order_type' );

function sdpolicy_order_columns($columns) {
    unset($columns['title']);
    unset($columns['date']);
    $edited_columns = array(
        'title' => __('Order', 'safe-descents'),
        'name' => __('Purchaser', 'safe-descents'),
        'email' => __('Email', 'safe-descents'),
        'amount' => __('Total', 'safe-descents'),
        'date' => __('Date', 'safe-descents')
    );
    return array_merge($columns, $edited_columns);
}
add_filter('manage_sdpolicy_order_posts_columns', __NAMESPACE__ . '\\sdpolicy_order_columns');

function sdpolicy_custom_column($column, $post_id) {
    switch ($column) {
        case 'title' :
            echo $post_id;
            break;
        case 'name' :
            $purchaser = json_decode(get_post_meta($post_id, 'purchaser', true));
						echo $purchaser->first_name . ' ' . $purchaser->last_name;
            break;
        case 'email' :
						$purchaser = json_decode(get_post_meta($post_id, 'purchaser', true));
						echo $purchaser->email;
            break;
        case 'amount' :
            echo get_post_meta($post_id, 'transaction_amount', true);
            break;
    }
}
add_action('manage_sdpolicy_order_posts_custom_column', __NAMESPACE__ . '\\sdpolicy_custom_column', 10, 2);
