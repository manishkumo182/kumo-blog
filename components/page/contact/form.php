<?php
$contact = get_field('contact_form', 'option');
// vdump($contact);
?>


<div class="pt-10">

    <div class="mb-4">
        <label for="Name" class="block text-white text-xl font-regular my-5" for="fullname"> Name </label>

        [text* name class:bg-form class:rounded class:w-full class:text-black
        class:py-3 class:px-3 placeholder "Enter your full name"]
    </div>

    <div class="mb-4">
        <label for="email" class="block text-white text-xl font-regular my-5" for="email">Email Address </label>
        [text* email class:bg-form class:rounded class:w-full class:text-black
        class:py-3 class:px-3 placeholder "Enter your email address"]
    </div>


    <div class="mb-4">
        <label for="Phone" class="block text-white text-xl font-regular my-5" for="phone">Phone Number </label>
        [text* phone class:bg-form class:rounded class:w-full class:text-black placeholder "Enter your Phone Number"]
    </div>



    <div class="mb-4">
        <label for="message" class="block text-white text-xl font-regular my-5" for="message">Message</label>
        [textarea* message class:message class:bg-form class:rounded class:w-full class:text-black class:text-md
        class:py-3 class:px-3]
    </div>



    <div x-data="Acceptance()" class="flex items-center space-x-2">
        <div class="relative" aria-pressed="false" :aria-pressed="checked.toString()" aria-labelledby="privacy-label">
            <!-- Checkbox -->
            [acceptance privacy]
            <div class="transition-opacity bg-skin-dark w-full h-full" :class="checked ? 'opacity-100' : 'opacity-0'">
            </div>
        </div>
        <!-- Text -->
        <span class="text-lg text-white" id="privacy-label">
            By continuing you agree to the <a href="#" target="_blank" class="underline">privacy policy</a>
        </span>


    </div>

    <div class="mt-4 flex flex-col bg-secondary text-white px-8">
        [submit class:rounded class:bg-color class:cursor-pointer class:hover:bg-opacity-80 class:transition class:duration-200 class:text-xl class:py-2 class:px-10 class:text-white class:hover:bg-primary "Submit"]
    </div>

</div>