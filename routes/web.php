<?php

//ROUTES DEL WEBSITE
Route::get('/','Website\PageController@index')->name('website.home');
Route::get('/informativa','Website\PageController@informativa');
Route::get('/policy','Website\PageController@policy');
Route::get('/category/{id}','Website\PageController@category');
Route::get('/remove_from_cart/{id}','Website\PageController@remove_from_cart');
Route::get('/esito_ordinazione/{id}','Website\PageController@esito_ordinazione')->name('website.esito_ordinazione');
Route::post('/add_to_cart','Website\PageController@add_to_cart');
Route::post('/update_price','Website\PageController@update_price');
Route::post('/cart_resume','Website\PageController@cart_resume');
Route::get('/get_cart_resume','Website\PageController@get_cart_resume')->name('website.cart_resume');
Route::post('/checkout','Website\PageController@checkout');
Route::post('/checkout_paypal','Website\PageController@checkout_paypal');
Route::post('/paypal_notify','Website\PageController@paypal_notify');
Route::get('/paypal_error','Website\PageController@paypal_error');
Route::get('/checkout_stripe/{id}', 'Website\PageController@checkout_stripe');
Route::post('/stripe', 'Website\PageController@stripePost')->name('stripe.post');
Route::post('/clear_cookies', 'Website\PageController@clear_cookies');
Route::get('/cookies_policy', 'Website\PageController@cookies_policy');
Route::get('/informativa', 'Website\PageController@informativa');
Route::get('/send_twilio', 'Website\PageController@send_twilio');
Route::get('/send_telegram', 'Website\PageController@send_telegram');
Route::get('/send_sms', 'Website\PageController@send_sms');


