<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodDonationController;
use App\Http\Controllers\EventRedistributionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\NotificationController;

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::view('/verification/success', 'verification.success')->name('verification.success');
Route::view('/verification/already-verified', 'verification.already-verified')->name('verification.already-verified');
Route::view('/verification/invalid', 'verification.invalid')->name('verification.invalid');
Route::get('/password/reset', [ForgotPasswordController::class, 'showForm'])->name('password.reset.form');
Route::post('/password/reset', [ForgotPasswordController::class, 'sendResetLink'])->name('password.reset.send');
Route::get('/password/reset/form/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.show.form');
Route::post('/password/reset/form', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.submit');

Route::post('/edit/user/update', [UserController::class, 'update'])->name('edit.user.update');



//Food Donation Controller Route
Route::get('/food-donation/history', [FoodDonationController::class, 'foodDonationHistory'])->name('food.donation.history');
Route::get('/food/donation/history/{status?}', [FoodDonationController::class,'foodDonationHistory'])->name('food.donation.history.status');
Route::get('/food-donate', [FoodDonationController::class, 'showFoodDonationForm'])->name('food.donation');
Route::post('/store', [FoodDonationController::class, 'store'])->name('food_items.store');
Route::put('/food_items/{food_item}', [FoodDonationController::class, 'update'])->name('food_items.update');
Route::delete('/food_items/{food_item}', [FoodDonationController::class, 'destroy'])->name('food_items.destroy');
Route::post('/food-donation/make-donation', [FoodDonationController::class, 'makeDonation'])->name('food_items.makeDonation');

Route::get('/food-donate/address/form', [FoodDonationController::class, 'showAddressForm'])->name('food.donation.location');

Route::get('/events/create', [EventRedistributionController::class, 'create'])->name('events.create');
Route::get('/event/redistribution/history', [EventRedistributionController::class, 'eventRedistributionHistory'])->name('event.redistribution.history');
Route::get('/event/redistribution/history/{status?}', [EventRedistributionController::class, 'eventRedistributionHistory'])->name('event.redistribution.history.status');
Route::post('/events/store', [EventRedistributionController::class, 'store'])->name('events.store');
Route::get('/events/{event}/edit', [EventRedistributionController::class, 'edit'])->name('events.edit');
Route::put('/events/{event}/update', [EventRedistributionController::class, 'update'])->name('events.update');
Route::delete('/events/{event}/destroy', [EventRedistributionController::class, 'destroy'])->name('events.destroy');
Route::get('/redistribution/page', [EventRedistributionController::class, 'index'])->name('redistribution.page');
Route::post('/events/submit/{eventId}', [EventRedistributionController::class, 'submit'])->name('events.submit');
Route::get('/fooditems/create/{event_id}', [EventRedistributionController::class, 'createFoodItems'])->name('fooditems.create');
Route::get('/event/food-item/{itemId}', [EventRedistributionController::class, 'editFoodItem'])->name('fooditems.edit');
Route::delete('/event/food_items/delete/{itemId}', [EventRedistributionController::class, 'destroyFoodItem'])->name('fooditems.destroy');


Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
Route::delete('/inventory/{product}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
Route::post('/inventory/donate/{product}', [InventoryController::class, 'donate'])->name('inventory.donate');





Route::get('/admin-dashboard/users', [AdminController::class, 'users'])->name('admin.dashboard.users');
Route::post('/admin/users/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
Route::post('/admin/users/delete', [AdminController::class, 'delete'])->name('admin.users.delete');

Route::get('/admin-dashboard/food-donation', [AdminController::class, 'foodDonationList'])->name('admin.dashboard.food.donation.list');
Route::get('/admin-dashboard/food-donation/{search?}', [AdminController::class, 'foodDonationList'])->name('admin.dashboard.food.donation.list.search');
Route::put('/admin/food-donation/{id}', [AdminController::class, 'updateFoodDonationStatus'])->name('admin.foodDonation.update');

Route::get('/admin/event-redistribution-list', [AdminController::class, 'eventRedistributionList'])->name('admin.eventRedistributionList');
Route::put('/admin/update-event-redistribution/{id}', [AdminController::class, 'updateEventRedistributionStatus'])->name('admin.updateEventRedistributionStatus');
Route::get('/admin-dashboard/event_redistribution/{search?}', [AdminController::class, 'eventRedistributionList'])->name('admin.dashboard.event.redistribution.search');
Route::get('/admin/get-redistribution-report', [AdminController::class, 'getRedistributionReport'])->name('admin.getRedistributionReport');
Route::get('/admin/redistributions/all', [AdminController::class, 'showAllRedistributionReports'])->name('admin.getAllRedistributionReports');
Route::get('/completed/event/redistribution/{id}', [EventRedistributionController::class, 'completeEventRedistribution'])->name('complete.event.redistribution');
Route::get('/completed/food/donation/{id}', [FoodDonationController::class, 'completeFoodDonation'])->name('complete.food.donation');

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
Route::get('/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');


Route::get('/about-us/fundraising-food-waste', [UserController::class,'aboutUs'])->name('about-us');
Route::get('/faq/fundraising-food-waste', [UserController::class,'faqs'])->name('faqs');



















































































// fund raise start
//dashboard
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
//profile
Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
//global redirect for modal
Route::get('/redirect/{route}/{status}/{message}', [UserController::class, 'redirectToPage'])->name('user.redirect');
//event CRUD
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
Route::get('/event/edit/{id}', [EventController::class, 'edit'])->name('event.edit');
Route::put('/event/update/{id}', [EventController::class, 'update'])->name('event.update');
Route::get('/event/view/{id}', [EventController::class, 'show'])->name('event.view');
Route::delete('/event/destroy/{event}', [EventController::class, 'destroy'])->name('event.destroy');
//approve/reject
Route::get('/event/respond/{id}/{status}', [EventController::class, 'respond'])->name('event.respond');
//report
Route::get('/event/report', [EventController::class, 'report'])->name('event.report');
//donation history
Route::get('/history', [EventController::class, 'history'])->name('event.history');
//redeem voucher page
Route::get('/redeem/{status}', [EventController::class, 'redeem'])->name('event.redeem');
//redeem voucher
Route::get('/redeemvoucher/{id}', [EventController::class, 'redeemVoucher'])->name('event.redeemvoucher');
//point history
Route::get('/pointhistory', [EventController::class, 'pointhistory'])->name('event.pointhistory');
//report detail
Route::get('/reportdetail/{id}', [EventController::class, 'reportdetail'])->name('event.reportdetail');
//redeem confirmation
Route::get('/confirmredeem/{id}', [EventController::class, 'confirmredeem'])->name('event.confirmredeem');

//category CRUD
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::get('/category/view/{id}', [CategoryController::class, 'show'])->name('category.view');
Route::delete('/category/destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

//voucher CRUD
Route::get('/voucher', [VoucherController::class, 'index'])->name('voucher.index');
Route::get('/voucher/create', [VoucherController::class, 'create'])->name('voucher.create');
Route::post('/voucher/store', [VoucherController::class, 'store'])->name('voucher.store');
Route::get('/voucher/edit/{id}', [VoucherController::class, 'edit'])->name('voucher.edit');
Route::put('/voucher/update/{id}', [VoucherController::class, 'update'])->name('voucher.update');
Route::get('/voucher/view/{id}', [VoucherController::class, 'show'])->name('voucher.view');
Route::delete('/voucher/destroy/{voucher}', [VoucherController::class, 'destroy'])->name('voucher.destroy');
//report
Route::get('/voucher/report', [VoucherController::class, 'report'])->name('voucher.report');

//landing page
Route::get('/', [UserController::class, 'home'])->name('fundraise_home_page');
//announcement detail
Route::get('/announcementDetail/{id}', [UserController::class, 'announcementDetail'])->name('announcementDetail');
//event detail
Route::get('/event/detail/{id}', [EventController::class, 'eventDetail'])->name('event.detail');
//all donor
Route::get('/event/getdonor/{id}', [EventController::class, 'getDonor'])->name('event.getdonor');
//share
Route::get('/event/share/{id}', [EventController::class, 'share'])->name('event.share');
//donate page
Route::get('/event/donate/{id}', [EventController::class, 'donate'])->name('event.donate');
//payment page
Route::get('/event/payment/{id}/{method}', [EventController::class, 'payment'])->name('event.payment');
//save payment
Route::post('/event/makepayment', [EventController::class, 'makepayment'])->name('event.makepayment');
//receipt
Route::get('/event/receipt/{id}', [EventController::class, 'receipt'])->name('event.receipt');
//all event
Route::get('/allevent/{status}', [EventController::class, 'allevent'])->name('event.allevent');
//register volunteer
Route::get('/registervolunteer/{announcement}', [EventController::class, 'registervolunteer'])->name('event.registervolunteer');
Route::post('/storevolunteer/{announcement}', [EventController::class, 'storevolunteer'])->name('event.storevolunteer');
//volunteer
Route::get('/volunteer/{type}', [EventController::class, 'volunteer'])->name('event.volunteer');
//view volunteer detail
Route::get('/volunteer/viewvolunteer/{id}', [EventController::class, 'viewvolunteer'])->name('event.viewvolunteer');
//approve/reject
Route::get('/volunteer/respondvolunteer/{id}/{status}', [EventController::class, 'respondvolunteer'])->name('event.respondvolunteer');
//delete volunteer
Route::delete('/volunteer/destroyvolunteer/{volunteer}', [EventController::class, 'destroyvolunteer'])->name('event.destroyvolunteer');
//edit volunteer
Route::get('/volunteer/editvolunteer/{id}', [EventController::class, 'editvolunteer'])->name('event.editvolunteer');
//update volunteer
Route::put('/volunteer/updatevolunteer/{volunteer}', [EventController::class, 'updatevolunteer'])->name('event.updatevolunteer');
//add completion
Route::get('/volunteer/addcompletion/{volunteer}', [EventController::class, 'addcompletion'])->name('event.addcompletion');
//store completion
Route::post('/volunteer/storecompletion/{volunteer}', [EventController::class, 'storecompletion'])->name('event.storecompletion');
//update completion
Route::put('/volunteer/updatecompletion/{completionform}', [EventController::class, 'updatecompletion'])->name('event.updatecompletion');
//delete completion form
Route::delete('/volunteer/destroycompletionform/{completionform}', [EventController::class, 'destroycompletionform'])->name('event.destroycompletionform');
//edit completion
Route::get('/volunteer/editcompletion/{completionform}', [EventController::class, 'editcompletion'])->name('event.editcompletion');
//view completion
Route::get('/volunteer/viewcompletion/{completionform}', [EventController::class, 'viewcompletion'])->name('event.viewcompletion');
//approve/reject
Route::get('/volunteer/respondcompletion/{completionform}/{status}', [EventController::class, 'respondcompletion'])->name('event.respondcompletion');
//cert
Route::get('/volunteer/cert/{completionform}', [EventController::class, 'cert'])->name('event.cert');
//volunteer report
Route::get('/event/reportvolunteer', [EventController::class, 'reportvolunteer'])->name('event.reportvolunteer');
//volunteer report detail
Route::get('/reportdetailvolunteer/{id}', [EventController::class, 'reportdetailvolunteer'])->name('event.reportdetailvolunteer');
//logout
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

//paypal
Route::controller(PaymentController::class)
    ->prefix('paypal')
    ->group(function () {
        Route::get('handle-payment/{amount}/{currency}', 'handlePayment')->name('make.payment');
        Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
        Route::get('payment-success', 'paymentSuccess')->name('success.payment');
        Route::get('paymenterror/{message}', 'paymenterror')->name('paymenterror');
    });
// fund raise end