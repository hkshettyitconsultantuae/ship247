<?php

use App\Http\Controllers\BookingAddonsController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ContainerSizesController;
use App\Http\Controllers\QuickRequestFormController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\LandSchedulesController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PickAndDeliverySchedulesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TruckTypesController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HotDealsController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\SeaSchedulesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WorkWithUsFormsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WebsiteController::class, 'home'])->name('pages.home');
Route::get('/benefits', [WebsiteController::class, 'benefits'])->name('pages.benefits');
Route::get('/services', [WebsiteController::class, 'services'])->name('pages.services');
Route::get('/resources', [WebsiteController::class, 'resources'])->name('pages.resources');
Route::get('/clearance', [WebsiteController::class, 'clearance'])->name('pages.clearance');
Route::get('/work-with-us', [WebsiteController::class, 'workWithUs'])->name('pages.work_with_us');
Route::get('/work-with-us-form', [WebsiteController::class, 'workWithUsForm'])->name('pages.work_with_us_form');
Route::get('/search-results', [WebsiteController::class, 'searchresults'])->name('pages.searchresults');
Route::get('/news', [WebsiteController::class, 'newsListing'])->name('pages.news_listing');
Route::get('/news/{news}', [WebsiteController::class, 'newsDetails'])->name('pages.news_details');

Route::get('/policy', [WebsiteController::class, 'policy'])->name('pages.policy');
Route::get('/terms', [WebsiteController::class, 'terms'])->name('pages.terms');
Route::get('/hot-deals', [WebsiteController::class, 'hotDeals'])->name('pages.hot_deals');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('pages.contact');

Route::post('/work-with-us-form', [WorkWithUsFormsController::class, 'store'])->name('work_with_us_forms.store');

//Route::get('/shipment/details', [BookingsController::class, 'getShipmentDetails'])->name('shipment.details');
Route::get('/container/size', [BookingsController::class, 'getContainerSizes'])->name('container.sizes');
Route::get('/truck-types/get', [TruckTypesController::class, 'getApi'])->name('truck_types.get_api');
Route::get('/user_details', [ProfileController::class, 'getUserDetails'])->name('user.details');

