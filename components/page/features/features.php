<?php
// Get current taxonomy term if filtering
$current_term = isset($_GET['feature_cat']) ? sanitize_text_field($_GET['feature_cat']) : '';

$args = [
    'post_type'      => 'features',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
];

// Add taxonomy query if term is selected
if ($current_term) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'feature_category',
            'field'    => 'slug',
            'terms'    => $current_term,
        ],
    ];
}
// DEBUG: Check if taxonomy exists and has terms
$debug_terms = get_terms([
    'taxonomy'   => 'feature_category',
    'hide_empty' => false,
]);

// Uncomment the next 3 lines to see debug info
// echo '<pre>Debug Terms: ';
// print_r($debug_terms);
// echo '</pre>';

// Get current taxonomy term if filtering
$current_term = isset($_GET['feature_cat']) ? sanitize_text_field($_GET['feature_cat']) : '';

$args = [
    'post_type'      => 'features',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
];

// Add taxonomy query if term is selected
if ($current_term) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'feature_category',
            'field'    => 'slug',
            'terms'    => $current_term,
        ],
    ];
}

$features_query = new WP_Query($args);

// Get all taxonomy terms for filter (only non-empty)
$terms = get_terms([
    'taxonomy'   => 'feature_category',
    'hide_empty' => true, // Only show categories that have posts
]);
?>

<?php if ($features_query->have_posts()) : ?>
<section id ="feature" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-14 text-gray-800">Features Articles</h2>
        
        <!-- Taxonomy Filter -->
        <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
        <div class="flex flex-wrap justify-center gap-4 mb-14 mt-4">
            <a href="<?= esc_url(remove_query_arg('feature_cat')); ?>" 
               class="px-6 py-2 rounded-lg font-medium transition <?= empty($current_term) ? 'bg-secondary text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300'; ?>">
                All
            </a>
            <?php foreach ($terms as $term) : ?>
            <a href="<?= esc_url(add_query_arg('feature_cat', $term->slug)); ?>" 
               class="px-6 py-2 rounded-lg font-medium transition <?= ($current_term === $term->slug) ? 'bg-secondary text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300'; ?>">
                <?= esc_html($term->name); ?> (<?= $term->count; ?>)
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- Debug: No terms found -->
        <div class="text-center mb-8 p-4 bg-yellow-100 border border-yellow-300 rounded">
            <p class="text-sm text-yellow-800">
                No categories found. Please add categories and assign them to your feature posts.
            </p>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php while ($features_query->have_posts()) : $features_query->the_post(); 
                $features_id = get_the_ID();
                
                // Get ACF group fields
                $features_group = get_field('features', $features_id);
                $title   = $features_group['title'] ?? get_the_title();
                $content = $features_group['content'] ?? '';
                $image   = $features_group['image'] ?? '';
                
                // Get taxonomy terms for this post
                $post_terms = get_the_terms($features_id, 'feature_category');
            ?>
             <a href="<?php the_permalink(); ?>" class="block">  <article class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <!-- Image -->
                <?php if ($image): ?>
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
                    
                    <!-- Taxonomy Badge on Image -->
                    <?php if ($post_terms && !is_wp_error($post_terms)): ?>
                    <div class="absolute top-4 left-4">
                        <span class="inline-block px-3 py-1 bg-secondary text-white text-xs font-semibold rounded-lg">
                            <?= esc_html($post_terms[0]->name); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="p-6">
                    
                    <!-- Taxonomy Terms (if no image) -->
                    <?php if (!$image && $post_terms && !is_wp_error($post_terms)): ?>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <?php foreach ($post_terms as $term): ?>
                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">
                            <?= esc_html($term->name); ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Title -->
                    <?php if ($title): ?>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                        <?= esc_html($title); ?>
                    </h3>
                    <?php endif; ?>

                    <!-- Content -->
                    <?php if ($content): ?>
                    <div class="text-gray-600 leading-relaxed line-clamp-3">
                        <?= wp_trim_words($content, 20, '...'); ?>
                    </div>
                    <?php endif; ?>

                    <!-- Read More Link -->
                    <p class="text-[#50d71e] text-sm mb-3 mt-4">
                        <?= get_the_date('F j, Y'); ?> at <?= get_the_time('g:i a'); ?>
                    </p>

                </div>
            </article></a>
            <?php endwhile; ?>
        </div>

        <!-- View All Button -->
        <div class="text-center mt-16">
             <a href="#" 
   class="inline-block px-12 py-3 border-2 border-secondary text-secondary rounded-lg font-medium hover:bg-secondary hover:text-white transition">
    View All Features
</a>

        </div>
    </div>
</section>
<?php
    wp_reset_postdata();
else: ?>
<p class="text-center text-gray-500 py-10">
    <?php _e('No features found.', 'textdomain'); ?>
</p>
<?php endif; ?>