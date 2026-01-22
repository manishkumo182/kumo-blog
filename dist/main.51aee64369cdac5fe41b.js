/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./components/global/accordion/accordion.js"
/*!**************************************************!*\
  !*** ./components/global/accordion/accordion.js ***!
  \**************************************************/
() {

document.addEventListener('alpine:init', function () {
  Alpine.data('Accordion', function (_ref) {
    var _ref$index = _ref.index,
      index = _ref$index === void 0 ? 0 : _ref$index,
      _ref$allCollapsed = _ref.allCollapsed,
      allCollapsed = _ref$allCollapsed === void 0 ? true : _ref$allCollapsed;
    return {
      index: index,
      allCollapsed: allCollapsed
    };
  });
});

/***/ },

/***/ "./components/global/header/desktop-menu/desktop-menu.js"
/*!***************************************************************!*\
  !*** ./components/global/header/desktop-menu/desktop-menu.js ***!
  \***************************************************************/
() {

document.addEventListener('alpine:init', function () {
  Alpine.data('DesktopMenu', function () {
    return {
      open: false,
      index0: 0,
      index1: 0,
      index2: 0,
      lastHovered: {
        menuIndex: 1,
        itemIndex: 0
      },
      selectedMenuType: 'treatment_application',
      init: function init() {
        this.$watch('open', function (open) {
          if (open) {
            setTimeout(function () {
              document.body.classList.add('overflow-hidden');
            }, 10);
          } else {
            document.body.classList.remove('overflow-hidden');
          }
        });
      },
      select: function select(menuIndex, itemIndex) {
        if (menuIndex == 0) {
          this.index0 = itemIndex;
          this.index1 = 0;
          this.index2 = 0;
        } else if (menuIndex == 1) {
          this.index1 = itemIndex;
          this.index2 = 0;
        } else if (menuIndex == 2) {
          this.index2 = itemIndex;
        }
        this.lastHovered.menuIndex = menuIndex;
        this.lastHovered.itemIndex = itemIndex;
      }
    };
  });
});

/***/ },

/***/ "./components/global/header/mobile-menu/mobile-menu.js"
/*!*************************************************************!*\
  !*** ./components/global/header/mobile-menu/mobile-menu.js ***!
  \*************************************************************/
() {

document.addEventListener('alpine:init', function () {
  Alpine.data('MobileMenu', function () {
    return {
      open: false,
      index: 0,
      init: function init() {
        var _this = this;
        this.$watch('open', function (open) {
          if (!open) {
            _this.depth = 0;
            _this.index0 = 0;
          }
        });
        window.addEventListener('close-mobile-menu', function () {
          setTimeout(function () {
            _this.open = false;
          }, 300);
        });
        this.$el.querySelectorAll('.scroller').forEach(function (el) {
          el.addEventListener('scroll', function (e) {
            var scroller = e.target;
            var scrollTopEnd = scroller.scrollHeight - scroller.clientHeight;
            if (scroller.scrollTop < scrollTopEnd - 10) {
              _this.more = true;
            } else {
              _this.more = false;
            }
          });
        });
      },
      back: function back() {}
    };
  });
});

/***/ },

/***/ "./components/global/preloader/preloader.js"
/*!**************************************************!*\
  !*** ./components/global/preloader/preloader.js ***!
  \**************************************************/