Route::get('/logout', function () {
    session()->flush();
    Auth::logout();
    return redirect()->route('pages.home');
});
Route::post('/request-quote', [QuickRequestFormController::class, 'storeRequestQuoteData'])->name('request-quote.store');
Route::post('/bookings/in-session', [BookingsController::class, 'storeInSession'])->name('bookings.store.in_session');
Route::post('/stripe-webhook', [PaymentController::class, 'updatePaymentStatusByStripWebhook'])->name('pages.thankYouPage');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user() != null && auth()->user()->role_id == 1) {
            return redirect()->route('superadmin.dashboard.index');
        } else if (auth()->user() != null && auth()->user()->role_id == 2) {
            return redirect()->route('customer.dashboard.index');
        } else if (auth()->user() != null && auth()->user()->role_id == 3) {
            return redirect()->route('manager.dashboard.index');
        }

        return redirect()->route('pages.home');
    })->name('user.dashboard');

    Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent'])->name('Stripe Payment Intent');
    Route::post('/booking/payment/info', [PaymentController::class, 'saveBookingPaymentInformation'])->name('Save Stripe Booking information');

    Route::post('/booking-addons/in-session', [BookingAddonsController::class, 'storeInSession'])->name('booking-addons.store.in_session');
    Route::get('/additional-services', [WebsiteController::class, 'additionalServices'])->name('pages.additionalServices');
    Route::get('/shipment-details', [WebsiteController::class, 'shipmentDetails'])->name('pages.shipmentDetails');
    Route::post('/shipment-details', [BookingsController::class, 'storeShipmentDetails'])->name('shipment-details.store');

    Route::get('/booking-created/{booking}', [WebsiteController::class, 'bookingCreated'])->name('pages.bookingCreated');
    Route::get('/booking/{bookingID}/thank-you', [WebsiteController::class, 'thankYouPage'])->name('pages.thankYouPage');


    //SuperAdmin Routes
    Route::name('superadmin.')->prefix('superadmin')->middleware('superadmin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/profile', [ProfileController::class, 'getLoggedInUserProfilePage'])->name('profile');
        Route::post('/profile/{userID}', [ProfileController::class, 'updateProfileInformation'])->name('update.profile');
        Route::post('password/update/{userID}', [ProfileController::class, 'updateProfilePassword'])->name('password.update');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/customers', [ProfileController::class, 'getCustomerList'])->name('customers.index');
        Route::get('/bookings', [BookingsController::class, 'index'])->name('bookings.index');
        Route::get('/customer/{customerID}', [ProfileController::class, 'getCustomerDetails'])->name('customer.detail');

        Route::get('/invoices', [InvoicesController::class, 'index'])->name('invoices.index');

        Route::get('/bookings/{booking}', [BookingsController::class, 'show'])->name('bookings.show');
        Route::get('/bookings/{bookingId}/edit', [BookingsController::class, 'editBookingDetails'])->name('bookings.edit');

        Route::get('/bookings/{paymentID}/invoice', [InvoicesController::class, 'getBookingInvoice'])->name('booking.invoice');

        Route::get('/users', [ProfileController::class, 'getUserList'])->name('user.index');
        Route::get('/create/user', [ProfileController::class, 'createUser'])->name('user.create');
        Route::get('edit/user/{userID}', [ProfileController::class, 'editUser'])->name('user.edit');
        Route::post('/store/user', [ProfileController::class, 'storeUser'])->name('user.store');
        Route::post('/update/user', [ProfileController::class, 'updateUser'])->name('user.update');
        Route::post('delete/user/{userID}', [ProfileController::class, 'deleteUser'])->name('user.delete');

        Route::post('delete/customer/{customerID}', [ProfileController::class, 'deleteCustomer'])->name('customer.delete');

        Route::get('/companies', [CompanyController::class, 'getCompanies'])->name('company.index');
        Route::get('/companies/create', [CompanyController::class, 'createCompany'])->name('company.create');

        Route::resource('industry', IndustryController::class)->except(['show']);

        Route::get('/companies/{companyID}', [CompanyController::class, 'getCompanyDetails'])->name('company.details');
        Route::post('/assign/companies', [CompanyController::class, 'assignCompaniesToCustomer'])->name('assign.companies');

        Route::post('/companies/{companyID}/update-status', [CompanyController::class, 'updateCompanyStatus'])->name('companyStatus.update');
        Route::post('/bookings/{bookingId}/update-status', [BookingsController::class, 'updatebookingDetails'])->name('bookingDetails.update');

        // Route::get('/news',[CompanyController::class, 'getNews'])->name('news.index');

        Route::resource('locations', LocationsController::class)->names([
            'index' => 'locations.index',
            'create' => 'locations.create',
            'store' => 'locations.store',
            'edit' => 'locations.edit',
            'update' => 'locations.update',
            'destroy' => 'locations.destroy',
        ])->except('show');

        Route::get('sea-hot-deals', [HotDealsController::class, 'index'])->name('sea-hot-deals.index');
        Route::get('sea-hot-deals/create', [HotDealsController::class, 'create'])->name('sea-hot-deals.create');
        Route::post('sea-hot-deals', [HotDealsController::class, 'store'])->name('sea-hot-deals.store');
        Route::get('sea-hot-deals/{hot_deal}/edit', [HotDealsController::class, 'edit'])->name('sea-hot-deals.edit');
        Route::put('sea-hot-deals/{hot_deal}', [HotDealsController::class, 'update'])->name('sea-hot-deals.update');
        Route::delete('sea-hot-deals/{hot_deal}', [HotDealsController::class, 'destroy'])->name('sea-hot-deals.destroy');

        Route::get('land-hot-deals', [HotDealsController::class, 'index'])->name('land-hot-deals.index');
        Route::get('land-hot-deals/create', [HotDealsController::class, 'create'])->name('land-hot-deals.create');
        Route::post('land-hot-deals', [HotDealsController::class, 'store'])->name('land-hot-deals.store');
        Route::get('land-hot-deals/{hot_deal}/edit', [HotDealsController::class, 'edit'])->name('land-hot-deals.edit');
        Route::put('land-hot-deals/{hot_deal}', [HotDealsController::class, 'update'])->name('land-hot-deals.update');
        Route::delete('land-hot-deals/{hot_deal}', [HotDealsController::class, 'destroy'])->name('land-hot-deals.destroy');

        Route::get('sea-booking-addons', [BookingAddonsController::class, 'index'])->name('sea-booking-addons.index');
        Route::get('sea-booking-addons/create', [BookingAddonsController::class, 'create'])->name('sea-booking-addons.create');
        Route::post('sea-booking-addons', [BookingAddonsController::class, 'store'])->name('sea-booking-addons.store');
        Route::get('sea-booking-addons/{booking_addon}/edit', [BookingAddonsController::class, 'edit'])->name('sea-booking-addons.edit');
        Route::put('sea-booking-addons/{booking_addon}', [BookingAddonsController::class, 'update'])->name('sea-booking-addons.update');
        Route::delete('sea-booking-addons/{booking_addon}', [BookingAddonsController::class, 'destroy'])->name('sea-booking-addons.destroy');

        Route::get('land-booking-addons', [BookingAddonsController::class, 'index'])->name('land-booking-addons.index');
        Route::get('land-booking-addons/create', [BookingAddonsController::class, 'create'])->name('land-booking-addons.create');
        Route::post('land-booking-addons', [BookingAddonsController::class, 'store'])->name('land-booking-addons.store');
        Route::get('land-booking-addons/{booking_addon}/edit', [BookingAddonsController::class, 'edit'])->name('land-booking-addons.edit');
        Route::put('land-booking-addons/{booking_addon}', [BookingAddonsController::class, 'update'])->name('land-booking-addons.update');
        Route::delete('land-booking-addons/{booking_addon}', [BookingAddonsController::class, 'destroy'])->name('land-booking-addons.destroy');

        Route::resource('news', NewsController::class)->except('show');

        Route::get('/work-with-us-forms', [WorkWithUsFormsController::class, 'index'])
            ->name('work-with-us-forms.index');
     
            Route::patch('/work-with-us-forms/update_status', [WorkWithUsFormsController::class, 'updateStatus'])
            ->name('work-with-us-forms.update_status');
        
            Route::get('/work-with-us-form/{workWithUsFormID}', [WorkWithUsFormsController::class, 'workWithUsFormDetailsByID'])
            ->name('work-with-us-form-detail');

            Route::get('/quick-request-forms', [QuickRequestFormController::class, 'index'])
            ->name('quick-request-forms.index');

            Route::get('/quick-request-form/{quickRequestID}', [QuickRequestFormController::class, 'quickRequestDetailsByID'])
            ->name('quick-request-form-detail');

        // Sea Schedules
        Route::get('sea-schedules', [SeaSchedulesController::class, 'index'])->name('sea-schedules.index');
        Route::get('sea-schedules/create', [SeaSchedulesController::class, 'create'])->name('sea-schedules.create');
        Route::post('sea-schedules', [SeaSchedulesController::class, 'store'])->name('sea-schedules.store');
        Route::get('sea-schedules/{seaSchedule}/edit', [SeaSchedulesController::class, 'edit'])->name('sea-schedules.edit');
        Route::put('sea-schedules/{seaSchedule}', [SeaSchedulesController::class, 'update'])->name('sea-schedules.update');
        Route::delete('sea-schedules/{seaSchedule}', [SeaSchedulesController::class, 'destroy'])->name('sea-schedules.destroy');

        // Pick and Delivery Schedules
        Route::get('pick-and-delivery-schedules',
            [PickAndDeliverySchedulesController::class, 'index'])->name('pick-and-delivery-schedules.index');
        Route::get('pick-and-delivery-schedules/create',
            [PickAndDeliverySchedulesController::class, 'create'])->name('pick-and-delivery-schedules.create');
        Route::post('pick-and-delivery-schedules/import',
            [PickAndDeliverySchedulesController::class, 'import'])->name('pick-and-delivery-schedules.import');
        Route::post('pick-and-delivery-schedules',
            [PickAndDeliverySchedulesController::class, 'store'])->name('pick-and-delivery-schedules.store');
        Route::get('pick-and-delivery-schedules/{pickAndDeliverySchedule}/edit',
            [PickAndDeliverySchedulesController::class, 'edit'])->name('pick-and-delivery-schedules.edit');
        Route::put('pick-and-delivery-schedules/{pickAndDeliverySchedule}',
            [PickAndDeliverySchedulesController::class, 'update'])->name('pick-and-delivery-schedules.update');
        Route::delete('pick-and-delivery-schedules/{pickAndDeliverySchedule}',
            [PickAndDeliverySchedulesController::class, 'destroy'])->name('pick-and-delivery-schedules.destroy');


        // Land Schedules
        Route::get('land-schedules', [LandSchedulesController::class, 'index'])->name('land-schedules.index');
        Route::get('land-schedules/create', [LandSchedulesController::class, 'create'])->name('land-schedules.create');
        Route::post('land-schedules', [LandSchedulesController::class, 'store'])->name('land-schedules.store');
        Route::get('land-schedules/{landSchedule}/edit', [LandSchedulesController::class, 'edit'])->name('land-schedules.edit');
        Route::put('land-schedules/{landSchedule}', [LandSchedulesController::class, 'update'])->name('land-schedules.update');
        Route::delete('land-schedules/{landSchedule}', [LandSchedulesController::class, 'destroy'])->name('land-schedules.destroy');

        // Container Sizes
        Route::get('container-sizes', [ContainerSizesController::class, 'index'])->name('container-sizes.index');
        Route::get('container-sizes/create', [ContainerSizesController::class, 'create'])->name('container-sizes.create');
        Route::post('container-sizes', [ContainerSizesController::class, 'store'])->name('container-sizes.store');
        Route::get('container-sizes/{containerSize}/edit', [ContainerSizesController::class, 'edit'])->name('container-sizes.edit');
        Route::put('container-sizes/{containerSize}', [ContainerSizesController::class, 'update'])->name('container-sizes.update');
        Route::delete('container-sizes/{containerSize}', [ContainerSizesController::class, 'destroy'])->name('container-sizes.destroy');

        // Truck Types
        Route::get('truck-types', [TruckTypesController::class, 'index'])->name('truck-types.index');
        Route::get('truck-types/create', [TruckTypesController::class, 'create'])->name('truck-types.create');
        Route::post('truck-types', [TruckTypesController::class, 'store'])->name('truck-types.store');
        Route::get('truck-types/{truckType}/edit', [TruckTypesController::class, 'edit'])->name('truck-types.edit');
        Route::put('truck-types/{truckType}', [TruckTypesController::class, 'update'])->name('truck-types.update');
        Route::delete('truck-types/{truckType}', [TruckTypesController::class, 'destroy'])->name('truck-types.destroy');
    });

    Route::group(['prefix' => 'customer', 'middleware' => 'customer'], function () {
        Route::get('/profile', [ProfileController::class, 'getLoggedInUserProfilePage'])->name('customer.profile');

        Route::resource('companies', CompanyController::class)->names([
            'index' => 'company.index',
            'create' => 'company.create',
            'store' => 'company.store',
        ])->only('index', 'create', 'store');
        Route::post('password/update/{userID}', [ProfileController::class, 'updateProfilePassword'])->name('customer.password.update');
        Route::post('/profile/{userID}', [ProfileController::class, 'updateProfileInformation'])->name('customer.update.profile');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard.index');
        Route::get('/invoices', [InvoicesController::class, 'index'])->name('customer.invoices.index');
        Route::get('/bookings', [BookingsController::class, 'index'])->name('customer.bookings.index');
        Route::get('/bookings/{booking}', [BookingsController::class, 'show'])->name('customer.bookings.show');
       
    });

    Route::group(['prefix' => 'manager', 'middleware' => 'manager'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('manager.dashboard.index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/bookings/{booking}', [BookingsController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{paymentID}/invoice', [InvoicesController::class, 'getBookingInvoice'])->name('booking.invoice');
    Route::get('/detail', [BookingsController::class, 'index'])->name('detail.index');

    Route::get('/invoices', [InvoicesController::class, 'index'])->name('invoices.index');
});

Route::get('/get-locations-by-city/{city}', [WebsiteController::class, 'getLocationsByCity'])
    ->name('api.get-locations-by-city');

Route::get('/get-point-to-point-schedules/', [WebsiteController::class, 'getPointToPointSchedules'])
    ->name('api.point-to-point-schedules');

Route::get('/get-point-to-point-prices/', [WebsiteController::class, 'getPointToPointPrices'])
    ->name('api.point-to-point-prices');

Route::get('fetch-maersk-geo-id', function () {
    $locations = \App\Models\Location::whereNotNull('code')->whereNull('maersk_geo_id')->get();
    foreach ($locations as $location) {
        \App\Jobs\FetchMaerskGeoIDOfLocations::dispatch($location);
    }
});

require __DIR__ . '/auth.php';
