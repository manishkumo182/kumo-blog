<?php get_header(); ?>

<?php
if (have_posts()) : while (have_posts()) : the_post();

    $features_id = get_the_ID();

    // Get ACF group fields
    $features_group = get_field('features', $features_id);
    $title   = $features_group['title'] ?? get_the_title();
    $content = $features_group['content'] ?? '';
    $image   = $features_group['image'] ?? '';

    // Get taxonomy terms for this post
    $post_terms = get_the_terms($features_id, 'feature_category');
?>
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto p-6 lg:px-8" style="margin-top:4rem;">
        <!-- Category -->
        <?php if ($post_terms && !is_wp_error($post_terms)) : ?>
            <div class="mb-4 flex flex-wrap gap-2">
                <?php foreach ($post_terms as $term) : ?>
                    <span class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full">
                        <?= esc_html($term->name); ?>
                    </span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Title -->
        <h1 class="text-4xl font-bold text-gray-900 mb-6">
            <?= esc_html($title); ?>
        </h1>

        <!-- Featured Image -->
        <?php if ($image) : ?>
        <div class="mb-8 w-full h-96 rounded-lg overflow-hidden bg-gray-200">
            <?php
            if (is_array($image)) {
                $img_url = $image['url'] ?? '';
                $img_alt = $image['alt'] ?? $title;
                if ($img_url) {
                    echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($img_alt) . '" class="w-full h-full object-cover rounded-lg">';
                }
            } elseif (is_numeric($image)) {
                echo wp_get_attachment_image($image, 'large', false, [
                    'class' => 'w-full h-full object-cover rounded-lg'
                ]);
            } elseif (is_string($image)) {
                echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '" class="w-full h-full object-cover rounded-lg">';
            }
            ?>
        </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="prose prose-lg prose-gray max-w-none mb-10">
            <?= wp_kses_post($content); ?>
        </div>

        <!-- Meta -->
        <div class="text-sm text-gray-500 flex flex-wrap gap-3 mt-4">
            <?= get_the_date('F j, Y'); ?> at <?= get_the_time('g:i a'); ?>
        </div>

        <!-- Back Button -->
        <div class="mt-10">
            <a href="<?= esc_url(get_post_type_archive_link('features')); ?>" class="inline-block px-6 py-4 bg-secondary text-white rounded-full hover:text-black transition">
                ← Back to Features
            </a>
        </div>
    </div>
</section>

<?php
// ---------------- Related Articles ----------------
$current_id = get_the_ID();
$current_terms = wp_get_post_terms($current_id, 'feature_category', ['fields' => 'ids']);

if ($current_terms && !is_wp_error($current_terms)):
    $related_args = [
        'post_type'      => 'features',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'post__not_in'   => [$current_id],
        'orderby'        => 'date',
        'order'          => 'DESC',
        'tax_query'      => [
            [
                'taxonomy' => 'feature_category',
                'field'    => 'term_id',
                'terms'    => $current_terms,
            ],
        ],
    ];

    $related_query = new WP_Query($related_args);

    if ($related_query->have_posts()):
?>
<section class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center" style="margin-bottom:4rem;">Related Articles</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php while ($related_query->have_posts()) : $related_query->the_post();
                $related_id = get_the_ID();
                $related_group = get_field('features', $related_id);
                $r_title   = $related_group['title'] ?? get_the_title();
                $r_content = $related_group['content'] ?? '';
                $r_image   = $related_group['image'] ?? '';
                $r_terms   = get_the_terms($related_id, 'feature_category');
            ?>
            <a href="<?= get_the_permalink(); ?>" class="block group">
                <article class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                    <?php if ($r_image): ?>
                    <div class="relative h-48 w-full overflow-hidden bg-gray-200">
                        <?php
                        if (is_array($r_image)):
                            $r_img_url = $r_image['url'] ?? '';
                            $r_img_alt = $r_image['alt'] ?? $r_title;
                        elseif (is_string($r_image)):
                            $r_img_url = $r_image;
                            $r_img_alt = $r_title;
                        elseif (is_numeric($r_image)):
                            echo wp_get_attachment_image($r_image, 'medium', false, [
                                'class' => 'w-full h-full object-cover transition-transform duration-300 group-hover:scale-105'
                            ]);
                            $r_img_url = null;
                        endif;

                        if (!empty($r_img_url)): ?>
                            <img src="<?= esc_url($r_img_url); ?>" 
                                 alt="<?= esc_attr($r_img_alt); ?>" 
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <?php endif; ?>

                        <?php if ($r_terms && !is_wp_error($r_terms)): ?>
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-secondary text-white text-xs font-semibold rounded-lg">
                                <?= esc_html($r_terms[0]->name); ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                            <?= esc_html($r_title); ?>
                        </h3>
                        <p class="text-gray-600 text-sm line-clamp-3">
                            <?= wp_trim_words($r_content, 18, '...'); ?>
                        </p>
                        <p class="text-gray-400 text-xs mt-3">
                            <?= get_the_date('F j, Y'); ?>
                        </p>
                    </div>
                </article>
            </a>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php
    wp_reset_postdata();
    endif;
endif;
?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