() {

document.addEventListener('alpine:init', function () {
  Alpine.data('Preloader', function () {
    return {
      init: function init() {
        var _this = this;
        var isFirstLoad = !window.sessionStorage.getItem('is-first-load');
        window.sessionStorage.setItem('is-first-load', false);
        document.querySelectorAll('a').forEach(function (link) {
          link.addEventListener('click', function (e) {
            // If user is trying to open link in new tab
            if (e.ctrlKey || e.shiftKey || e.metaKey ||
            // apple
            e.button && e.button == 1 // middle click, >IE9 + everyone else
            ) {
              return;
            }
            if (link.getAttribute('target') != '_blank') {
              if (link.href.startsWith('http') || link.href.startsWith('//')) {
                var linkPageUrl = new URL(link.href);
                var linkPage = linkPageUrl.origin + linkPageUrl.pathname;
                var currentPage = window.location.origin + window.location.pathname;
                if (linkPage != currentPage) {
                  e.preventDefault();
                  gsap.timeline().fromTo(_this.$refs.panel, {
                    xPercent: 100
                  }, {
                    ease: 'power1.in',
                    xPercent: 0,
                    duration: 0.75
                  }).fromTo(_this.$refs.c, {
                    opacity: 0
                  }, {
                    ease: 'power1.in',
                    duration: 0.5,
                    opacity: 1,
                    onComplete: function onComplete() {
                      window.location = link.href;
                    }
                  });
                }
              }
            }
          });
        });
        var animateOut = function animateOut() {
          if (isFirstLoad) {
            var tl = gsap.timeline().delay(0.1);
            if (window.innerWidth > 640) {
              if (_this.$refs.textL && _this.$refs.textR) {
                tl.add(gsap.timeline().to(_this.$refs.textL, {
                  ease: 'power3.out',
                  duration: 1,
                  x: 0
                }, 0).to(_this.$refs.textR, {
                  ease: 'power3.out',
                  duration: 1,
                  x: 24
                }, 0));
              }
            }
            tl.to([_this.$refs.textL, _this.$refs.textR, _this.$refs.c].filter(function (el) {
              return !!el;
            }), {
              ease: 'power1.out',
              duration: 0.75,
              opacity: 0
            }).to(_this.$refs.panel, {
              ease: 'power2.inOut',
              xPercent: -100,
              duration: 1.75
            });
          } else {
            gsap.timeline().to(_this.$refs.c, {
              ease: 'power1.out',
              duration: 0.5,
              opacity: 0
            }).to(_this.$refs.panel, {
              ease: 'power1.out',
              xPercent: -100,
              duration: 0.75
            });
          }
        };
        window.addEventListener('load', animateOut);
        window.addEventListener('pageshow', animateOut);
      }
    };
  });
});

/***/ },

/***/ "./components/page/banner/banner.js"
/*!******************************************!*\
  !*** ./components/page/banner/banner.js ***!
  \******************************************/
() {

document.addEventListener('alpine:init', function () {
  Alpine.data('bannerHandler', function () {
    return {
      showThumbnail: false,
      init: function init() {
        var _this = this;
        // Play video on load for larger screens
        if (window.innerWidth > 1024) {
          this.playVideo();
        } else {
          this.showThumbnail = true; // Show image on smaller screens directly
        }

        // Handle window resizing to control video and image display
        window.addEventListener('resize', function () {
          if (window.innerWidth < 1024) {
            _this.stopVideo();
            _this.showThumbnail = true;
          } else {
            _this.playVideo();
            _this.showThumbnail = false;
          }
        });
      },
      playVideo: function playVideo() {
        if (this.$refs.videoPlayer) {
          this.$refs.videoPlayer.play();
        }
      },
      stopVideo: function stopVideo() {
        if (this.$refs.videoPlayer) {
          this.$refs.videoPlayer.pause();
        }
      }
    };
  });
});

/***/ },

/***/ "./components/page/client/client.js"
/*!******************************************!*\
  !*** ./components/page/client/client.js ***!
  \******************************************/
() {

document.addEventListener('DOMContentLoaded', function () {
  new Swiper('.mySwiper', {
    slidesPerView: 3,
    // Number of slides visible at once
    spaceBetween: 30,
    // Space between slides
    loop: true,
    // Infinite loop
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    },
    breakpoints: {
      640: {
        slidesPerView: 1
      },
      768: {
        slidesPerView: 4
      },
      1024: {
        slidesPerView: 5
      }
    }
  });
});

/***/ },

/***/ "./components/page/faq/faq.js"
/*!************************************!*\
  !*** ./components/page/faq/faq.js ***!
  \************************************/
() {

document.addEventListener('DOMContentLoaded', function () {
  var accordionHeaders = document.querySelectorAll('.accordion-header');
  accordionHeaders.forEach(function (header) {
    header.addEventListener('click', function () {
      var contentId = header.getAttribute('data-toggle');
      var content = document.getElementById(contentId);

      // Toggle visibility
      var isVisible = content.style.display === 'block';
      document.querySelectorAll('.accordion-content').forEach(function (el) {
        return el.style.display = 'none';
      });
      if (!isVisible) {
        content.style.display = 'block';
      } else {
        content.style.display = 'none';
      }
    });
  });
});

/***/ },

