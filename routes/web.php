<?php
Route::get('/', function () { return redirect('/admin/home'); });

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('auth.login');
Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');

    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('departments', 'Admin\DepartmentsController');
    Route::post('departments_mass_destroy', ['uses' => 'Admin\DepartmentsController@massDestroy', 'as' => 'departments.mass_destroy']);
    Route::post('departments_restore/{id}', ['uses' => 'Admin\DepartmentsController@restore', 'as' => 'departments.restore']);
    Route::delete('departments_perma_del/{id}', ['uses' => 'Admin\DepartmentsController@perma_del', 'as' => 'departments.perma_del']);
    Route::resource('titles', 'Admin\TitlesController');
    Route::post('titles_mass_destroy', ['uses' => 'Admin\TitlesController@massDestroy', 'as' => 'titles.mass_destroy']);
    Route::post('titles_restore/{id}', ['uses' => 'Admin\TitlesController@restore', 'as' => 'titles.restore']);
    Route::delete('titles_perma_del/{id}', ['uses' => 'Admin\TitlesController@perma_del', 'as' => 'titles.perma_del']);
    Route::resource('positions', 'Admin\PositionsController');
    Route::post('positions_mass_destroy', ['uses' => 'Admin\PositionsController@massDestroy', 'as' => 'positions.mass_destroy']);
    Route::post('positions_restore/{id}', ['uses' => 'Admin\PositionsController@restore', 'as' => 'positions.restore']);
    Route::delete('positions_perma_del/{id}', ['uses' => 'Admin\PositionsController@perma_del', 'as' => 'positions.perma_del']);
    Route::resource('user_actions', 'Admin\UserActionsController');
    Route::resource('documents', 'Admin\DocumentsController');
    Route::post('documents_mass_destroy', ['uses' => 'Admin\DocumentsController@massDestroy', 'as' => 'documents.mass_destroy']);
    Route::post('documents_restore/{id}', ['uses' => 'Admin\DocumentsController@restore', 'as' => 'documents.restore']);
    Route::delete('documents_perma_del/{id}', ['uses' => 'Admin\DocumentsController@perma_del', 'as' => 'documents.perma_del']);
    Route::resource('comments', 'Admin\CommentsController');
    Route::post('comments_mass_destroy', ['uses' => 'Admin\CommentsController@massDestroy', 'as' => 'comments.mass_destroy']);
    Route::post('comments_restore/{id}', ['uses' => 'Admin\CommentsController@restore', 'as' => 'comments.restore']);
    Route::delete('comments_perma_del/{id}', ['uses' => 'Admin\CommentsController@perma_del', 'as' => 'comments.perma_del']);
    Route::post('/spatie/media/upload', 'Admin\SpatieMediaController@create')->name('media.upload');
    Route::post('/spatie/media/remove', 'Admin\SpatieMediaController@destroy')->name('media.remove');

    Route::patch('comments_submit/{id}', ['uses' => 'Admin\CommentsController@updateStatus', 'as' => 'comments.submit']);
    Route::get('documents_user', ['uses' => 'Admin\DocumentsController@index_user', 'as' => 'documents.index_user']);

    Route::get('/documents/print/{id}','Admin\DocumentsController@print');
    Route::put('documents/approve/{id}', ['uses' => 'Admin\DocumentsController@approve', 'as' => 'documents.approve']);
    Route::get('/documents/view_pdf/{document_id}/{media_id}',['uses' => 'Admin\DocumentsController@view_pdf', 'as' => 'documents.view_pdf']);
    Route::post('/documents/save_pdf',['uses' => 'Admin\DocumentsController@save_pdf', 'as' => 'documents.save_pdf']);


});
