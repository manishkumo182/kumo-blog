<?php
$banner = get_field('banner') ?? [];
$bg     = $banner['background'] ?? [];

$bg_desktop = $bg['desktop'] ?? null;
$title      = $bg['title'] ?? '';
$subtitle   = $bg['subtitle'] ?? '';
$button1    = $bg['primary_button']['clone_button'] ?? null;
$button2    = $bg['secondary_button']['clone_button'] ?? null;
?>

<section id="banner" class="relative min-h-screen overflow-hidden">

    <?php if ($bg_desktop): ?>

        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <?= wp_get_attachment_image(
                $bg_desktop,
                'full',
                false,
                ['class' => 'w-full h-full object-cover']
            ); ?>
        </div>

        <!-- Overlay (THIS WAS MISSING / WRONG z-index) -->
        <div class="absolute inset-0 bg-primary opacity-60"></div>

    <?php endif; ?>

    <!-- Content -->
    <div class="relative z-30 min-h-screen flex flex-col justify-center items-center text-center px-6 space-y-6">
        <?php if ($title): ?>
            <h1 class="text-white text-4xl lg:text-6xl max-w-xl font-medium">
                <?= esc_html($title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($subtitle): ?>
            <p class="text-white text-2xl max-w-3xl">
                <?= esc_html($subtitle); ?>
            </p>
        <?php endif; ?>

        <!-- Buttons -->
        <div class="flex flex-wrap justify-center gap-4 mt-4">
            <?php
            if (is_array($button1)) {
                $button1['link'] = get_permalink(get_page_by_path('categories'));
                get_global_component_button($button1, [
                    'size' => 'lg',
                    'button_type' => 'secondary',
                    'class' => 'bg-secondary z-10 text-white rounded-[10px] px-6 py-3 transition hover:scale-105',
                ]);
            }

            if (is_array($button2)) {
                $button2['link'] = get_permalink(get_page_by_path('about'));
                get_global_component_button($button2, [
                    'size' => 'lg',
                    'button_type' => 'outline',
                    'class' => 'border text-secondary bg-white rounded-[10px] px-6 py-3 hover:bg-secondary hover:text-white',
                ]);
            }
            ?>
        </div>
    </div>

</section>
