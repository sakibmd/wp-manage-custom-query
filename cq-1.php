<!-- Custom query (get_posts()) -->
<?php
/**
 * Template Name: Custom Query
 */
?>
<div>Custom Query Template</div>

<?php
$paged = get_query_var('paged') ?? 1; //for paginate
$totalPost = array(15,17,19,21,23);
$posts_per_page = 3;
$_p = get_posts(array(
    'posts_per_page' => $posts_per_page,
    'post__in' => $totalPost,
    'orderby' => 'post__in',
    'paged' => $paged,
));
foreach ($_p as $post) {
    setup_postdata($post);
    ?>
    <h2><a href="<?php the_permalink()?>"><?php the_title()?></a></h2>
    <?php
}
wp_reset_postdata();

?>

<hr>
<?php
echo paginate_links(array(
    'total' => ceil(count($totalPost) / $posts_per_page),
));
?>