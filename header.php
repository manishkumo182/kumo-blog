<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
  <!-- Canonical URL -->
  <?php if (is_singular()): ?>
    <link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>">
  <?php endif; ?>
  <link rel="profile" href="https://gmpg.org/xfn/11" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php
  $logo = get_field('site_logo', 'option');
  // vdump($logo);
  $header = get_field('header', 'option');
  $company_phone = get_field('company_phone', 'option');
  // vdump($company_phone);
  ?>

  <style>
    [x-cloak] {
      display: none;
    }


/* Desktop header menu */
/* Main Navigation Container */
.navbar {
    display: flex;
    justify-content: center;
    align-items: center;
    flex: 1;
    width: 100%;
    color: #fff;
    z-index: 20;
    gap: 2rem;
    font-size: 15px;
}

/* Hide on mobile, show on XL screens */
@media (max-width: 1279px) {
    .navbar {
        display: none;
    }
}

@media (min-width: 1280px) {
    .navbar {
        display: flex;
    }
}

/* WordPress Menu List Styles */
.navbar ul {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 0.5rem;
    align-items: center;
}

.navbar li {
    position: relative;
}

/* Hover effect */
.navbar a:hover {
    color: #DD574E; /* hover color */
}
.navbar a:active {
    color: #DD574E; /* hover color */
}

/* Active/current page menu item */
.navbar .current-menu-item > a,
.navbar .current-menu-ancestor > a {
    color: #DD574E; /* active page color */
    font-weight: 600; /* optional: make active slightly bolder */
}


/* Desktop Menu Link */
.desktop-menu-a {
    position: relative;
    color: #fff;
    padding: 0.5rem 1.1rem;
    font-size: 15px;
    line-height: 1.25;
    letter-spacing: 0.01em;
    transition: color 0.3s;
}

/* Underline effect using ::after */
.desktop-menu-a::after {
    content: '';
    position: absolute;
    bottom: 0.1rem;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 1px;
    background-color: currentColor;
    transition: width 0.3s;
}

.desktop-menu-a:hover {
    color: #DC5850;
}



.desktop-menu-a:hover::after {
    width: calc(100% - 2.2rem);
}

/* Active state for main menu links */
.desktop-menu-a.current-menu-item,
.desktop-menu-a.current_page_item,
.desktop-menu-a:active {
    color: #DC5850;
}

/* Dropdown trigger buttons (e.g. "Categories") */
.desktop-menu-button {
    color: #fff;
    display: inline-flex;
    align-items: center;
}

.desktop-menu-button:hover,
.desktop-menu-button[aria-expanded="true"] {
    color: #DC5850;
}

.desktop-menu-button svg {
    transition: transform 0.2s ease;
}

.desktop-menu-button[aria-expanded="true"] svg {
    transform: rotate(180deg);
}

/* Header sits on a permanent translucent dark bar so white nav text stays
   readable on every page — even ones with no dark hero behind it (search,
   404, archives) — then solidifies further once the page scrolls. */
#header-container {
    background: linear-gradient(to bottom, rgba(10, 10, 10, 0.55) 0%, rgba(10, 10, 10, 0.32) 70%, rgba(10, 10, 10, 0.18) 100%);
    transition: background-color 0.4s ease, box-shadow 0.4s ease, backdrop-filter 0.4s ease;
}

#header-container.header-solid {
    background-image: none;
    background-color: rgba(17, 17, 17, 0.92);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.08);
}

.header-search-label {
    font-size: 13px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}


  </style>
</head>

<body <?php body_class('bg-skin relative overflow-x-hidden'); ?>>
  <?php wp_body_open(); ?>
  <header>
    <div id="header-container"
     class="<?= isset($GLOBALS['has_padding']) && $GLOBALS['has_padding'] ? 'shown' : '' ?> 
            fixed top-0 inset-x-0 z-50 transition-all duration-500 <?= is_user_logged_in() ? 'mt-2' : ''; ?>
            bg-transparent">

      <div id="header" class="container relative bg-transparent z-50 w-full md:flex flex-row">
        <div id="nav-container" class="flex items-center justify-between w-full">
          <div class="!px-0 flex items-center w-full py-5 sm:py-5 flex-0 flex-grow-0">
            <div class="lg:px-28 lg:pt-4 mr-auto">
              <a href="<?= home_url() ?>" class="inline-flex items-center w-32 h-8 lg:w-40 lg:h-20 bg-white rounded-lg px-3 py-1.5 shadow-sm">
                <?= isset($header['logo']) ? get_img($header['logo'], '112px', ['class' => 'object-contain transition-all duration-300', 'id' => "nav-logo"]) : '<span class="text-primary text-2xl font-medium">' . get_bloginfo('title') . '</span>' ?>
              </a>
            </div>



            <?php get_template_part('components/global/header/desktop-menu/desktop-menu'); ?>

            <div class="flex justify-center items-center ml-auto mt-5 lg:px-28 lg:pt-4">
            <div x-data="{ open: false }" class="relative flex items-center">
    <!-- Hidden Input Form -->
    <form 
        x-show="open" 
        x-cloak
        method="get" 
        action="<?php echo home_url('/'); ?>" 
        class="flex bg-white border rounded shadow-lg overflow-hidden transition-all duration-300"
    >
        <input 
            type="search" 
            name="s" 
            placeholder="Search…" 
            value="<?php echo get_search_query(); ?>" 
            class="px-4 py-2 border rounded outline-none w-64 sm:w-64"
        >
    </form>

    <!-- Search Icon Button -->
    <button
        @click="open = !open"
        class="flex items-center gap-2 ml-2 p-2 rounded-full text-white hover:text-[#DC5850] transition"
        aria-label="Search"
    >
        <span class="header-search-label hidden sm:inline" x-show="!open">Search</span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
        </svg>
    </button>
</div>



</div>
       
            
            </div>

          </div>
<div class="-mr-2 xl:hidden flex items-center self-center"
  x-data="Components.popover({ open: false, focus: true, preventScrolling: true })"
  @keydown.escape="onEscape"
  @close-popover-group.window="onClosePopoverGroup">

  <div class="relative h-9 w-9 flex items-center">

    <button
      type="button"
      class="absolute inset-0 z-20 inline-flex items-center justify-center p-2 text-white rounded-full"
      @click="open = !open"
      :aria-expanded="open.toString()" style="margin-top:18px;"
    >
      <span class="sr-only">Open menu</span>
          <div class="relative w-5 h-5" :class="opened && (open ? 'close' : 'open')">
        <div class="top"></div>
        <div class="middle"></div>
        <div class="bottom"></div>
      </div>
    </button>
  </div>


  <?php get_template_part('components/global/header/mobile-menu/mobile-menu'); ?>
</div>

        </div>

      </div>
    </div>
  </header>
  <script>
    (function () {
      var headerContainer = document.getElementById('header-container');
      if (!headerContainer) return;
      var solidify = function () {
        if (window.scrollY > 40) {
          headerContainer.classList.add('header-solid');
        } else {
          headerContainer.classList.remove('header-solid');
        }
      };
      solidify();
      window.addEventListener('scroll', solidify, { passive: true });
    })();
  </script>
  <div id="smooth-content" class="w-full overflow-visible">
    <main id="primary" class="site-main">