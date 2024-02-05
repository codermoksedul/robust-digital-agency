<?php get_header(); ?>

<div id="content">

    <?php
    // Start the Loop
    while (have_posts()) : the_post();

        // Include the Post content
        get_template_part('template-parts/content', get_post_format());

    endwhile;
    ?>

</div>

<?php get_footer(); ?>
