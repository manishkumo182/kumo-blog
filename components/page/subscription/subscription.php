<?php
$subscription = get_field('subscription_form', 'option');

?>

<section class="bg-secondary py-16">
  <div class="max-w-3xl mx-auto text-center px-6">

            <h2 class="text-4xl text-white font-semibold mb-8">
                <?= $subscription['title'] ?>
            </h2>
            <h2 class="pb-10 text-xl text-center font-normal text-white  text-stone">
                <?= $subscription['subtitle'] ?>
            </h2>

            <div class="max-w-3xl w-full mx-auto px-4"> <!-- Added max width and padding for smaller width -->
                <?= do_shortcode($subscription['form']['shortcode']); ?>
            </div>
        </div>

</section>