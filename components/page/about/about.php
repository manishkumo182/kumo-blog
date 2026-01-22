<?php
$about = get_field('about');

?>
<section id="about ">
    <div class="bg-primary">
        <div class="container mx-auto py-28"> <!-- Adjust max-w to your preference -->
            <div class="flex flex-col lg:flex-row items-center">
                <!-- Left Column: Title, Content, and Button -->
                <div class="lg:w-1/2 relative lg:h-[40rem]">
                    <?= get_img($about['image'], '100vw', ['class' => 'absolute inset-y-0 left-0 object-contain w-full lg:h-96']) ?>
                </div>
                <div class="lg:w-3/4 m-8 lg:mb-0 text-center lg:text-left">
                    <?php if (!empty($about['title'])): ?>
                        <h3 class="text-white font-semibold xl:text-8xl lg:text-6xl xs:text-2xl py-2">
                            <?= esc_html($about['title']) ?>
                        </h3>
                    <?php endif; ?>

                    <?php if (!empty($about['content'])): ?>
                        <div class="prose text-white  text-lg font-light max-w-none py-10">
                            <?= wp_kses_post($about['content']) ?>
                        </div>
                    <?php endif; ?>

                    <div class="lg:pb-20 text-black">
                        <?php
                        $button = $about['button']['clone_button'];
                        $button_styles = [
                            'size' => 'lg',
                            'button_type' => 'secondary',
                            'class' => 'flex-initial  py-4',
                            'attr' => 'text-nowrap !max-w-max !h-full items-center',
                            'icon' => 'arr',
                        ];
                        get_global_component_button($button, $button_styles);
                        ?>

                    </div>
                    <div class="flex">


                        <?= get_img($about['image'], '100vw', ['class' => 'object-contain lg:h-80']) ?>
                    </div>
                </div>

                <!-- Right Column: Image -->
                <div class="lg:w-2/4 flex relative">
                    <!-- Image Section -->
                    <?= get_img($about['image'], '100vw', ['class' => 'object-contain lg:h-56 relative z-10']) ?>

                    <!-- Box Content: Half under image and extending from top to bottom -->
                    <div
                        class="box-content h-48 w-28 p-4 border-2 absolute top-16 left-36 transform -translate-x-1/2 lg:-translate-x-1/4 z-0">
                        <!-- Box content here -->
                    </div>
                </div>



            </div>
        </div>
    </div>
</section>