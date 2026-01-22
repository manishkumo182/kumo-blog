import '../css/index.css'; // Correct relative path from src/js to src/css

import { gsap } from "gsap";

import Popover from './components/popover'
import StickyNav from './components/sticky-nav'
import Accordion from '../../components/global/accordion/accordion'
import Preloader from '../../components/global/preloader/preloader'
import Parallax from './components/parallax'
import '../../components/page/client/client'
import '../../components/page/testimonials/testimonials'
import '../../components/page/gallery/gallery'
import '../../components/page/banner/banner'
import '../../components/page/faq/faq'
import '../../components/page/join_position/join_position'
import ButtonHovers from './components/btn-hovers'
import Scroller from './components/scroller'
import DesktopMenu from '../../components/global/header/desktop-menu/desktop-menu'
import MobileMenu from '../../components/global/header/mobile-menu/mobile-menu'
// Import main CSS so Webpack processes it
import '../css/index.css';
console.log('JS loaded!');



let hash = ''
if (window.location.hash) {
  hash = window.location.hash
  if (hash != '#info-hub') {
    history.pushState('', '', window.location.pathname)
  }
}


document.addEventListener('DOMContentLoaded', function () {
  gsap.defaults({
    ease: 'none',
    duration: 2,
  })
  StickyNav('header')
  Parallax()

  window.addEventListener('toggle-modal', e => {
    const open = e.detail
    if (open) {
      document.body.classList.add('overflow-hidden')
    } else {
      document.body.classList.remove('overflow-hidden')
    }
  })

  if (hash) {
    document.getElementById(hash.replace('#', ''))?.scrollIntoView()
  }
})
