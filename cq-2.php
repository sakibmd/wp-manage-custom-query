<!-- Custom query (WP Query) -->
<?php
/**
 * Template Name: Custom Query WP Query
 */
?>
<div>Custom Query Template</div>

<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1; //for paginate
$totalPost = array(15, 17, 19, 21, 23);
$posts_per_page = 2;
// $_p = new WP_Query(array(
//     'posts_per_page' => $posts_per_page,
//     'post__in' => $totalPost,
//     'orderby' => 'post__in',
//     'paged' => $paged,
// ));

// $_p = new WP_Query(array(   //category wise post show
//     'paged' => $paged,
//     'posts_per_page' => $posts_per_page,
//     'category_name' => 'mango',
//     'orderby' => array('date' => 'ASC'),

// ));

// $_p = new WP_Query(array(   //relationship
//     'paged' => $paged,
//     'posts_per_page' => $posts_per_page,
//     'orderby' => array('date' => 'ASC'),
//     'tax_query' => array(
//         'relation' => 'OR',
//         array(
//             'taxonomy' => 'category',
//             'field' => 'slug',
//             'terms' => array('mango'),
//         ),
//         array(
//             'taxonomy' => 'post_tag',
//             'field' => 'slug',
//             'terms' => array('flower'),
//         ),
//     ),

// ));

// $_p = new WP_Query(array(    //filter using post_format
//     'paged' => $paged,
//     'posts_per_page' => $posts_per_page,
//     'tax_query' => array(
//         array(
//             'taxonomy' => 'post_format',
//             'field' => 'slug',
//             'terms' => array(
//                 'post-format-audio',
//             ),
//             //'operator' => 'NOT IN'     //uporer format bad diye baki gulo output dibe -- (operatior use korle)
//         )
//     )

// ));

// $_p = new WP_Query(array(    //filter using single metabox value || used to show post in specfic page
//     'paged' => $paged,
//     'posts_per_page' => $posts_per_page,
//    'meta_key' => 'excerpt_is_featured',
//    'meta_value' => '1'

// ));

$_p = new WP_Query(array( //filter using multiple metabox value || used to show post in specfic page //https://rudrastyh.com/wordpress/meta_query.html
    'paged' => $paged,
    'posts_per_page' => $posts_per_page,
    'meta_key' => 'excerpt_is_featured',
    'meta_value' => '1',
    'meta_query' => array(
        'relation' => 'AND', // both of below conditions must match
        array(
            'key' => 'excerpt_is_featured',
            'value' => '1',
            'compare' => '=',
        ),
        array(
            'key' => 'excerpt_is_homepage',
            'value' => '1',
            'compare' => '=',
        ),
    ),

));

while ($_p->have_posts()) {
    $_p->the_post();
    ?>
    <h2><a href="<?php the_permalink()?>"><?php the_title()?></a></h2>
    <p><?php the_content()?></p>
    <?php
}
wp_reset_query();

?>

<hr>
<?php
echo paginate_links(array(
    'total' => $_p->max_num_pages,
    'current' => $paged,
));
?>