/***/ "./components/page/gallery/gallery.js"
/*!********************************************!*\
  !*** ./components/page/gallery/gallery.js ***!
  \********************************************/
() {

(function ($) {
  $(function () {
    var container = document.querySelector('.js-masonry');
    var msnry;
    imagesLoaded(container, function () {
      msnry = new Masonry(container, {
        itemSelector: '.item-masonry',
        isFitWidth: true
      });
    });
  });
});

/***/ },

/***/ "./components/page/join_position/join_position.js"
/*!********************************************************!*\
  !*** ./components/page/join_position/join_position.js ***!
  \********************************************************/
() {

document.addEventListener('alpine:init', function () {
  Alpine.data('position', function () {
    return {
      hoverIndex: -1,
      init: function init() {
        var _this = this;
        var swiper = new Swiper(this.$refs.swiperPosition, {
          loop: true,
          spaceBetween: 24,
          breakpoints: {
            360: {
              slidesPerView: 1,
              spaceBetween: 24
            },
            640: {
              slidesPerView: 1,
              spaceBetween: 24
            },
            1024: {
              spaceBetween: 24,
              slidesPerView: 3
            }
          },
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
            renderBullet: function renderBullet(index, className) {
              return '<span class="' + className + '">' + "</span>";
            }
          },
          navigation: {
            nextEl: '.button-next',
            prevEl: '.button-prev'
          }
        });
        swiper.on('realIndexChange', function (swiper) {
          _this.index = swiper.realIndex;
        });
        this.$watch('hoverIndex', function (value) {
          console.log(value);
        });
      }
    };
  });
});

/***/ },

/***/ "./components/page/testimonials/testimonials.js"
/*!******************************************************!*\
  !*** ./components/page/testimonials/testimonials.js ***!
  \******************************************************/
() {

document.addEventListener('DOMContentLoaded', function () {
  // Initialize Swiper
  var swiper = new Swiper('.testimonials-slider', {
    loop: true,
    autoplay: {
      delay: 5000
    },
    slidesPerView: 1,
    spaceBetween: 20,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    },
    breakpoints: {
      768: {
        slidesPerView: 2,
        spaceBetween: 30
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 40
      }
    }
  });

  // Read More Button Functionality
  var readMoreButtons = document.querySelectorAll('.read-more-btn');
  readMoreButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      var content = this.previousElementSibling;
      if (content.style.webkitLineClamp === '3') {
        content.style.webkitLineClamp = 'unset';
        this.textContent = 'Read Less';
      } else {
        content.style.webkitLineClamp = '3';
        this.textContent = 'Read More';
      }
    });
  });
});

/***/ },

/***/ "./src/css/index.css"
/*!***************************!*\
  !*** ./src/css/index.css ***!
  \***************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ },

/***/ "./src/js/components/btn-hovers.js"
/*!*****************************************!*\
  !*** ./src/js/components/btn-hovers.js ***!
  \*****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function () {
  var buttons = document.querySelectorAll('.btn-primary,.btn-primary-outline, .btn-secondary, .wpcf7 button');
  if (buttons.length > 0) {
    buttons.forEach(function (button) {
      button.classList.add('group');
      var translateClass1 = '';
      var translateClass2 = '';
      if (button.classList.contains('big')) {
        translateClass1 = 'group-hover:-translate-y-12';
        translateClass2 = 'translate-y-12';
      } else {
        translateClass1 = 'group-hover:-translate-y-6';
        translateClass2 = 'translate-y-6';
      }
      button.innerHTML = "\n        <span class=\"block relative overflow-hidden\">\n          <span class=\"absolute inset-0 transition-all duration-300 translate-y-0 ".concat(translateClass1, "\">\n          ").concat(button.innerHTML, "\n          </span>\n          <span class=\"invisible\">\n            ").concat(button.innerHTML, "\n          </span>\n          <span class=\"absolute inset-0 transition-all duration-300  group-hover:translate-y-0 ").concat(translateClass2, "\">\n          ").concat(button.innerHTML, "\n          </span>\n        </span>\n      ");
    });
  }
});

/***/ },

