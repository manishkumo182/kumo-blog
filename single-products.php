<?php get_header(); ?>

<?php
if ( have_posts() ) :
while ( have_posts() ) : the_post();

    $product_id = get_the_ID();
    $title      = get_the_title($product_id);
    $content    = get_field('content', $product_id);
    $image      = get_field('image', $product_id);
    $count      = get_field('count', $product_id);
?>

<!-- ================= PRODUCT SECTION ================= -->
<section class="py-24 bg-gray-100">
    <div class="max-w-6xl mx-auto m-8"style="margin-top:10rem;" >

        <div class="bg-white rounded p-8 md:p-16 flex flex-col md:flex-row items-center gap-10">
<?php if ($image): ?>
<div class="flex-shrink-0 w-full md:w-1/3 flex justify-center md:justify-start items-center">
    <?php
    if (is_array($image)) {
        $img_url = $image['url'];
        $img_alt = $image['alt'] ?? $title;
    } elseif (is_string($image)) {
        $img_url = $image;
        $img_alt = $title;
    } elseif (is_numeric($image)) {
        echo wp_get_attachment_image($image, '40', false, [
            'class' => 'rounded-xl w-40 object-contain'
        ]);
        $img_url = null;
    }
    ?>
    <?php if (!empty($img_url)): ?>
        <img src="<?= esc_url($img_url); ?>" alt="<?= esc_attr($img_alt); ?>" class="rounded-xl w-40 object-contain">
    <?php endif; ?>
</div>
<?php endif; ?>


            <div class="flex-1">
                <h1 class="text-4xl font-bold text-gray-900 items-center mb-6">
                    <?= esc_html($title); ?>
                </h1>

                <?php if ($content): ?>
                    <div class="text-gray-700 text-lg leading-relaxed items-center mb-2">
                        <?= wp_kses_post($content); ?>
                    </div>
                <?php endif; ?>

                <?php if ($count): ?>
                    <span class="inline-block  py-2 bg-blue-100 text-blue-700  items-center font-medium rounded-full">
                        <?= esc_html($count); ?> posts
                    </span>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?php endwhile; endif; ?>

<?php
/* ================= RELATED ARTICLES QUERY ================= */

$product_terms = get_the_terms(get_the_ID(), 'feature_category');
$term_ids = [];

if ($product_terms && !is_wp_error($product_terms)) {
    foreach ($product_terms as $term) {
        $term_ids[] = $term->term_id;
    }
}

$related_args = [
    'post_type'      => 'features',
    'posts_per_page' => 2,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
];

// Apply taxonomy ONLY if terms exist
if (!empty($term_ids)) {
    $related_args['tax_query'] = [
        [
            'taxonomy' => 'feature_category',
            'field'    => 'term_id',
            'terms'    => $term_ids,
        ]
    ];
}

$related_query = new WP_Query($related_args);
?>

<!-- ================= RELATED ARTICLES SECTION ================= -->
<?php if ($related_query->have_posts()) : ?>
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <h2 class="text-4xl font-bold text-center mb-14 text-gray-800">
            Related Articles
        </h2>

        <div class="grid grid-cols-1 gap-10">

            <?php while ($related_query->have_posts()) : $related_query->the_post();
                $features_id = get_the_ID();
                $features    = get_field('features', $features_id);

                $f_title   = $features['title'] ?? get_the_title();
                $f_content = $features['content'] ?? '';
                $f_image   = $features['image'] ?? '';
                $f_terms   = get_the_terms($features_id, 'feature_category');
            ?>

            <a href="<?php the_permalink(); ?>" class="block">
                <article class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition p-4 flex gap-6">

                    <div class="w-40 h-32 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                        <?php if ($f_image):
                            if (is_array($f_image)) {
                                $img_url = $f_image['url'];
                                $img_alt = $f_image['alt'] ?? $f_title;
                            } elseif (is_string($f_image)) {
                                $img_url = $f_image;
                                $img_alt = $f_title;
                            } elseif (is_numeric($f_image)) {
                                echo wp_get_attachment_image($f_image, 'medium', false, [
                                    'class' => 'w-full h-full object-cover'
                                ]);
                                $img_url = null;
                            }
                        ?>
                        <?php if (!empty($img_url)): ?>
                            <img src="<?= esc_url($img_url); ?>" alt="<?= esc_attr($img_alt); ?>" class="w-full h-full object-cover">
                        <?php endif; endif; ?>
                    </div>

                    <div class="flex-1">
                        <?php if ($f_terms && !is_wp_error($f_terms)): ?>
                            <div class="mb-2">
                                <?php foreach ($f_terms as $term): ?>
                                    <span class="inline-block mb-2 px-3 py-1 bg-secondary text-white text-xs rounded">
                                        <?= esc_html($term->name); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            <?= esc_html($f_title); ?>
                        </h3>

                        <?php if ($f_content): ?>
                            <p class="text-gray-600 leading-relaxed line-clamp-2">
                                <?= wp_trim_words($f_content, 22, '...'); ?>
                            </p>
                        <?php endif; ?>

                        <div class="text-sm text-gray-400 mt-3">
                            <?= get_the_date('M j, Y'); ?>
                        </div>
                    </div>

                </article>
            </a>

            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php wp_reset_postdata(); endif; ?>

<?php get_footer(); ?>
