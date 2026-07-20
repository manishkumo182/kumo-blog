

<nav class=" navbar mt-5 justify-center z-20 flex-1 hidden w-full xl:flex xl:items-center text-white" x-data="Components.popoverGroup()">
  <?php
  $args = [
    'theme_location' => 'header',
    'a_class' => 'relative px-[1.1rem] py-2 text-[15px] font-normal leading-5 desktop-menu-a transition-colors duration-300',
    'a_active_class' => 'current-menu-item',
    'button_container_class' => 'relative',
    'button_class' => 'inline-flex items-center gap-1 relative px-[1.1rem] py-2 text-[15px] font-normal leading-5 group desktop-menu-button transition-colors duration-300',
    'button_active_class' => '',
    'button_after' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>',
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