/***/ "./src/js/components/parallax.js"
/*!***************************************!*\
  !*** ./src/js/components/parallax.js ***!
  \***************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function () {
  // apply parallax effect to any element with a data-speed attribute
  var parents = document.querySelectorAll('[data-parent]');
  parents.forEach(function (parent) {
    var scaleElements = parent.querySelectorAll('[data-scale]');
    var translateElements = parent.querySelectorAll('[data-translate]');
    var additionalScaleRequired = 0;
    var parentHeight = parent.clientHeight;
    if (parentHeight < window.innerHeight) {
      var spaceHeight = window.innerHeight - parentHeight;
      var scrollProgress = (parentHeight + spaceHeight) / (2 * parentHeight + spaceHeight);
      additionalScaleRequired = (scrollProgress * 2 - 1) * 2;
    }
    if (scaleElements.length > 0 || translateElements.length > 0) {
      var tl = gsap.timeline();
      scaleElements.forEach(function (el) {
        tl.to(el, {
          scale: parseFloat(el.getAttribute('data-scale'))
        }, 0);
      });
      translateElements.forEach(function (el) {
        var value = parseFloat(el.getAttribute('data-translate'));
        var scaling = 1;
        if (el.hasAttribute('data-cover-parent')) {
          scaling += additionalScaleRequired;
        }
        tl.fromTo(el, {
          scale: scaling,
          yPercent: (value - 1) * -100
        }, {
          scale: scaling,
          yPercent: (value - 1) * 100
        }, 0);
      });
      var start = parent.dataset.start;
      var end = parent.dataset.end;
      ScrollTrigger.create({
        trigger: parent,
        start: start !== null && start !== void 0 ? start : 'top bottom',
        end: end !== null && end !== void 0 ? end : 'bottom top',
        animation: tl,
        scrub: true
      });
    }
  });
});

/***/ },

/***/ "./src/js/components/popover.js"
/*!**************************************!*\
  !*** ./src/js/components/popover.js ***!
  \**************************************/
