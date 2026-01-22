<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="py-10 entry-header">
        <h1 class="text-4xl font-bold text-shade-95 font-heading"><?php the_title(); ?></h1>
    </header>
    <div class="px-6 text-center text-white bg-gray-900">
        <div class="flex items-center justify-start bg-gray-100">
            <div class="max-w-4xl mx-4 overflow-hidden bg-white rounded-md shadow-md md:mx-auto">
                <?= get_img(get_post_thumbnail_id(), '', ['object-cover object-center w-full h-auto']); ?>
            </div>
        </div>
    </div>
    <div class="entry-content">
        <div class="py-10 prose">
            <?php the_content(); ?>
        </div>
    </div>
</article>