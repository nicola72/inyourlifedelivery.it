<?php

//ROUTES DEL WEBSITE
Route::get('/','Website\PageController@index')->name('website.home');
Route::group(['prefix' => '{locale}','where' => ['locale' => '[a-zA-Z]{2}'],'middleware' => 'setlocale'],function(){

    Route::post('/invia_formcontatti','Website\PageController@invia_formcontatti')->name('invia_formcontatti');
    Route::get('/{slug}','Website\PageController@page');

    //per L'autorizzazione
    Route::get('/login', 'Website\Auth\LoginController@showLoginForm')->name('website.login');
    Route::post('/login','Website\Auth\LoginController@login')->name('website.login');
    Route::get('/logout', 'Website\Auth\LoginController@logout')->name('website.logout');
    Route::get('/register','Website\Auth\RegisterController@showRegistrationForm')->name('website.register');
    Route::post('/register','Website\Auth\RegisterController@register');
    Route::get('/password/reset','Website\Auth\ForgotPasswordController@showLinkRequestForm')->name('website.password.request');
});



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
        Route::get('/configurations/edit_logo/{id}','Cms\ConfigurationsController@edit_logo');


        Route::get('/macrocategory/switch_stato','Cms\MacrocategoryController@switch_stato');
        Route::resource('/macrocategory','Cms\MacrocategoryController');
        Route::get('/macrocategory/move_up/{id}', 'Cms\MacrocategoryController@move_up');
        Route::get('/macrocategory/move_down/{id}', 'Cms\MacrocategoryController@move_down');
        Route::get('/macrocategory/destroy/{id}', 'Cms\MacrocategoryController@destroy');
        Route::get('/macrocategory', 'Cms\MacrocategoryController@index')->name('cms.macrocategorie');


        Route::get('/category/sync_prodotti', 'Cms\CategoryController@sync_prodotti');
        Route::get('/category/sync_file_prodotti', 'Cms\CategoryController@sync_file_prodotti');
        Route::get('/category/sync_abbinamenti', 'Cms\CategoryController@sync_abbinamenti');
        Route::get('/category/sync_file_abbinamenti', 'Cms\CategoryController@sync_file_abbinamenti');
        Route::get('/category/switch_stato','Cms\CategoryController@switch_stato');
        Route::resource('/category','Cms\CategoryController');
        Route::get('/category/move_up/{id}', 'Cms\CategoryController@move_up');
        Route::get('/category/move_down/{id}', 'Cms\CategoryController@move_down');
        Route::get('/category/destroy/{id}', 'Cms\CategoryController@destroy');
        Route::get('/category', 'Cms\CategoryController@index')->name('cms.categorie');

        Route::get('/product/switch_visibility','Cms\ProductController@switch_visibility');
        Route::get('/product/switch_visibility_italfama','Cms\ProductController@switch_visibility_italfama');
        Route::get('/product/switch_offerta','Cms\ProductController@switch_offerta');
        Route::get('/product/switch_novita','Cms\ProductController@switch_novita');
        Route::resource('/product','Cms\ProductController');
        Route::post('/product/upload_images', 'Cms\ProductController@upload_images');
        Route::get('/product/images/{id}', 'Cms\ProductController@images');
        Route::get('/product/destroy/{id}', 'Cms\ProductController@destroy');
        Route::get('/product','Cms\ProductController@index')->name('cms.prodotti');

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