() {

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _defineAccessor(e, r, n, t) { var c = { configurable: !0, enumerable: !0 }; return c[e] = t, Object.defineProperty(r, n, c); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
window.Components = {
  listbox: function listbox(options) {
    var modelName = options.modelName || 'selected';
    return _objectSpread(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineAccessor("get", {
      init: function init() {
        var _this = this;
        this.optionCount = this.$refs.listbox.children.length;
        this.$watch('activeIndex', function (value) {
          if (!_this.open) return;
          if (_this.activeIndex === null) {
            _this.activeDescendant = '';
            return;
          }
          _this.activeDescendant = _this.$refs.listbox.children[_this.activeIndex].id;
        });
      },
      activeDescendant: null,
      optionCount: null,
      open: false,
      activeIndex: null,
      selectedIndex: 0,
      get active() {
        return this.items[this.activeIndex];
      }
    }, modelName, function () {
      return this.items[this.selectedIndex];
    }), "choose", function choose(option) {
      this.selectedIndex = option;
      this.open = false;
    }), "onButtonClick", function onButtonClick() {
      var _this2 = this;
      if (this.open) return;
      this.activeIndex = this.selectedIndex;
      this.open = true;
      this.$nextTick(function () {
        _this2.$refs.listbox.focus();
        _this2.$refs.listbox.children[_this2.activeIndex].scrollIntoView({
          block: 'nearest'
        });
      });
    }), "onOptionSelect", function onOptionSelect() {
      if (this.activeIndex !== null) {
        this.selectedIndex = this.activeIndex;
      }
      this.open = false;
      this.$refs.button.focus();
    }), "onEscape", function onEscape() {
      this.open = false;
      this.$refs.button.focus();
    }), "onArrowUp", function onArrowUp() {
      this.activeIndex = this.activeIndex - 1 < 0 ? this.optionCount - 1 : this.activeIndex - 1;
      this.$refs.listbox.children[this.activeIndex].scrollIntoView({
        block: 'nearest'
      });
    }), "onArrowDown", function onArrowDown() {
      this.activeIndex = this.activeIndex + 1 > this.optionCount - 1 ? 0 : this.activeIndex + 1;
      this.$refs.listbox.children[this.activeIndex].scrollIntoView({
        block: 'nearest'
      });
    }), options);
  }
};
window.Components.popoverGroup = function popoverGroup() {
  return {
    __type: 'popoverGroup',
    init: function init() {
      var _this3 = this;
      var _handler = function handler(e) {
        if (!document.body.contains(_this3.$el)) {
          window.removeEventListener('focus', _handler, true);
          return;
        }
        if (e.target instanceof Element && !_this3.$el.contains(e.target)) {
          window.dispatchEvent(new CustomEvent('close-popover-group', {
            detail: _this3.$el
          }));
        }
      };
      window.addEventListener('focus', _handler, true);
    }
  };
};
window.Components.popover = function popover() {
  var _ref = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
    _ref$open = _ref.open,
    open = _ref$open === void 0 ? false : _ref$open,
    _ref$focus = _ref.focus,
    focus = _ref$focus === void 0 ? false : _ref$focus,
    _ref$preventScrolling = _ref.preventScrolling,
    preventScrolling = _ref$preventScrolling === void 0 ? false : _ref$preventScrolling;
  var focusableSelector = ['[contentEditable=true]', '[tabindex]', 'a[href]', 'area[href]', 'button:not([disabled])', 'iframe', 'input:not([disabled])', 'select:not([disabled])', 'textarea:not([disabled])'].map(function (selector) {
    return "".concat(selector, ":not([tabindex='-1'])");
  }).join(',');
  function focusFirst(container) {
    var focusableElements = Array.from(container.querySelectorAll(focusableSelector));
    function tryFocus(element) {
      if (element === undefined) return;
      element.focus({
        preventScroll: true
      });
      if (document.activeElement !== element) {
        tryFocus(focusableElements[focusableElements.indexOf(element) + 1]);
      }
    }
    tryFocus(focusableElements[0]);
  }
  return {
    __type: 'popover',
    open: open,
    opened: false,
    init: function init() {
      var _this4 = this;
      this.$watch('open', function (open) {
        _this4.opened = true;
        if (open) {
          if (preventScrolling) {
            document.body.classList.add('overflow-hidden');
          }
          if (focus) {
            _this4.$nextTick(function () {
              focusFirst(_this4.$refs.panel);
            });
          }
        } else {
          if (preventScrolling) {
            document.body.classList.remove('overflow-hidden');
          }
        }
      });
      var _handler2 = function handler(e) {
        if (!document.body.contains(_this4.$el)) {
          window.removeEventListener('focus', _handler2, true);
          return;
        }
        var ref = focus ? _this4.$refs.panel : _this4.$el;
        if (_this4.open && e.target instanceof Element && !ref.contains(e.target)) {
          var node = _this4.$el;
          while (node.parentNode) {
            node = node.parentNode;
            if (node.__x instanceof _this4.constructor) {
              if (node.__x.$data.__type === 'popoverGroup') return;
              if (node.__x.$data.__type === 'popover') break;
            }
          }
          _this4.open = false;
        }
      };
      window.addEventListener('focus', _handler2, true);
    },
    onEscape: function onEscape() {
      this.open = false;
      if (this.restoreEl) {
        this.restoreEl.focus();
      }
    },
    onClosePopoverGroup: function onClosePopoverGroup(e) {
      if (e.detail.contains(this.$el)) {
        this.open = false;
      }
    },
    toggle: function toggle(e) {
      this.open = !this.open;
      if (this.open) {
        this.restoreEl = e.currentTarget;
      } else if (this.restoreEl) {
        this.restoreEl.focus();
      }
    }
  };
};
window.Components.radioGroup = function radioGroup() {
  var _ref2 = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
    _ref2$initialCheckedI = _ref2.initialCheckedIndex,
    initialCheckedIndex = _ref2$initialCheckedI === void 0 ? 0 : _ref2$initialCheckedI;
  return {
    value: undefined,
    init: function init() {
      var _Array$from$initialCh;
      this.value = (_Array$from$initialCh = Array.from(this.$el.querySelectorAll('input'))[initialCheckedIndex]) === null || _Array$from$initialCh === void 0 ? void 0 : _Array$from$initialCh.value;
    }
  };
};

