<?php

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
/**
 * api
 */
Route::get('api/user',function(){
	return view('api.user.user');
});
Route::get('api/show',function(){
	return view('api.user.show');
});
Route::get('api/upd',function(){
	return view('api.user.upd');
});
Route::get('api/upload',function(){
	return view('api.user.upload');
});
Route::get('api/ce_weather',function(){
    return view('api.user.weather');
});
//文件上传
Route::post('api/upp','api\UserController@upp');
//添加
Route::post('api/add','api\UserController@add');
//展示
Route::get('api/list','api\UserController@list');
//删除
Route::get('api/delete','api\UserController@delete');
//修改
Route::get('api/update','api\UserController@update');
Route::get('api/update_do','api\UserController@update_do');
//天气
Route::get('api/weather','api\UserController@weather');

/**
 * 资源控制器
 */
Route::resource('api/test', 'api\PostController');

/**
 *  周考
 */
Route::resource('api/kao_goods', 'api\GoodsController');
Route::get('api/kao_user',function(){
    return view('api.kao.user');
});
Route::get('api/kao_index',function(){
    return view('api.kao.index');
});












//主页面
// Route::view('/','welcome',['name' => '林林']);
//添加页面
Route::get('student/add','HaController@add');
//执行添加
Route::post('student/add_do','HaController@add_do');
//列表展示
Route::get('student/list','HaController@lists');
//删除
Route::get('student/delete/{id}','HaController@delete');
//邮箱
Route::get('mail/index','MailController@index');

//友情链接
Route::prefix('kao')->group(function () {
	//添加
 	Route::get('index','KaoController@index');
    Route::get('new','KaoController@new');


    Route::get('wechat','KaoController@wechat');
    Route::get('wechat_list','KaoController@wechat_list');
    Route::post('wechat_list_do','KaoController@wechat_list_do');
    Route::get('wechat_token','KaoController@wechat_token');


    Route::get('ce_wechat','KaoController@ce_wechat');

 	//执行添加
 	Route::post('add_do','KaoController@add_do',function(){

 	})->name('do');
 	//列表展示
 	Route::get('list','KaoController@kao_list');
 	//删除
 	Route::get('delete','KaoController@kao_del')->name('del');
 	//修改
 	Route::get('update/{id}','KaoController@update');
 	Route::post('update_do/{id}','KaoController@update_do');
 	//唯一性
 	Route::post('wei','KaoController@wei')->name('wei');
});






//后台路由分组
Route::prefix('goods')->middleware('checklogin')->group(function () {
  	//商品模块a

	Route::get('index','admin\GoodsController@index');
	//头部
	Route::get('head','admin\GoodsController@head')->name('head');
	//左边
	Route::get('left','admin\GoodsController@left')->name('left');
	//中间
	Route::get('main','admin\GoodsController@main')->name('main');
	//管理员管理
	Route::get('goods_user','admin\Goods_userController@index')->name('goods_user');
	//管理员添加
	Route::post('user_do','admin\Goods_userController@user_do',function(){

	})->name('user_do');


	//品牌管理
	Route::get('brand','admin\Goods_brandController@index')->name('goods_brand');
	//品牌添加
	Route::post('brand_do','admin\Goods_brandController@brand_do',function(){

	})->name('brand_do');
	//品牌展示
	Route::get('brand_list','admin\Goods_brandController@brand_list')->name('brand_list');
	//品牌删除
	Route::get('brand_delete/{id}','admin\Goods_brandController@brand_delete');
	//品牌修改
	Route::get('brand_update/{id}','admin\Goods_brandController@brand_update');
	Route::post('brand_update_do/{id}','admin\Goods_brandController@brand_update_do');


	//分类管理
	Route::get('cat','admin\Goods_catController@index')->name('goods_cat');
	//分类添加
	Route::post('cat_do','admin\Goods_catController@cat_do',function(){

	})->name('cat_do');
	//分类展示
	Route::get('cat_list','admin\Goods_catController@cat_list')->name('cat_list');


	//商品管理
	Route::get('goods','admin\Goods_goodsController@index')->name('goods');
	//商品添加
	Route::post('goods_do','admin\Goods_goodsController@goods_do',function(){

	})->name('goods_do');
	//商品展示
	Route::get('goods_list','admin\Goods_goodsController@goods_list')->name('goods_list');
	//商品修改
	Route::get('goods_update/{id}','admin\Goods_goodsController@goods_update');
	Route::post('goods_update_do/{id}','admin\Goods_goodsController@goods_update_do');
});

	//登录
	Route::get('goods/login','admin\LoginController@login')->name('login');
	Route::post('goods/login_do','admin\LoginController@login_do',function(){

	})->name('login_do');
	//退出
	Route::get('goods/tui','admin\LoginController@tui')->name('tui');



//登录注册
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');




