<?php
$fields = get_field('footer', 'option');
$logo = get_field('site_logo', 'option');
$site_logo = get_field('site_logo', 'option');
$social = get_field('social', 'option');
$contact_information = get_field('contact_information', 'option');
$company_email = get_field('company_email', 'option');
$company_phone = get_field('company_phone', 'option');
$company_address = get_field('company_address', 'option');
$certifications = get_field('certifications', 'option');
?>
</main>

<footer>
    <div class="section bg-primary relative">
        <div class="container relative lg:py-28 sm:py-20 sm:px-10 lg:px-20 z-10 flex justify-center items-center">
            <!-- Grid Layout with 5 Columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 md:gap-12">

                <!-- Column 1: Title, Description, and Contact Information -->
                <div class="flex flex-col">
                    <h2 class="pb-2 font-small text-2xl  text-white whitespace-nowrap">
                        <?= $fields['title'] ?>
                    </h2>
                    <div class="py-2 font-normal text-lg leading-10  text-white">
                        <?= $fields['footer_description']['content'] ?>
                    </div>
                    <!-- <div class="pt-6">
                        <a href="mailto:<?= $company_email ?>" class="flex items-center space-x-3 text-white text-xl">
                            <span><?= $company_email ?></span>
                            <?= get_svg('arr') ?>
                        </a>
                    </div> -->
                </div>
                <!-- Column 2: Contact Information -->
                <div class="flex flex-col text-white text-2xl">
                    <?= $fields['contact_information']['title'] ?>
                    <div class="pt-5 leading-10 text-lg">
                        Address : <span class="  "><?= nl2br($company_address) ?></span><br>
                        Phone : <a href="tel:<?= $company_phone ?>" class="">
                            <span class=""><?= $company_phone ?></span></a><br>
                        Email : <a href="mailto:<?= $company_email ?>" class="">
                            <span class=" "><?= $company_email ?></span>

                        </a>
                       

                    </div>
                </div>

                <!-- Column 4: Menu Links -->
                <div class="flex flex-col text-white text-2xl mb-5">
                    <?= $fields['menu']['title'] ?>
                    <div class="pt-3 leading-10 text-lg">
                        <?php foreach ($fields['menu']['menu_items'] as $menu): ?>
                            <a href="<?= $menu['button']['clone_button']['url'] ?>"
                                class="block hover:text-gray-300"><?= $menu['button']['clone_button']['text'] ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Column 5: Project Section -->
                <div class="flex flex-col text-white text-2xl">
                    <?= $fields['menu_column']['title'] ?>
                    <div class="pt-3 leading-10 text-lg">
                        <?php foreach ($fields['menu_column']['menu_items'] as $menu): ?>
                            <a href="<?= $menu['button']['clone_button']['url'] ?>"
                                class="block hover:text-gray-300"><?= $menu['button']['clone_button']['text'] ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                    <div class="flex flex-col text-white text-2xl">
                    <?= $fields['social']['title'] ?>
                    <div class="pt-5 leading-7 text-lg">
                        <div class="flex space-x-4">
                            <?php foreach ($social as $socials): ?>
                                <a href="<?= $socials['url'] ?>" target="_blank"
                                    class="fill-icon text-white"><?= get_svg($socials['type']) ?></a>
                            <?php endforeach; ?>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
<div class="bg-primary border-t border-white/30 lg:py-8 lg:px-20 flex flex-col justify-center items-center text-white text-center p-5">
    <span>© 2026 Mahadeveloper.com. All rights reserved.</span>

    <p class="text-footer mt-2">
        Technology Partner:
        <a href="https://kumo-labs.com/" target="_blank"><span class="text-secondary font-medium">Kumo Labs Pvt. Ltd.</span></a>
    </p>
</div>
</footer>
<?php wp_footer(); ?>
</body>

</html>