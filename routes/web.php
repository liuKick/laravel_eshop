<?php
use App\Http\Controllers\backend\AttributeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\backend\AdminController;
 
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\CategoriesController;
use App\Http\Controllers\backend\newsController;
use App\Http\Controllers\backend\ProductController;
use App\Models\User;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Home
Route::get('/',             [HomeController::class, 'Home']);
Route::get('/shop',         [HomeController::class, 'Shop']);
Route::get('/product/{id}', [HomeController::class, 'Product']);

Route::get('/news',         [HomeController::class, 'News']);
Route::get('/article',      [HomeController::class, 'Article']);
Route::get('/search',       [HomeController::class, 'Search']);

Route::get('/admin/list-news',          [ApiController::class, 'getNews']);

// User SignIn & SignUp
Route::get('/signin',         [UserController::class, 'Signin'])->name('login');
Route::post('/signin-submit', [UserController::class, 'SigninSubmit']);

Route::get('/signup',         [UserController::class, 'Signup']);
Route::post('/signup-submit', [UserController::class, 'SignupSubmit']);




// @Middleware Auth
Route::middleware(['auth'])->group(function () {
    //@user signout
    Route::get('/signout',           [UserController::class, 'SignOut']);
    
    //@Admin
    Route::get('/admin',             [AdminController::class, 'index']);
    Route::get('/admin/add-post',    [AdminController::class, 'AddPost']);
    Route::get('/admin/list-post',   [AdminController::class, 'ListPost']);
    
    //@Web logo
    Route::get('/admin/add-logo',            [AdminController::class, 'AddLogo']);
    Route::post('/admin/add-logo-submit',    [AdminController::class, 'AddLogoSubmit']);
    Route::get('/admin/list-logo',           [AdminController::class, 'ListLogo']);   
    Route::get('/admin/update-logo/{id}',    [AdminController::class, 'UpdateLogo']);   
    Route::post('/admin/update-logo-submit', [AdminController::class, 'UpdateLogoSubmit']);   
    Route::post('/admin/delete-logo-submit', [AdminController::class, 'DeleteLogoSubmit']);   
    // @End web logo
     
    // @Log Activity
    Route::get('/admin/log-activity',   [AdminController::class, 'ListLogActivity']);
    
    
    // @Category Web
    Route::get('/admin/add-category',            [AdminController::class, 'AddCategory']);
    Route::post('/admin/add-category-submit',    [AdminController::class, 'AddCategorySubmit']);
    Route::get('/admin/list-category',           [AdminController::class, 'ListCategory']);
    Route::get('/admin/update-category/{id}',    [AdminController::class, 'UpdateCategory']);
    Route::post('/admin/update-category-submit', [AdminController::class, 'UpdateCategorySubmit']);
    Route::post('/admin/remove-category-submit', [AdminController::class, 'RemoveCategorySubmit']); 
    // @End Category
    
    // @Attribute
    Route::get('/admin/add-attribute',            [AttributeController::class, 'AddAttribute']);
    Route::post('/admin/add-attribute-submit',    [AttributeController::class, 'AddAttributeSubmit']);
    Route::get('/admin/list-attribute',           [AttributeController::class, 'ListAttribute']);
    Route::get('/admin/update-attribute/{id}',    [AttributeController::class, 'UpdateAttribute']);
    Route::post('/admin/update-attribute-submit', [AttributeController::class, 'UpdateAttributeSubmit']);
    Route::post('/admin/remove-attribute-submit', [AttributeController::class, 'DeleteAttributeSubmit']);
    // @End Attribute
    
    // @Product Route
    Route::get('/admin/add-product',                   [AdminController::class, 'AddProduct']);
    Route::post('/admin/add-product-submit',           [AdminController::class, 'AddProductSubmit']);
    Route::get('/admin/list-product',                  [AdminController::class, 'ListProduct']);
    Route::get('/admin/update-product/{id}',           [AdminController::class, 'UpdateProduct']);
    Route::post('/admin/update-product-submit',        [AdminController::class, 'UpdateProductSubmit']);
    Route::post('/admin/remove-product-submit',        [AdminController::class, 'RemoveProductSubmit']);
    // @End Product
    

    // Add @News
    Route::get('/admin/add-news',                  [newsController::class, 'addNews']);
    Route::post('/admin/add-news-submit',          [newsController::class, 'addNewsSubmit']);
    Route::get('/admin/list-news',                 [newsController::class, 'listNews']);
    Route::get('/admin/update-news/{id}',          [newsController::class, 'updateNews']);
    Route::post('/admin/update-news-submit',       [newsController::class, 'updateNewsSubmit']);
    Route::post('/admin/remove-news-submit',       [newsController::class, 'removeNewsSubmit']);
    Route::get('/news',                            [newsController::class, 'getNews']);
    Route::get('/news-detail/{id}',                [newsController::class, 'newsDetail']);
    

});
