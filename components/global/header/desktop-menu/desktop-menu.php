

<nav class=" navbar mt-5 justify-center z-20 flex-1 hidden w-full xl:flex xl:items-center text-white" x-data="Components.popoverGroup()">
  <?php
  $args = [
    'theme_location' => 'header',
    'a_class' => 'relative text-primary px-6 py-4 mt-5 text-xl font-regular leading-5 after:content-[\'\'] after:absolute after:bottom-1 after:left-1/2 after:-translate-x-1/2 after:w-0 hover:after:w-[calc(100%-32px)] after:h-px after:bg-current after:transition-all desktop-menu-a transition-colors duration-',
    'a_active_class' => 'after:w-[calc(100%-32px)]',
    'button_container_class' => 'relative',
    'button_class' => 'inline-flex gap-2 relative px-4 py-4 text-sm font-medium leading-5 after:content-[\'\'] after:absolute after:bottom-1 after:left-1/2 after:-translate-x-1/2 after:w-0 hover:after:w-[calc(100%-32px)] after:h-px after:bg-current after:transition-all group desktop-menu-button transition-colors duration-',
    'button_active_class' => 'after:w-[calc(100%-32px)]',
    'sub_menu_class' => 'absolute text-stone-900 z-20 ml-[-26px] top-full p-3 w-screen max-w-xs overflow-hidden bg-skin-light bg-stone-100 flex flex-col items-start rounded',
    'sub_menu_a_class' => 'relative w-full max flex justify-between align-middle p-3 text-sm leading-5 hover:font-medium after:content-[\'\'] after:absolute after:bottom-1.5 after:left-5 after:w-0 hover:after:w-[calc(50%-40px)] after:h-px after:bg-current after:transition-all',
    'sub_menu_a_active_class' => 'font-medium after:w-[calc(50%-40px)]',
    'sub_menu_1_a_class' => 'ml-4',
  ];

  if (has_nav_menu('header')) :
      wp_nav_menu([
          'theme_location' => 'header',
          'container' => false,
          'walker' => class_exists('Tailwind_Nav_Walker') ? new Tailwind_Nav_Walker($args) : '',
      ]);
  endif;
  ?>
</nav>
