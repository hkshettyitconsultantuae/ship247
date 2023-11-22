<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    @vite("resources/css/dashboard/dashboard.scss")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
      <!-- Clarity Scripts -->
      <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", "j8vcxubafz");
    </script>


</head>
<body>
    <main class="dashboard-app">
    <div class="dashboard-sidebar @if(Auth::user()->role_id == 1) admin-sidebar @endif">
        <a href="/" class="header-logo">
            @if(Auth::user()->role_id == 1)
                <img src="/images/ship247-logo-full-white.svg" alt=""/>
            @else
                <img src="/images/ship247-logo-white.svg" alt=""/>
            @endif
        </a>
        <ul class="siderbar-navigation">
            @if(Auth::user()->role_id == 1)
                <li class="section-head">
                    <span>main menu</span>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.dashboard.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.dashboard.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/home-icon.svg" alt="">
                        </i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.customers.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.customers.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/home-icon.svg" alt="">
                        </i>
                        <span>Customers</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.bookings.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.bookings.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/booking-icon.svg" alt="">
                        </i>
                        <span>Bookings</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.invoices.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.invoices.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>payments</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.user.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.user.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>EMPLOYEES</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.company.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.company.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>VENDORS</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.locations.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.locations.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>Locations</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.news.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.news.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>
                            News
                        </span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.work-with-us-forms.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.work-with-us-forms.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>
                            Work with us
                        </span>
                    </a>
                </li>
                <li class="{{ Route::currentRouteName() === 'superadmin.quick-request-forms.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.quick-request-forms.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>
                            Quick Requests
                        </span>
                    </a>
                </li>

                <li class="section-head mt-6">
                    <span>sea</span>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.sea-schedules.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.sea-schedules.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>Pricing</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.pick-and-delivery-schedules.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.pick-and-delivery-schedules.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>Pick & Delivery</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.sea-booking-addons.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.sea-booking-addons.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>ADD ON</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.sea-hot-deals.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.sea-hot-deals.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>Hot Deals</span>
                    </a>
                </li>

                <li class="section-head mt-6">
                    <span>land</span>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.land-schedules.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.land-schedules.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>Pricing</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.land-booking-addons.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.land-booking-addons.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>ADD ON</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.land-hot-deals.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.land-hot-deals.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>
                            Hot Deals
                        </span>
                    </a>
                </li>

                <li class="section-head mt-6">
                    <span>Settings</span>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.container-sizes.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.container-sizes.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>Container Sizes</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'superadmin.truck-types.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.truck-types.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>Truck Types</span>
                    </a>
                </li>
                <li class="{{ Route::currentRouteName() === 'superadmin.industry.index' ? 'active' : '' }}">
                    <a href="{{route('superadmin.industry.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>Industries</span>
                    </a>
                </li>

            @endif
            @if(Auth::user()->role_id == 2)
                <li class="{{ Route::currentRouteName() === 'customer.dashboard.index' ? 'active' : '' }}">
                    <a href="{{route('customer.dashboard.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/home-icon.svg" alt="">
                        </i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'customer.bookings.index' ? 'active' : '' }}">
                    <a href="{{route('customer.bookings.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/booking-icon.svg" alt="">
                        </i>
                        <span>Bookings</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'customer.invoices.index' ? 'active' : '' }}">
                    <a href="{{route('customer.invoices.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>payments</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() === 'company.index' ? 'active' : '' }}">
                    <a href="{{route('company.index')}}">
                        <i class="icon">
                            <img src="/images/svg/dashboard/payment-icon.svg" alt="">
                        </i>
                        <span>Work with us</span>
                    </a>
                </li>
            @endif
        </ul>

        <a class="mobile-close-button">
            X
        </a>
    </div>

    <div class="dashboard-body">
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <section class="shadow-box xsmall-box">
            <div class="topbar-nav">
                
                <p class="username">
                    <a class="mobile-open-button">
                        <svg class="YIUegm7fh_CpJbivTu6B MnxxlQlR1H0xJuMEE8Yr" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    </a>

                    Welcome {{Auth::user()->role_id == 1 ? "Super Admin" : "Akkaas"}}
                </p>
                <div class="nav-group">
                    <div class="date">
                        <i class="icon">
                            <img src="/images/svg/dashboard/date-icon.svg" alt="">
                        </i>
                        <span>{{ now()->format('d-m-Y') }}</span>
                    </div>
                    <div class="notification">
                        <i class="icon">
                            <img src="/images/svg/dashboard/alert-icon.svg" alt="">
                        </i>
                        <span>23</span>
                    </div>
                    <div class="relative">
                        <div class="user-link"></div>
                        <!-- Dropdown menu -->
                        <div
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 absolute top-[45px] right-0 user-dropdown">
                            <div class="px-4 py-3 text-xs text-gray-900">
                                <div>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</div>
                                <div
                                    class="truncate primary-font-regular mt-1">{{Auth::user()->email}}</div>
                            </div>
                            <ul class="py-2 text-sm text-gray-700 primary-font-regular"
                                aria-labelledby="dropdownDividerButton">
                                <li>
                                    @if(auth()->user()->role_id==1)
                                        <a href="{{route('superadmin.profile')}}"
                                           class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                            <span>Profile</span>
                                        </a>
                                    @elseif(auth()->user()->role_id==2)
                                        <a href="{{route('customer.profile')}}"
                                           class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                            <span>Profile</span>
                                        </a>
                                    @elseif(auth()->user()->role_id==3)
                                        <a href="{{route('manager.profile')}}"
                                           class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                            <span>Profile</span>
                                        </a>
                                    @endif
                                </li>
                            </ul>
                            <div class="py-2 primary-font-regular">
                                <a href="/logout"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-600 hover:text-white">Sign
                                    out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @yield('content')
    </div>
