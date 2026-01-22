<?php
$about_detail = get_field('about_detail');
// vdump($about_detail);
?>

<section id="about">
    <div class="bg-primary">
        <div class="container mx-auto py-28 lg:px-28">

            <?php if (!empty($about_detail['title'])): ?>
                <h3 class="text-white text-center font-semibold lg:text-6xl xs:text-2xl py-10">
                    <?= esc_html($about_detail['title']) ?>
                </h3>
            <?php endif; ?>

            <div class="grid gap-8">
                <?php foreach ($about_detail['details'] as $index => $list_item): ?>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                        <?php if ($index % 2 === 0): ?>
                            <!-- Even index: Content on the left, Image on the right -->
                            <div class="p-4">
                                <h3 class="text-white font-semibold lg:text-2xl xs:text-lg lg:pt-20">
                                    <?= esc_html($list_item['title']) ?>
                                </h3>

                                <?php if (!empty($list_item['description'])): ?>
                                    <div class="prose text-white text-xl font-light max-w-none py-3">
                                        <?= wp_kses_post($list_item['description']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="flex justify-center">
                                <?= get_img($list_item['image'], '100vw', ['class' => 'lg:block grayscale object-cover h-full w-full pt-10']) ?>
                            </div>
                        <?php else: ?>
                            <!-- Odd index: Image on the left, Content on the right -->
                            <div class="flex justify-center">
                                <?= get_img($list_item['image'], '100vw', ['class' => 'lg:block grayscale object-cover h-full w-full pt-10']) ?>
                            </div>

                            <div class="p-4">
                                <h3 class="text-white font-semibold lg:text-2xl xs:text-lg pt-20">
                                    <?= esc_html($list_item['title']) ?>
                                </h3>

                                <?php if (!empty($list_item['description'])): ?>
                                    <div class="prose text-white text-xl font-light max-w-none py-3">
                                        <?= wp_kses_post($list_item['description']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>


        </div>
    </div>
</section>