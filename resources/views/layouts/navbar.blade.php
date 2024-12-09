<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main " id="top">
    <div class="container " data-layout="container">
        <script>
            var isFluid = JSON.parse(localStorage.getItem('isFluid'));
            if (isFluid) {
                var container = document.querySelector('[data-layout]');
                container.classList.remove('container');
                container.classList.add('container-fluid');
            }
        </script>

        <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-xl">
            <a class="navbar-brand me-1 me-sm-3" href="{{ route('dashboard') }}">
                <div class="d-flex align-items-center"><img class="me-2"
                        src="{{ asset('assets/img/icons/spot-illustrations/Onyx.png') }}" alt="" height="35"
                        width="20" /><span class="">{{ __('translations.waziri') }}</span></div>
            </a>
            <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
                <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">
                    <li class="nav-item "><a class="nav-link fs-rtl" href="{{ route('dashboard') }}" role="button"
                            aria-haspopup="true" aria-expanded="false" id="dashboards">{{ __('paths.dashboard') }}</a>
                    </li>

                    <li class="nav-item dropdown"><a class="nav-link fs-rtl dropdown-toggle" href="#"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            id="app">{{ __('paths.courses') }}</a>
                        <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0"
                            aria-labelledby="dashboards">
                            <div class="bg-white dark__bg-1000 rounded-3 py-2">

                                <a class="dropdown-item link-600 fw-semi-bold fs-rtl"
                                    href="{{ route('categories') }}">{{ __('paths.categories') }}</a>
                                <a class="dropdown-item link-600 fw-semi-bold fs-rtl"
                                    href="{{ route('subjects') }}">{{ __('paths.subjects') }}</a>
                                <a class="dropdown-item link-600 fw-semi-bold fs-rtl"
                                    href="{{ route('courses') }}">{{ __('paths.courses') }}</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link fs-rtl" href="{{ route('teachers') }}"
                            aria-haspopup="true">{{ __('translations.teachers') }}</a>

                    </li>
                    <li class="nav-item"><a class="nav-link fs-rtl" href="{{ route('students') }}"
                            aria-haspopup="true">{{ __('translations.students') }}</a>

                    </li>
                    <li class="nav-item dropdown"><a class="nav-link fs-rtl dropdown-toggle" href="#"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            id="app">{{ __('paths.reports') }}</a>
                        <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0"
                            aria-labelledby="dashboards">
                            <div class="bg-white dark__bg-1000 rounded-3 py-2">
                                <!--
                    <a class="dropdown-item link-600 fw-semi-bold fs-rtl" href="{{ route('accountsLedger') }}">{{ __('translations.newUser') }}</a>
                    <a class="dropdown-item link-600 fw-semi-bold fs-rtl" href="{{ route('apartmentsAndShopsReport') }}">{{ __('paths.apartmentsShops') }}</a>
                    <a class="dropdown-item link-600 fw-semi-bold fs-rtl" href="{{ route('salariesReport') }}">{{ __('translations.salaries') }}</a>
                    -->
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link fs-rtl dropdown-toggle" href="#"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            id="app">{{ __('paths.users') }}</a>
                        <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0"
                            aria-labelledby="dashboards">
                            <div class="bg-white dark__bg-1000 rounded-3 py-2">
                                <!--
                    <a class="dropdown-item link-600 fw-semi-bold fs-rtl" href="{{ route('accountsLedger') }}">{{ __('translations.newUser') }}</a>
                    <a class="dropdown-item link-600 fw-semi-bold fs-rtl" href="{{ route('apartmentsAndShopsReport') }}">{{ __('paths.apartmentsShops') }}</a>
                    <a class="dropdown-item link-600 fw-semi-bold fs-rtl" href="{{ route('salariesReport') }}">{{ __('translations.salaries') }}</a>
                    -->

                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                <li class="nav-item d-none d-sm-block pt-2">
                    <div class="theme-control-toggle fa-icon-wait px-2">
                        <form action="{{ route('locale.change') }}" method="POST" id="languageForm">
                            @csrf
                            <input type="hidden" name="locale" id="localeInput"
                                value="{{ app()->getLocale() == 'en' ? 'da' : 'en' }}">

                            <div class="form-check form-switch">
                                <input class="form-check-input ms-0" id="mode-rtl" type="checkbox"
                                    data-theme-control="isRTL" {{ app()->getLocale() == 'da' ? 'checked' : '' }} />
                            </div>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="theme-control-toggle fa-icon-wait px-2">
                        <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle"
                            type="checkbox" data-theme-control="theme" value="dark" />
                        <label class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                            for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Switch to light theme">
                            <span class="fas fa-sun fs-0"></span>
                        </label>
                        <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                            for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Switch to dark theme">
                            <span class="fas fa-moon fs-0"></span></label>
                    </div>
                </li>


                <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../assets/img/team/3-thumb.png" alt="" />
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0"
                        aria-labelledby="navbarDropdownUser">
                        <div class="bg-white dark__bg-1000 rounded-2 py-2">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile &amp; account</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
        <script>
            var navbarPosition = localStorage.getItem('navbarPosition');

            var navbarTop = document.querySelector('[data-layout] .navbar-top');
            var navbarTopCombo = document.querySelector('.content [data-navbar-top="combo"]');
            if (navbarPosition === 'top') {
                navbarTop.removeAttribute('style');

            } else if (navbarPosition === 'combo') {
                navbarVertical.removeAttribute('style');

            } else {
                navbarVertical.removeAttribute('style');

            }
        </script>
