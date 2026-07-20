<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Query only posts in the "hack" term
$hack_args = [
    'post_type'      => 'features',
    'posts_per_page' => 3, // ✅ show only 3 per page
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'paged'          => $paged, // ✅ pagination
    'tax_query'      => [
        [
            'taxonomy' => 'feature_category',
            'field'    => 'slug',
            'terms'    => 'hack',
        ],
    ],
];

$hack_query = new WP_Query($hack_args);
?>

<?php if ($hack_query->have_posts()) : ?>
<section class="py-20 bg-primary">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20">

        <h2 class="text-4xl font-bold text-center mb-4 text-gray-800"></h2>

        <h4 class="text-4xl text-center text-white mb-14">
            Time Saving Tips and Tricks for Developers
        </h4>

        <!-- ✅ REMOVED SCROLL, CLEAN GRID -->
        <div class="grid grid-cols-1 gap-10 mb-14">

            <?php while ($hack_query->have_posts()) : $hack_query->the_post(); 
                $features_id = get_the_ID();

                // Get ACF group fields
                $features_group = get_field('features', $features_id);
                $title   = $features_group['title'] ?? get_the_title();
                $content = $features_group['content'] ?? '';
                $image   = $features_group['image'] ?? '';
            ?>
            
            <a href="<?php the_permalink(); ?>" class="block">  <article class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="p-6 border-4 border-l-primary">

                    <?php
                    $post_terms = get_the_terms($features_id, 'feature_category');
                    if ($post_terms && !is_wp_error($post_terms)) :
                    ?>
                        <div class="mb-2">
                            <?php foreach ($post_terms as $term): ?>
                                <span class="inline-block px-3 mb-2 py-1 bg-gray-100 text-gray-700 text-lg font-semibold rounded">
                                    <?= esc_html($term->name); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-2 line-clamp-2">
                        <?= esc_html($title); ?>
                    </h3>

                    <?php if ($content): ?>
                        <div class="text-gray-600 leading-relaxed line-clamp-3">
                            <?= wp_trim_words($content, 20, '...'); ?>
                        </div>
                    <?php endif; ?>

                    <p class="text-gray-500 text-sm mb-3 mt-4">
                        <?= get_the_date('F j, Y'); ?> at <?= get_the_time('g:i a'); ?>
                    </p>
                </div>
            </article></a>

            <?php endwhile; ?>
        </div>

        <!-- ✅ PAGINATION (SHOWS ONLY IF MORE THAN 3 POSTS) -->
  <?php if ($hack_query->max_num_pages > 1): ?>
    <div class="mt-14 flex justify-center">
        <?php
        $pagination = paginate_links([
            'total'     => $hack_query->max_num_pages,
            'current'   => $paged,
            'prev_text' => '« Prev',
            'next_text' => 'Next »',
            'type'      => 'array',
        ]);

        if (!empty($pagination)) :
        ?>
            <ul class="flex items-center space-x-3">
                <?php foreach ($pagination as $page): ?>
                    <li>
                        <span class="pagination-item"><?=
                            str_replace(
                                ['page-numbers', 'current'],
                                [
                                    'px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-200 transition',
                                    'px-4 py-2 border border-primary text-white bg-primary rounded-lg font-semibold'
                                ],
                                $page
                            );
                        ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endif; ?>


    </div>
</section>

<?php wp_reset_postdata(); endif; ?>
