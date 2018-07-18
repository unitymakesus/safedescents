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
    'public' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'hierarchical' => true,
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