/***/ },

/***/ "./src/js/components/scroller.js"
/*!***************************************!*\
  !*** ./src/js/components/scroller.js ***!
  \***************************************/
() {

document.addEventListener('alpine:init', function () {
  Alpine.data('Scroller', function () {
    return {
      more: true,
      init: function init() {
        var _this = this;
        this.$refs.scroller.addEventListener('scroll', function (e) {
          var scroller = e.target;
          var scrollTopEnd = scroller.scrollHeight - scroller.clientHeight;
          if (scroller.scrollTop < scrollTopEnd - 10) {
            _this.more = true;
          } else {
            _this.more = false;
          }
        });
        var observer = new IntersectionObserver(function (entries, observer) {
          if (_this.$refs.scroller.scrollHeight <= _this.$refs.scroller.clientHeight) {
            _this.more = false;
          } else {
            _this.more = true;
          }
        });
        observer.observe(this.$refs.scroller);
      }
    };
  });
});

/***/ },

/***/ "./src/js/components/sticky-nav.js"
/*!*****************************************!*\
  !*** ./src/js/components/sticky-nav.js ***!
  \*****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function (elementId) {
  // --- Parameters ---
  var navbar = document.getElementById('header-container'); // Must have position: fixed
  var navbarHeader = document.getElementById('header');
  var threshold = 2 * navbarHeader.clientHeight; // Number of px of space at the top of the page where the navbar won't disappear

  // How many pixels you have to scroll before navbar transitions
  var scrollDownThreshold = 25;
  var scrollUpThreshold = 100;
  // --- End Parameters ---

  var placeholder = document.getElementById('header-placeholder');

  // Give the DOM some time to render
  navbar.style.position = 'fixed';
  var trigger;
  navbar.dataset.initialClass = navbar.getAttribute('class');
  var transition = window.getComputedStyle(navbar).getPropertyValue('transition');
  navbar.style.transition = [transition, '0.3s transform ease-in-out'].join(',');
  var previousScrollTop = 0;
  var cumulativeAmountScrolledDown = 0;
  var cumulativeAmountScrolledUp = 0;
  window.addEventListener('scroll', function () {
    // The number of pixels the user has scrolled down from the top of the page
    var currentScrollTop = document.body.scrollTop || document.documentElement.scrollTop;

    // If scrolling down
    if (currentScrollTop > previousScrollTop) {
      cumulativeAmountScrolledUp = 0;
      cumulativeAmountScrolledDown += currentScrollTop - previousScrollTop;
      // If you have been scrolling down for more than ${scrollDownThreshold}px
      if (cumulativeAmountScrolledDown > scrollDownThreshold) {
        // If you have passed the threshold where the navbar should not disappear
        if (currentScrollTop > threshold) {
          slideNavbarUp();
        }
      }
    }
    // If scrolling up
    else {
      cumulativeAmountScrolledDown = 0;
      cumulativeAmountScrolledUp += previousScrollTop - currentScrollTop;

      // If you have been scrolling up for more than ${scrollUpThreshold}px
      // OR you are at the top of the page
      if (cumulativeAmountScrolledUp > scrollUpThreshold) {
        slideNavbarDown();
      }
      if (currentScrollTop == 0) {
        navbar.classList.remove('is-shown');
      }
    }
    previousScrollTop = currentScrollTop;
  });
  var slideNavbarUp = function slideNavbarUp() {
    navbar.style.transform = "translateY(-".concat(navbar.clientHeight, "px)");
    navbar.classList.remove('is-shown');
  };
  var slideNavbarDown = function slideNavbarDown() {
    navbar.style.transform = null;
    navbar.classList.add('is-shown');
  };
  window.addEventListener('resize', function () {});
});

/***/ },

/***/ "./src/js/index.js"
/*!*************************!*\
  !*** ./src/js/index.js ***!
  \*************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _css_index_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../css/index.css */ "./src/css/index.css");