//ROUTES DEL CMS
Route::group(['prefix' => 'cms'], function ()
{
    /*
     * Per ogni route che non sia login chiamo il middleware "cms.isauth:cms"
     * cms.isauth è l'alias configurato per il middleware Cms\IsAuth nel Kernel.php
     * :cms corrisponde al tipo di guard che usiamo per l'autenitcazione in config/auth.php
     */
    Route::middleware('cms.isauth:cms')->group(function ()
    {
        Route::get('/', 'Cms\DashboardController@index')->name('cms.dashboard');

        Route::get('/settings', 'Cms\SettingsController@index')->name('cms.settings');
        Route::get('/settings/create_module', 'Cms\SettingsController@create_module')->name('cms.create.module');
        Route::get('/settings/switch_stato_module','Cms\SettingsController@switch_stato_module');
        Route::get('/settings/switch_boolean_config','Cms\SettingsController@switch_boolean_config');
        Route::get('/settings/config_module/{id}','Cms\SettingsController@config_module');
        Route::get('/settings/edit_module/{id}','Cms\SettingsController@edit_module');
        Route::get('/settings/edit_config_module/{id}','Cms\SettingsController@edit_config_module');
        Route::get('/settings/create_config_module/{id}','Cms\SettingsController@create_config_module');
        Route::get('/settings/destroy_config_module/{id}','Cms\SettingsController@destroy_config_module');
        Route::get('/settings/create_copy_config_module/{id}','Cms\SettingsController@create_copy_config_module');
        Route::post('/settings/update_module/{id}','Cms\SettingsController@update_module');
        Route::post('/settings/store_module','Cms\SettingsController@store_module');
        Route::post('/settings/store_config_module','Cms\SettingsController@store_config_module');
        Route::post('/settings/update_config_module/{id}','Cms\SettingsController@update_config_module');
        Route::post('/settings/store_copy_config_module','Cms\SettingsController@store_copy_config_module');

        Route::get('/shops/switch_stato','Cms\ShopsController@switch_stato');
        Route::get('/shops/switch_domicilio','Cms\ShopsController@switch_domicilio');
        Route::get('/shops/switch_asporto','Cms\ShopsController@switch_asporto');
        Route::get('/shops','Cms\ShopsController@index')->name('cms.shops');
        Route::get('/shops/create','Cms\ShopsController@create');
        Route::get('/shops/edit/{id}','Cms\ShopsController@edit');
        Route::get('/shops/users','Cms\ShopsController@users');
        Route::get('/shops/edit_user/{id}','Cms\ShopsController@edit_user');
        Route::get('/shops/destroy_user/{id}','Cms\ShopsController@destroy_user');
        Route::post('/shops/update_user/{id}','Cms\ShopsController@update_user');
        Route::post('/shops/store','Cms\ShopsController@store');
        Route::post('/shops/update/{id}','Cms\ShopsController@update');
        Route::get('/shops/destroy/{id}','Cms\ShopsController@destroy');

        Route::get('/configurations','Cms\ConfigurationsController@index')->name('cms.configurazioni');
        Route::get('/configurations/edit_comuni/{id}','Cms\ConfigurationsController@edit_comuni');
        Route::get('/configurations/edit_hours/{id}','Cms\ConfigurationsController@edit_hours');
        Route::get('/configurations/edit_open_days/{id}','Cms\ConfigurationsController@edit_open_days');
        Route::get('/configurations/edit_logo/{id}','Cms\ConfigurationsController@edit_logo');
        Route::get('/configurations/shop_config/{id}', 'Cms\ConfigurationsController@shop_config');
        Route::post('/configurations/upload_logo', 'Cms\ConfigurationsController@upload_logo');
        Route::post('/configurations/update_comuni/{id}', 'Cms\ConfigurationsController@update_comuni');
        Route::post('/configurations/update_hours/{id}', 'Cms\ConfigurationsController@update_hours');
        Route::post('/configurations/update_step/{id}', 'Cms\ConfigurationsController@update_step');
        Route::post('/configurations/update_min/{id}', 'Cms\ConfigurationsController@update_min');
        Route::post('/configurations/update_shipping_cost/{id}', 'Cms\ConfigurationsController@update_shipping_cost');
        Route::post('/configurations/update_open_days/{id}', 'Cms\ConfigurationsController@update_open_days');
        Route::post('/configurations/update_time/{id}', 'Cms\ConfigurationsController@update_time');
        Route::post('/configurations/update_maxqty/{id}', 'Cms\ConfigurationsController@update_maxqty');
        Route::post('/configurations/update_desc/{id}', 'Cms\ConfigurationsController@update_desc');
        Route::post('/configurations/update_paypal/{id}', 'Cms\ConfigurationsController@update_paypal');
        Route::post('/configurations/update_labels/{id}', 'Cms\ConfigurationsController@update_labels');



        Route::get('/macrocategory/switch_stato','Cms\MacrocategoryController@switch_stato');
        Route::resource('/macrocategory','Cms\MacrocategoryController');
        Route::get('/macrocategory/move_up/{id}', 'Cms\MacrocategoryController@move_up');
        Route::get('/macrocategory/move_down/{id}', 'Cms\MacrocategoryController@move_down');
        Route::get('/macrocategory/destroy/{id}', 'Cms\MacrocategoryController@destroy');
        Route::get('/macrocategory', 'Cms\MacrocategoryController@index')->name('cms.macrocategorie');


        Route::get('/category/switch_stato','Cms\CategoryController@switch_stato');
        Route::resource('/category','Cms\CategoryController');
        Route::get('/category/move_up/{id}', 'Cms\CategoryController@move_up');
        Route::get('/category/move_down/{id}', 'Cms\CategoryController@move_down');
        Route::get('/category/destroy/{id}', 'Cms\CategoryController@destroy');
        Route::post('/category/upload_images', 'Cms\CategoryController@upload_images');
        Route::get('/category/images/{id}', 'Cms\CategoryController@images');
        Route::get('/category', 'Cms\CategoryController@index')->name('cms.categorie');

        Route::get('/product/switch_visibility','Cms\ProductController@switch_visibility');
        Route::get('/product/switch_omaggio','Cms\ProductController@switch_omaggio');
        Route::get('/product/switch_novita','Cms\ProductController@switch_novita');
        Route::get('/product/ingredients_and_variants','Cms\ProductController@ingredients_and_variants');
        Route::resource('/product','Cms\ProductController');
        Route::post('/product/upload_images', 'Cms\ProductController@upload_images');
        Route::get('/product/images/{id}', 'Cms\ProductController@images');
        Route::get('/product/destroy/{id}', 'Cms\ProductController@destroy');
        Route::get('/product','Cms\ProductController@index')->name('cms.prodotti');

        Route::get('/ingredient/switch_visibility','Cms\IngredientController@switch_visibility');
        Route::get('/ingredient/destroy/{id}', 'Cms\IngredientController@destroy');
        Route::get('/ingredient/create','Cms\IngredientController@create');
        Route::get('/ingredient/edit/{id}','Cms\IngredientController@edit');
        Route::post('/ingredient/store','Cms\IngredientController@store');
        Route::post('/ingredient/update/{id}','Cms\IngredientController@update');
        Route::get('/ingredient','Cms\IngredientController@index')->name('cms.ingredienti');

        Route::get('/variant/switch_visibility','Cms\VariantController@switch_visibility');
        Route::get('/variant/destroy/{id}', 'Cms\VariantController@destroy');
        Route::get('/variant/create','Cms\VariantController@create');
        Route::get('/variant/edit/{id}','Cms\VariantController@edit');
        Route::post('/variant/store','Cms\VariantController@store');
        Route::post('/variant/update/{id}','Cms\VariantController@update');
        Route::get('/variant','Cms\VariantController@index')->name('cms.varianti');

        Route::get('/order_details/{id}','Cms\OrdersController@order_details');
        Route::get('/orders','Cms\OrdersController@index')->name('cms.ordini');

        Route::post('/file/sort_images', 'Cms\FileController@sort_images');
        Route::get('/file','Cms\FileController@index')->name('cms.file');
        Route::get('/file/destroy/{id}', 'Cms\FileController@destroy');

        Route::get('/website/domains', 'Cms\WebsiteController@domains')->name('cms.website.domains');
        Route::get('/website/create_domain', 'Cms\WebsiteController@create_domain');
        Route::get('/website/edit_domain/{id}', 'Cms\WebsiteController@edit_domain');
        Route::get('/website/destroy_domain/{id}', 'Cms\WebsiteController@destroy_domain');
        Route::post('/website/update_domain/{id}', 'Cms\WebsiteController@update_domain');
        Route::post('/website/store_domain','Cms\WebsiteController@store_domain');
        Route::get('/website/page_move_up/{id}', 'Cms\WebsiteController@page_move_up');
        Route::get('/website/page_move_down/{id}', 'Cms\WebsiteController@page_move_down');
        Route::get('/website/switch_menu_page','Cms\WebsiteController@switch_menu_page');
        Route::get('/website','Cms\WebsiteController@index')->name('cms.website');
        Route::get('/website/pages','Cms\WebsiteController@pages');
        Route::get('/website/create_page','Cms\WebsiteController@create_page');
        Route::get('/website/destroy_page/{id}','Cms\WebsiteController@destroy_page');
        Route::post('/website/store_page','Cms\WebsiteController@store_page');
        Route::get('/website/urls/{type?}','Cms\WebsiteController@urls');
        Route::get('/website/edit_url/{id}','Cms\WebsiteController@edit_url');
        Route::post('/website/update_url/{id}','Cms\WebsiteController@update_url');


    });

    Route::get('/login', 'Cms\Auth\LoginController@showLoginForm')->name('cms.login');
    Route::post('/login','Cms\Auth\LoginController@login')->name('cms.login');
    Route::get('/logout', 'Cms\Auth\LoginController@logout')->name('cms.logout');
    Route::get('/register','Cms\Auth\RegisterController@showRegistrationForm')->name('cms.register');
    Route::post('/register','Cms\Auth\RegisterController@register');
    Route::get('/password/reset','Cms\Auth\ForgotPasswordController@showLinkRequestForm')->name('cms.password.request');

});


