<?php get_header(); ?>
<section id='single-post-content'>
    <?php
    if (have_posts()) : ?>
        <div class='px-4 my-10 '>
            <div class='container text-ellipsis'>
                <?php while (have_posts()) : the_post();
                    get_template_part('components/generic/content-post');
                endwhile;
            else : ?>
                <div class="py-10 prose">
                    <p><?= __('No posts found','cubit')?></p>
                </div>
                <?php
                ?>
            </div>
        </div>
    <?php endif; ?>
</section>
<?php get_footer(); ?>