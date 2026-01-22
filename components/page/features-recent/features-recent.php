<?php
// Recent feature posts query
$recent_args = [
    'post_type'      => 'features',
    'posts_per_page' => 2, // Number of recent posts to show
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
];

$recent_query = new WP_Query($recent_args);
?>

<?php if ($recent_query->have_posts()) : ?>
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-14 text-gray-800">Recent Posts</h2>

        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-10">
            <?php while ($recent_query->have_posts()) : $recent_query->the_post();
                $features_id = get_the_ID();
                
                // Get ACF group fields
                $features_group = get_field('features', $features_id);
                $title   = $features_group['title'] ?? get_the_title();
                $content = $features_group['content'] ?? '';
                $image   = $features_group['image'] ?? '';
                
                // Get taxonomy terms for this post
                $post_terms = get_the_terms($features_id, 'feature_category');
            ?>
     <a href="<?php the_permalink(); ?>" class="block">  <article class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition p-4 flex gap-6">


    <!-- Left Image -->
    <div class="w-40 h-32 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
        <?php if ($image): ?>
            <?php
            if (is_array($image)) {
                $img_url = $image['url'] ?? '';
                $img_alt = $image['alt'] ?? $title;
            } elseif (is_string($image)) {
                $img_url = $image;
                $img_alt = $title;
            } elseif (is_numeric($image)) {
                echo wp_get_attachment_image($image, 'medium', false, [
                    'class' => 'w-full h-full object-cover'
                ]);
                $img_url = null;
            }
            ?>

            <?php if (!empty($img_url)): ?>
                <img src="<?= esc_url($img_url); ?>"
                     alt="<?= esc_attr($img_alt); ?>"
                     class="w-full h-full object-cover">
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Right Content -->
    <div class="flex-1">

        <!-- Category -->
        <?php if ($post_terms && !is_wp_error($post_terms)): ?>
            <div class="mb-2">
                <?php foreach ($post_terms as $term): ?>
                    <span class="inline-block mb-3 px-3 py-1 bg-secondary text-white text-xs font-semibold rounded">
                        <?= esc_html($term->name); ?>
                    </span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Title -->
        <h3 class="text-xl font-semibold text-gray-900 mb-2">
            <?= esc_html($title); ?>
        </h3>

        <!-- Content -->
        <?php if ($content): ?>
            <p class="text-gray-600 leading-relaxed mb-4 line-clamp-2">
                <?= wp_trim_words($content, 22, '...'); ?>
            </p>
        <?php endif; ?>

        <!-- Meta -->
        <div class="text-sm text-gray-400 flex gap-3">
            <span><?= get_the_date('M j, Y'); ?></span>
            <span>•</span>
            <span>4 min read</span>
        </div>

    </div>
</article></a>

            <?php endwhile; ?>
        </div>

       

    </div>
</section>
<?php wp_reset_postdata(); endif; ?>
