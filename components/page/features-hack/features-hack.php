<?php
// Query only posts in the "hack" term
$hack_args = [
    'post_type'      => 'features',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query'      => [
        [
            'taxonomy' => 'feature_category',
            'field'    => 'slug',
            'terms'    => 'hack', // The term slug you want
        ],
    ],
];

$hack_query = new WP_Query($hack_args);
?>

<?php if ($hack_query->have_posts()) : ?>
<section class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-4 text-gray-800">Quick Coding Hacks</h2>
        <h4 class="text-xl text-center mb-14">
               Time Saving Tips and Tricks for Developers
            </h4>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php while ($hack_query->have_posts()) : $hack_query->the_post(); 
                $features_id = get_the_ID();
                
                // Get ACF group fields
                $features_group = get_field('features', $features_id);
                $title   = $features_group['title'] ?? get_the_title();
                $content = $features_group['content'] ?? '';
                $image   = $features_group['image'] ?? '';
            ?>
           <a href="<?php the_permalink(); ?>" class="block">    <article class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
    
    <!-- <?php if ($image): ?>
    <div class="relative">
        <?php
        if (is_array($image)):
            $img_url = $image['url'] ?? '';
            $img_alt = $image['alt'] ?? $title;
        elseif (is_string($image)):
            $img_url = $image;
            $img_alt = $title;
        elseif (is_numeric($image)):
            echo wp_get_attachment_image($image, 'full', false, ['class' => 'w-full h-48 object-cover rounded-t-lg']);
            $img_url = null;
        endif;

        if (!empty($img_url)): ?>
        <img src="<?= esc_url($img_url); ?>" 
             alt="<?= esc_attr($img_alt); ?>" 
             class="w-full h-48 object-cover rounded-t-lg">
        <?php endif; ?>
    </div>
    <?php endif; ?> -->

    <div class="p-6 border-4 border-l-primary">
        <?php
        // Get taxonomy terms for this post
        $post_terms = get_the_terms($features_id, 'feature_category');
        if ($post_terms && !is_wp_error($post_terms)): 
        ?>
        <div class="mb-2">
            <?php foreach ($post_terms as $term): ?>
                <span class="inline-block px-3 mb-2 py-1 bg-gray-100 text-gray-700 text-lg font-semibold rounded">
                    <?= esc_html($term->name); ?>
                </span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Title -->
        <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-2 line-clamp-2">
            <?= esc_html($title); ?>
        </h3>

        <!-- Content -->
        <?php if ($content): ?>
        <div class="text-gray-600 leading-relaxed line-clamp-3">
            <?= wp_trim_words($content, 20, '...'); ?>
        </div>
        <?php endif; ?>

        <p class="text-gray-100 text-sm mb-3 mt-4">
            <?= get_the_date('F j, Y'); ?> at <?= get_the_time('g:i a'); ?>
        </p>
    </div>
</article></a>

            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php wp_reset_postdata(); endif; ?>
