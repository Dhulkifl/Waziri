"use strict";

/* -------------------------------------------------------------------------- */

/*                              Config                                        */

/* -------------------------------------------------------------------------- */
var CONFIG = {
  isNavbarVerticalCollapsed: true,
  theme: 'light',
  isRTL: true,
  isFluid: true,
  navbarStyle: 'transparent',
  navbarPosition: 'top'
};
Object.keys(CONFIG).forEach(function (key) {
  if (localStorage.getItem(key) === null) {
    localStorage.setItem(key, CONFIG[key]);
  }
});

if (JSON.parse(localStorage.getItem('isNavbarVerticalCollapsed'))) {
  document.documentElement.classList.add('navbar-vertical-collapsed');
}

if (localStorage.getItem('theme') === 'dark') {
  document.documentElement.classList.add('dark');
}