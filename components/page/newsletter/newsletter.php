<?php
$newsletter = get_field('newsletter');
 
$title       = $newsletter['title'] ?? '';
$subtitle    = $newsletter['subtitle'] ?? '';
$placeholder = $newsletter['email_placeholder'] ?? '';
$button_text = $newsletter['button_text'] ?? '';
//  vdump($newsletter);
?>

<section class="bg-secondary py-16">
  <div class="max-w-3xl mx-auto text-center px-6">

    <?php if ($title): ?>
      <h2 class="text-3xl text-white font-semibold mb-8">
        <?= esc_html($title); ?>
      </h2>
    <?php endif; ?>

    <?php if ($subtitle): ?>
      <p class="text-white text-lg mb-8">
        <?= esc_html($subtitle); ?>
      </p>
    <?php endif; ?>

    <form class="flex flex-col sm:flex-row gap-4 justify-center">
      <input
        type="email"
        name="newsletter_email"
        required
        placeholder="<?= esc_attr($placeholder ?: 'Enter your email'); ?>"
        class="w-full sm:w-2/3 px-4 py-3 border rounded-md"
      >

      <button
        type="submit"
        class="bg-primary text-white px-6 py-3 rounded-md hover:bg-white hover:text-secondary" 
      >
        <?= esc_html($button_text ?: 'Subscribe'); ?>
      </button>
    </form>

  </div>
</section>
