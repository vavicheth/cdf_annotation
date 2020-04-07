<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

        Route::resource('departments', 'DepartmentsController', ['except' => ['create', 'edit']]);

        Route::resource('titles', 'TitlesController', ['except' => ['create', 'edit']]);

        Route::resource('positions', 'PositionsController', ['except' => ['create', 'edit']]);

        Route::resource('documents', 'DocumentsController', ['except' => ['create', 'edit']]);

        Route::resource('comments', 'CommentsController', ['except' => ['create', 'edit']]);

});
