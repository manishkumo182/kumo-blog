<?php $fields = get_field('info'); ?>
<section id='generic-content'>
    <div class='px-4 py-20 my-10 '>
        <div class='container text-2xl text-ellipsis'>
            <h2 class="text-xs font-medium tracking-wider text-red-600 uppercase"><?= $fields['subtitle']; ?></h2>

            <h1 class="text-4xl font-bold text-shade-95 font-heading"><?= $fields['title']; ?></h1>

            <div class="py-10 prose">
                <?= $fields['content']; ?>
            </div>
        </div>
    </div>
</section>