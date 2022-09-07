<?php
use Illuminate\Http\Request;


Route::get('/getEnvelopeByCategories','Api\ShopController@getenvelopes');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['jwt.auth','api-header']], function () {

    // all routes to protected resources are registered here
    Route::get('users/list', function(){
        $users = App\User::all();

        $response = ['success'=>true, 'data'=>$users];
        return response()->json($response, 201);
    });
});
Route::group(['middleware' => 'api-header'], function () {

    // The registration and login requests doesn't come with tokens
    // as users at that point have not been authenticated yet
    // Therefore the jwtMiddleware will be exclusive of them
    Route::post('user/login', 'React\UserController@login');
    Route::post('user/register', 'React\UserController@register');
});