//前台路由分组	->middleware('checklogin')
Route::prefix('/')->group(function () {
	//首页
	Route::get('/','index\IndexController@index');
	//分类展示商品
	Route::get('prolist/{id}','index\IndexController@prolist');
	Route::get('prolist_do','index\IndexController@prolist_do');
	//商品详情
	Route::get('proinfo/{id}','index\IndexController@proinfo');
	//加入购物车
	Route::get('car/{id}','index\IndexController@car');
	//购物车展示
	Route::get('car_do','index\IndexController@car_do');
	Route::get('getmoney','index\IndexController@getmoney');
	//批量删除
	Route::get('car_del','index\IndexController@car_del');
	//收获地址
	Route::get('address','index\IndexController@address');
	//添加收获地址
	Route::post('region','index\IndexController@region');
	Route::post('address_do','index\IndexController@address_do');
	//结算
	Route::get('pay','index\IndexController@pay');
	Route::get('pay_do','index\IndexController@pay_do');
	//提交订单
	Route::get('success','index\IndexController@success');
});
//前台登录
Route::get('login','index\LoginController@index');
Route::post('login_do','index\LoginController@login_do');
/**
 * 网页授权
 */
//网页授权
Route::get('wechat','index\LoginController@wechat');//微信登录
Route::get('code','index\LoginController@code');//微信code
//注册
Route::get('reg','index\LoginController@reg');
Route::post('reg_do','index\LoginController@reg_do');
Route::post('email','index\LoginController@email');

//考试
Route::prefix('kkk')->group(function () {
	//添加
	Route::get('add','KkkController@add');
	//执行添加
	Route::post('add_do','KkkController@add_do');
	//列表展示
	Route::get('list','KkkController@list');
	//删除
	Route::get('del/{id}','KkkController@del');
	//修改
	Route::get('update/{id}','KkkController@update');
	//执行修改
	Route::post('update_do/{id}','KkkController@update_do');
});
/**
 * 9.16周考		->middleware('grant')	中间件中有二维码自定义菜单
 */
Route::prefix('grant')->group(function () {

	//微信授权
	Route::get('grant','GrantController@grant');
	Route::get('code','GrantController@code');
	Route::get('massage/{v}','GrantController@massage');
	///二维码
	Route::get('qrcode/{id}','GrantController@qrcode');
	Route::get('list','GrantController@list');
	//自定义菜单
	Route::get('menu','GrantController@menu');
	//表单添加自定义菜单
	Route::get('menu_add','GrantController@menu_add');
	Route::get('menu_menu','GrantController@menu_menu');
	Route::post('menu_do','GrantController@menu_do');
	Route::get('menu_del/{id}','GrantController@menu_del');

	/**
	 * jssdk
	 */
	Route::get('jssdk','GrantController@jssdk');
});
//登录
Route::get('grant/login','GrantController@login');
Route::post('grant/login_do','GrantController@login_do');





//新闻
Route::prefix('news')->middleware('checklogin')->group(function () {
	//添加
	Route::get('add','NewsController@add');
	//执行添加
	Route::post('add_do','NewsController@add_do');
	//列表展示
	Route::get('list','NewsController@list');
	//文字详细信息
	Route::get('list_do/{id}','NewsController@list_do');
	//点赞
	Route::get('give','NewsController@give');
	//取消点赞
	Route::get('cancel','NewsController@cancel');
});
//竞猜
Route::prefix('team')->group(function () {
	//添加
	Route::get('add','TeamController@add');
	//执行添加
	Route::post('add_do','TeamController@add_do');
	//列表展示
	Route::get('list','TeamController@list');
	//竞猜展示
	Route::get('team','TeamController@team');
	//我要竞猜
	Route::get('want_guess/{id}','TeamController@want_guess');
	Route::post('want_guess_do','TeamController@want_guess_do');
	//查看结果
	Route::get('guess/{id}','TeamController@guess');
});
Route::prefix('ware')->middleware('ware')->group(function () {
	//info
	Route::get('info','WareController@info');
	//用户
	Route::get('user_add','WareController@user_add');
	Route::post('user_add_do','WareController@user_add_do');
	Route::get('user_list','WareController@user_list');
	Route::get('user_upd/{id}','WareController@user_upd');
	Route::post('user_upd_do/{id}','WareController@user_upd_do');
	//货物
	Route::get('goods_add','WareController@goods_add');
	Route::post('goods_add_do','WareController@goods_add_do');
	Route::get('goods_list','WareController@goods_list');
	Route::get('goods_upd/{id}','WareController@goods_upd');
	Route::post('goods_upd_do/{id}','WareController@goods_upd_do');
	//记录
	Route::get('list','WareController@list');
});
//登录
	Route::get('ware/login','WareController@login');
	Route::post('ware/login_do','WareController@login_do');
//微信
// Route::get('wechat','WechatController@wechat');
Route::get('access_token','WechatController@access_token');
// Route::get('openid','WechatController@openid');
//网页授权
// Route::get('wechat/login','Wechat_loginController@login');//微信登录
	/**
	 * 文件上传
	 */
Route::get('upload','WechatController@upload');
Route::post('do_upload','WechatController@do_upload');
Route::get('source','WechatController@wechat_source');


/**
 * //post
 */