/* harmony import */ var _components_popover__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/popover */ "./src/js/components/popover.js");
/* harmony import */ var _components_popover__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_components_popover__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_sticky_nav__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/sticky-nav */ "./src/js/components/sticky-nav.js");
/* harmony import */ var _components_global_accordion_accordion__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../components/global/accordion/accordion */ "./components/global/accordion/accordion.js");
/* harmony import */ var _components_global_accordion_accordion__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_components_global_accordion_accordion__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _components_global_preloader_preloader__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../components/global/preloader/preloader */ "./components/global/preloader/preloader.js");
/* harmony import */ var _components_global_preloader_preloader__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_components_global_preloader_preloader__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _components_parallax__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/parallax */ "./src/js/components/parallax.js");
/* harmony import */ var _components_page_client_client__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../components/page/client/client */ "./components/page/client/client.js");
/* harmony import */ var _components_page_client_client__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_components_page_client_client__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _components_page_testimonials_testimonials__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../../components/page/testimonials/testimonials */ "./components/page/testimonials/testimonials.js");
/* harmony import */ var _components_page_testimonials_testimonials__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_components_page_testimonials_testimonials__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _components_page_gallery_gallery__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../../components/page/gallery/gallery */ "./components/page/gallery/gallery.js");
/* harmony import */ var _components_page_gallery_gallery__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_components_page_gallery_gallery__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _components_page_banner_banner__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../../components/page/banner/banner */ "./components/page/banner/banner.js");
/* harmony import */ var _components_page_banner_banner__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_components_page_banner_banner__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _components_page_faq_faq__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../../components/page/faq/faq */ "./components/page/faq/faq.js");
/* harmony import */ var _components_page_faq_faq__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_components_page_faq_faq__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _components_page_join_position_join_position__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../../components/page/join_position/join_position */ "./components/page/join_position/join_position.js");
/* harmony import */ var _components_page_join_position_join_position__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_components_page_join_position_join_position__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _components_btn_hovers__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./components/btn-hovers */ "./src/js/components/btn-hovers.js");
/* harmony import */ var _components_scroller__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./components/scroller */ "./src/js/components/scroller.js");
/* harmony import */ var _components_scroller__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(_components_scroller__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var _components_global_header_desktop_menu_desktop_menu__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ../../components/global/header/desktop-menu/desktop-menu */ "./components/global/header/desktop-menu/desktop-menu.js");
/* harmony import */ var _components_global_header_desktop_menu_desktop_menu__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(_components_global_header_desktop_menu_desktop_menu__WEBPACK_IMPORTED_MODULE_14__);
/* harmony import */ var _components_global_header_mobile_menu_mobile_menu__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ../../components/global/header/mobile-menu/mobile-menu */ "./components/global/header/mobile-menu/mobile-menu.js");
/* harmony import */ var _components_global_header_mobile_menu_mobile_menu__WEBPACK_IMPORTED_MODULE_15___default = /*#__PURE__*/__webpack_require__.n(_components_global_header_mobile_menu_mobile_menu__WEBPACK_IMPORTED_MODULE_15__);
 // Correct relative path from src/js to src/css
















// Import main CSS so Webpack processes it

console.log('JS loaded!');
var hash = '';
if (window.location.hash) {
  hash = window.location.hash;
  if (hash != '#info-hub') {
    history.pushState('', '', window.location.pathname);
  }
}
document.addEventListener('DOMContentLoaded', function () {
  gsap.defaults({
    ease: 'none',
    duration: 2
  });
  (0,_components_sticky_nav__WEBPACK_IMPORTED_MODULE_2__["default"])('header');
  (0,_components_parallax__WEBPACK_IMPORTED_MODULE_5__["default"])();
  window.addEventListener('toggle-modal', function (e) {
    var open = e.detail;
    if (open) {
      document.body.classList.add('overflow-hidden');
    } else {
      document.body.classList.remove('overflow-hidden');
    }
  });
  if (hash) {
    var _document$getElementB;
    (_document$getElementB = document.getElementById(hash.replace('#', ''))) === null || _document$getElementB === void 0 || _document$getElementB.scrollIntoView();
  }
});

/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Check if module exists (development only)
/******/ 		if (__webpack_modules__[moduleId] === undefined) {
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"main": 0,
/******/ 			"src_css_index_css": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkcubit_wp_theme"] = self["webpackChunkcubit_wp_theme"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["src_css_index_css"], () => (__webpack_require__("./src/js/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=main.51aee64369cdac5fe41b.js.map