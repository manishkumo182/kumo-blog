<?php
$contact = get_field('contact_form', 'option');
// vdump($contact);
?>

<section id="contact-form">
    <div class="bg-primary">
        <div class="container mx-auto lg:py-28">
            <div class="relative w-full mx-auto lg:px-20 max-w-9xl">

                <div class="grid w-full grid-cols-1 gap-4 lg:grid-cols-5">
                    <div class="col-span-3 pt-20 pb-10 ">
                        <div class="px-12 py-8">
                            <h2 class="pt-12 pb-5 text-xl font-normal text-white uppercase text-stone">
                                <?= $contact['subtitle'] ?>
                            </h2>
                            <h2 class="lg:text-4xl xs:text-2xl text-white font-medium">
                                <?= $contact['title'] ?>
                            </h2>
                            <?= do_shortcode($contact['form']['shortcode']); ?>
                        </div>
                    </div>
                    <div class="relative h-full col-span-2 px-10">
                        <div class="absolute inset-0 z-10 w-full h-full ">
                        </div>
                        <?= get_img($contact['image'], '100vw', ['class' => ' hidden lg:block grayscale object-cover h-full w-full']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>