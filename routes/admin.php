<?php

Route::get('/', 'BackendController@index')
    ->name('home');
Route::get('/routes/search', 'AjaxController@routesSearch')
    ->name('routes.search');
Route::get('/tags/search', 'AjaxController@tagsSearch')
    ->name('tags.search');
Route::post('/images/upload', 'AjaxController@imageUpload')
    ->name('images.upload');

Route::group(
    ['middleware' => ['can:manage form_settings']],
    function () {
        Route::post('form-setting', 'FormSettingController@store')
            ->name('form_setting.store');
        Route::match(['PUT', 'PATCH'], 'form-setting/{form_setting}',
            'FormSettingController@update')->name('form_setting.update');
        Route::delete('form-setting/{form_setting}', 'FormSettingController@destroy')
            ->name('form_setting.destroy');

        Route::post('form-setting/search', 'FormSettingController@search')->name(
            'form_setting.search'
        );
    }
);

Route::group(
    ['middleware' => ['can:manage form_submissions']],
    function () {
        Route::delete('form-submission/{form_submission}', 'FormSubmissionController@destroy')
            ->name('form_submission.destroy');

        Route::post('form_submission/search', 'FormSubmissionController@search')->name(
            'form_submission.search'
        );

        Route::post('form_submission/batch-action',
            'FormSubmissionController@batchAction')->name(
            'form_submission.batch-action'
        );
    }
);

Route::group(
    ['middleware' => ['can:manage users']],
    function () {
        Route::post('user', 'UserController@store')
          ->name('user.store');
        Route::match(['PUT', 'PATCH'], 'user/{user}',
          'UserController@update')->name('user.update');
        Route::delete('user/{user}', 'UserController@destroy')
          ->name('user.destroy');

        Route::post('user/search', 'UserController@search')->name(
            'user.search'
        );

        Route::post('user/batch-action',
            'UserController@batchAction')->name(
            'user.batch-action'
        );

        Route::get('user/{user}/login-as', 'UserController@loginAs')
            ->name(
                'user.login-as'
            );
    }
);

Route::group(
    ['middleware' => ['can:manage roles']],
    function () {
        Route::post('role', 'RoleController@store')
          ->name('role.store');
        Route::match(['PUT', 'PATCH'], 'role/{role}',
          'RoleController@update')->name('role.update');
        Route::delete('role/{role}', 'RoleController@destroy')
          ->name('role.destroy');

        Route::post('role/search', 'RoleController@search')->name(
            'role.search'
        );
    }
);

Route::group(
    ['middleware' => ['can:manage metas']],
    function () {
        Route::post('meta', 'MetaController@store')
            ->name('meta.store');
        Route::match(['PUT', 'PATCH'], 'meta/{meta}',
            'MetaController@update')->name('meta.update');
        Route::delete('meta/{meta}', 'MetaController@destroy')
            ->name('meta.destroy');

        Route::post('meta/search', 'MetaController@search')->name(
            'meta.search'
        );

        Route::post('meta/batch-action',
            'MetaController@batchAction')->name(
            'meta.batch-action'
        );
    }
);

Route::group(
    ['middleware' => ['can:manage redirections']],
    function () {
        Route::post('redirection', 'RedirectionController@store')
            ->name('redirection.store');
        Route::match(['PUT', 'PATCH'], 'redirection/{redirection}',
            'RedirectionController@update')->name('redirection.update');
        Route::delete('redirection/{redirection}', 'RedirectionController@destroy')
            ->name('redirection.destroy');

        Route::post('redirection/search', 'RedirectionController@search')->name(
            'redirection.search'
        );

        Route::post('redirection/batch-action',
            'RedirectionController@batchAction')->name(
            'redirection.batch-action'
        );

        Route::post('redirection/import', 'RedirectionController@import')
            ->name('redirection.import');
    }
);

if (config('blog.enabled')) {
    Route::group(
        ['middleware' => ['can:manage own posts']],
        function () {
            Route::post('post', 'PostController@store')
                ->name('post.store');
            Route::match(['PUT', 'PATCH'], 'post/{post}',
                'PostController@update')->name('post.update')
                ->middleware('can:update,post');
            Route::delete('post/{post}', 'PostController@destroy')
                ->name('post.destroy')
                ->middleware('can:update,post');

            Route::post('post/search', 'PostController@search')
                ->name(
                    'post.search'
                );

            Route::post('post/batch-action',
                'PostController@batchAction')->name(
                'post.batch-action'
            );
        }
    );
}
