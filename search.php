<?php get_header(); ?>

<main id="primary" class="site-main container mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">
        Search Results for: "<?php echo get_search_query(); ?>"
    </h1>

    <?php if (have_posts()) : ?>
        <ul class="space-y-4">
            <?php while (have_posts()) : the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>" class="text-secondary hover:underline">
                        <?php the_title(); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>

        <div class="mt-6">
            <?php
            the_posts_pagination([
                'prev_text' => 'Prev',
                'next_text' => 'Next',
            ]);
            ?>
        </div>

    <?php else : ?>
        <p class="text-gray-500">No results found for "<?php echo get_search_query(); ?>"</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