Route::get('guzzle_upload','WechatController@guzzle_upload');
Route::post('curl_post','WechatController@curl_post');
//清除api
Route::get('clear','WechatController@clear');
//获取资源
Route::get('material/{id}','WechatController@material');
/**
 * 用户标签
 */
///用户标签
Route::get('user','Wechat_userController@user');
Route::post('user_do','Wechat_userController@user_do');
//列表展示
Route::get('user_list','Wechat_userController@user_list');
//修改
Route::get('update/{id}/{name}','Wechat_userController@update');
Route::post('update_do/{id}','Wechat_userController@update_do');
//删除
Route::get('delete/{id}','Wechat_userController@delete');
//粉丝
Route::get('Fans/{id}/{name}','Wechat_userController@fans');
//打标签
Route::get('user_openid/{id}','Wechat_userController@user_openid');
Route::post('user_openid_do/{id}','Wechat_userController@user_openid_do');
//推送消息
Route::get('push/{id}','Wechat_userController@push');
Route::post('push_do/{id}','Wechat_userController@push_do');
///用户下的标签
Route::get('user_label/{v}','Wechat_userController@user_label');
//发送模板消息
Route::get('template','Wechat_userController@template');
//crontab
Route::prefix('crontab')->group(function () {
	//网页授权
	Route::get('login','CrontabController@login');
	//获取code码
	Route::get('code','CrontabController@code');
	//添加
	Route::get('index','CrontabController@index');
	//展示
	Route::get('list','CrontabController@list');
	//添加用户标签
	Route::get('add','CrontabController@add');
	Route::post('add_do','CrontabController@add_do');
	Route::get('tag_list','CrontabController@tag_list');
	Route::get('getidlist/{v}','CrontabController@getidlist');
	Route::get('news/{v}','CrontabController@news');
});

/**
 * hadmin
 */
Route::prefix('hadmin')->group(function () {
	//后台展示页面
	Route::get('index','hadmin\AdminController@index');
	//后台主页
	Route::get('index_v1','hadmin\AdminController@index_v1');
    //查询天气
    Route::get('weather','hadmin\AdminController@weather');


	//商品分类
    Route::get('goods_cat','hadmin\Goods_catController@goods_cat');
    Route::get('only','hadmin\Goods_catController@only');
    Route::post('goods_cat_do','hadmin\Goods_catController@goods_cat_do');
    //分类展示
    Route::get('goods_cat_list','hadmin\Goods_catController@goods_cat_list');

    //类型
    Route::get('goods_type','hadmin\Goods_typeController@goods_type');
    Route::post('goods_type_do','hadmin\Goods_typeController@goods_type_do');
    Route::get('goods_type_list','hadmin\Goods_typeController@goods_type_list');



    //属性
    Route::get('goods_attribute','hadmin\Goods_attributeController@goods_attribute');
    Route::post('goods_attribute_do','hadmin\Goods_attributeController@goods_attribute_do');
    Route::get('goods_attribute_list','hadmin\Goods_attributeController@goods_attribute_list');
    Route::get('search','hadmin\Goods_attributeController@search');


    //商品
    Route::get('goods','hadmin\GoodsController@goods');//商品添加
    Route::post('goods_do','hadmin\GoodsController@goods_do');
    //库存添加
    Route::get('goods_list/{goods_id}','hadmin\GoodsController@goods_list');
    //商品
    Route::post('goods_stock','hadmin\GoodsController@goods_stock');
    Route::get('goods_stock_list','hadmin\GoodsController@goods_stock_list');
    Route::get('say','hadmin\GoodsController@say');
    //change
    Route::get('goods_change','hadmin\GoodsController@goods_change');

});

/**
 * hadmin前台
 */
Route::prefix('hadmin/api')->middleware('api_index')->group(function () {

    //登录
    Route::get('login','hadmin\index\LoginController@login');
    //检验token
    Route::get('token','hadmin\index\LoginController@token');

    //前台首页
    Route::get('index','hadmin\index\IndexController@index');
    //商品详情
    Route::get('goods_details','hadmin\index\IndexController@goods_details');
    //商品分类
    Route::get('goods_cat','hadmin\index\IndexController@goods_cat');
    /**
     * 分组
     */
    Route::middleware('token')->group(function () {
        //购物车
        Route::get('goods_cart','hadmin\index\IndexController@goods_cart');
        //购物车展示
        Route::get('goods_cart_list','hadmin\index\IndexController@goods_cart_list');
    });


});
/**
 * 前台登录
 */


/**
 * hadmin登录
 */
Route::get('hadmin/login','hadmin\LoginController@login');
Route::post('hadmin/login_do','hadmin\LoginController@login_do');
//发送微信验证码
Route::get('hadmin/send','hadmin\LoginController@send');
//绑定账号
Route::get('hadmin/account','hadmin\LoginController@account');
Route::post('hadmin/account_do','hadmin\LoginController@account_do');
//扫码登录
Route::get('hadmin/code','hadmin\LoginController@code');
Route::get('hadmin/code_do','hadmin\LoginController@code_do');
//登录状态
Route::get('hadmin/check_wechat_login','hadmin\LoginController@check_wechat_login');