</main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script>
        // $('.user-link').click(function(){
        //     $('.user-dropdown').toggle();
        // });
        $("body").click(function (e) {
            if (e.target.className !== "user-link") {
                $(".user-dropdown").hide();
            } else {
                $(".user-dropdown").show();
            }
        });

        $('.mobile-open-button').click(function(){
            $('.dashboard-sidebar').addClass('mobile-menu-open');
            $('.dashboard-sidebar').removeClass('mobile-menu-close')
        })

        $('.mobile-close-button').click(function(){
            $('.dashboard-sidebar').addClass('mobile-menu-close');
            $('.dashboard-sidebar').removeClass('mobile-menu-open')
        })

        // $('.edit-button').click(function(){

        // })

        function personalEditMode() {
            $('.view-personal-mode').addClass('hidden');
            $('.edit-personal-mode').removeClass('hidden');
            // document.getElementByClass('view-mode').classList.add('hidden');
            // document.getElementByClass('edit-mode').classList.remove('hidden');
        }

        function personalCancelMode() {
            $('.view-personal-mode').removeClass('hidden');
            $('.edit-personal-mode').addClass('hidden');
            // document.getElementByClass('view-mode').classList.remove('hidden');
            // document.getElementByClass('edit-mode').classList.add('hidden');
        }

        function companyEditMode() {
            $('.view-company-mode').addClass('hidden');
            $('.edit-company-mode').removeClass('hidden');
            // document.getElementByClass('view-mode').classList.add('hidden');
            // document.getElementByClass('edit-mode').classList.remove('hidden');
        }

        function companyCancelMode() {
            $('.view-company-mode').removeClass('hidden');
            $('.edit-company-mode').addClass('hidden');
            // document.getElementByClass('view-mode').classList.remove('hidden');
            // document.getElementByClass('edit-mode').classList.add('hidden');
        }

        function securityEditMode() {
            $('.view-security-mode').addClass('hidden');
            $('.edit-security-mode').removeClass('hidden');
            // document.getElementByClass('view-mode').classList.add('hidden');
            // document.getElementByClass('edit-mode').classList.remove('hidden');
        }

        function securityCancelMode() {
            $('.view-security-mode').removeClass('hidden');
            $('.edit-security-mode').addClass('hidden');
            // document.getElementByClass('view-mode').classList.remove('hidden');
            // document.getElementByClass('edit-mode').classList.add('hidden');
        }

        $('.non-company-verified-button').click(function () {
            $('.non-company-verified').removeClass('hide');
            $('.non-company-verified-button').addClass('hide');
        });

        $('.delete-btn').click(function (e) {
            e.preventDefault();
            $(this).closest('.detail-box').remove();
        });
    </script>

    @if(in_array(Route::currentRouteName(),['superadmin.news.create', 'superadmin.news.edit']))
        <script src="/js/tinymce/tinymce.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            tinymce.init({
                selector: 'textarea#tinymce-editor',
                toolbar_mode: 'floating'
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $('.select-multiple').select2({
            width: '100%', // Adjust the width as needed
            placeholder: 'Select Options', // Custom placeholder text
            allowClear: true, // Enable clearing selections
        });
        $('.location-Select2').select2({
            minimumInputLength: 3,
            allowClear: true,
            placeholder: 'Select Option',
            ajax: {
                url: function (params) {
                    return '/get-locations-by-city/' + params.term;
                },
                processResults: function (response) {
                    return {
                        results: response.data.map(item => { return {id: item.id, text: item.fullname}})
                    };
                },
                data: function (params) {
                    // Query parameters will be ?search=[term]&type=public
                    return {
                        _type: 'query',
                    };
                }
            }
        });
    </script>

    @yield('footer-scripts')
</body>
</html>
