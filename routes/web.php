<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ItemUserController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Models\Type;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemUser;
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

Route::get('/', function () {
    $types = Type::all();
    $categories = Category::all();
    $items = Item::all();
    return view('welcome', compact('types','categories','items'));
});


Route::get('qr-code-g', function () {

    \QrCode::size(500)
            ->format('png')
            ->generate('raviyatechnical', public_path('images/qrcode.png'));

  return view('qrCode');

});

Route::get('/user/payment/{itemuser_id}', [ItemUserController::class, 'payment']);
Route::post('/user/payment/{itemuser_id}', [ItemUserController::class, 'postPayment']);
Route::post('/user/verify-payment/{itemuser_id}', [ItemUserController::class, 'verifyPayment']);



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/places/{type_id}/{category_id}', [ItemController::class, 'show']);
    Route::get('/user/search', [ItemController::class, 'search']);
    Route::get('/user/booking/{id}', [ItemController::class, 'booking']);
    Route::get('/user/booked', function(){
        $booked = ItemUser::where('user_id', Auth::user()->id)->where('status', 'booked')->get();
        $confirmed = ItemUser::where('user_id', Auth::user()->id)->where('status', 'confirmed')->get();
        $approved = ItemUser::where('user_id', Auth::user()->id)->where('status', 'approved')->get();
        //dd($booked, $confirmed, $approved);
        return view('booking', compact('booked', 'confirmed','approved'));
    });


    Route::post('/itemuser/index', [ItemUserController::class, 'index'])->name('itemuser.index');
    Route::post('/itemuser/booking/{id}', [ItemUserController::class, 'booking'])->name('itemuser.booking');
    Route::post('/itemuser/deleted/{id}', [ItemUserController::class, 'destroy'])->name('itemuser.destroy');
    Route::post('/itemuser/update/{id}', [ItemUserController::class, 'update'])->name('itemuser.update');

    Route::get('/user/profiles', function(){
        return view('profiles');
    });

});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');

    Route::resource('items', ItemController::class);

    Route::get('/admin/items/available', function () {
        $items = Item::with(['type','category'])->get();
        return view('admin.item.available', compact('items'));
    })->name('items.available');

    Route::get('/admin/items/booked', function () {
        $items = ItemUser::where('status', 'booked')->with(['item','user'])->get();
        return view('admin.item.booked', compact('items'));
    })->name('items.booked');

    Route::get('/admin/items/confirmed', function () {
        $items = ItemUser::where('status', 'confirmed')->with(['item','user'])->get();
        return view('admin.item.confirmed', compact('items'));
    })->name('items.confirmed');

    Route::get('/admin/items/approved', function () {
        $items = ItemUser::where('status', 'approved')->with(['item','user'])->get();
        return view('admin.item.approved', compact('items'));
    })->name('items.approved');

    Route::get('/itemuser/receipts/{itemuser_id}', [ItemUserController::class, 'receipts'])->name('items.receipts');
    Route::get('/admin/items/update', [ItemController::class, 'admin_update'])->name('items.admin-update');

    Route::resource('types', TypeController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('users', UserController::class);

    Route::put('users/update-password/{id}', [UserController::class, 'update_password'])->name('users.update-password');
    Route::put('users/update-image/{id}', [UserController::class, 'update_image'])->name('users.update-image');

    Route::get('logout', [LogoutController::class, 'logout']);
});

require __DIR__.'/auth.php';
