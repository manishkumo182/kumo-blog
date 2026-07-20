<?php
// WP_Query arguments for Products
$products = get_field('products', 'option'); 

$args = [
    'post_type'      => 'products',  // Your custom post type
    'posts_per_page' => -1,          // Or limit number of products
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
];

$products_query = new WP_Query($args);

if ($products_query->have_posts()) : ?>
<section class="py-20 bg-primary">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20">

        <!-- Section Title -->
        <h2 class="text-center text-4xl font-semibold text-gray-900 mb-14 mt-14">
      
        </h2>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 mt-14">

            <?php while ($products_query->have_posts()) : $products_query->the_post(); 
                $product_id = get_the_ID();

                $title   = get_the_title($product_id);
                $content = get_field('content', $product_id);
                $image   = get_field('image', $product_id);
                $count   = get_field('count', $product_id);
            ?>

            <a href="<?php the_permalink(); ?>" class="block"> 
          <div class="bg-white rounded-2xl p-10 text-center shadow-md hover:shadow-lg transition">

                <!-- Product Image -->
                <?php if ($image): ?>
                    <div class="w-24 h-24 mx-auto flex items-center justify-center rounded-xl border-secondary mb-6">

                        <?php 
                        if (is_array($image)) : // Image Array
                            $img_url = $image['url'] ?? '';
                            $img_alt = $image['alt'] ?? $title;
                        elseif (is_string($image)) : // Image URL
                            $img_url = $image;
                            $img_alt = $title;
                        elseif (is_numeric($image)) : // Image ID
                            echo wp_get_attachment_image($image, 'full', false, ['class' => 'w-16 h-16 object-contain']);
                            $img_url = null; // Already output
                        endif;

                        // Output image if URL available
                        if (!empty($img_url)) : ?>
                            <img src="<?= esc_url($img_url); ?>" alt="<?= esc_attr($img_alt); ?>" class="w-16 h-16 object-contain">
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                <!-- Product Title -->
                <h3 class="text-xl font-semibold text-gray-900 mb-3"><?= esc_html($title); ?></h3>

                <!-- Product Content -->
                <?php if ($content): ?>
                    <p class="text-gray-500 text-sm mb-6"><?= esc_html($content); ?></p>
                <?php endif; ?>

                <!-- Product Count -->
                <?php if ($count): ?>
                    <span class="inline-block px-4 py-1 text-sm bg-gray-100 rounded-full text-gray-700"><?= esc_html($count); ?> posts</span>
                <?php endif; ?>

            </div>

            <?php endwhile; ?>
 </a>
        </div>
   

    </div>
</section>

<?php
wp_reset_postdata(); // Important to reset after WP_Query
endif;
