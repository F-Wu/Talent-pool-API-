<?php

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

Route::get('city', 'UserController@city');//城市
Route::get('occupation', 'UserController@occupation');//职业
Route::get('search', 'UserController@search');//搜索  城市、职业为关键字
Route::get('collection', 'UserController@collection');//收藏
Route::get('hottest', 'UserController@Hottest');//最热
Route::get('newest', 'UserController@newest');//最新
Route::get('details', 'UserController@details');//详情
Route::get('tree/occupation', 'AdminController@get_all_data');//职业树
Route::post('user/login', 'UserController@userLogo');//登录
Route::post('user/add', 'UserController@userAdd');//登录
Route::post('get/collection', 'UserController@collectionGet');//收藏
//管理员 控制台
Route::post('login', 'AdminController@login');//登录
Route::post('logout', 'AdminController@logout');//退出
Route::get("user/info",'AdminController@userInfo');//验证 occupation
Route::get("user/search",'AdminController@search');//搜索
Route::get("user/admin",'AdminController@adminGET');//搜索
//修改 更新数据put
Route::put("Modify/occupation",'AdminController@occupationModify');//修改职业
Route::put("Modify/information",'AdminController@informationModify');//个人信息
Route::put("Modify/education",'AdminController@educationModify');//教育
Route::put("Modify/expect",'AdminController@expectModify');//求职期望
Route::put("Modify/project",'AdminController@projectModify');//项目经历
Route::put("Modify/work",'AdminController@work_experienceModify');//工作经历
Route::put("Modify/admin",'AdminController@adminModify');//管理员
//添加
//Route::post("Add/occupation",'AdminController@informationAdd');//修改职业
Route::post("Add/information",'AdminController@informationAdd');//个人信息
Route::post("Add/education",'AdminController@educationAdd');//教育
Route::post("Add/expect",'AdminController@expectAdd');//求职期望
Route::post("Add/project",'AdminController@projectAdd');//项目经历
Route::post("Add/work",'AdminController@work_experienceAdd');//工作经历
Route::post("Add/admin",'AdminController@adminAdd');//管理员
Route::post("Add/occupation",'AdminController@occupationAdd');//职业
//删除
Route::delete("Remove/information",'AdminController@informationRemove');//主表  个人信息
Route::delete("Remove/admin",'AdminController@adminRemove');//管理员
Route::delete("Remove/occupation",'AdminController@occupationRemove');//职业

Route::get("Hotoccupation",'AdminController@Hotoccupation');//热门职业
Route::get("Hotcity",'AdminController@Hotcity');//热门城市
Route::get("users",'AdminController@users');//统计一年内注册用户数量按月份进行分组
Route::get("totals",'AdminController@totalNumber');//总用户数
//获取数据x
Route::get("get/education",'AdminController@Geteducation');
Route::get("get/expect",'AdminController@Getexpect');
Route::get("get/work",'AdminController@Getwork_experience');
Route::get("get/project",'AdminController@Getproject');
Route::get("get/occupationID",'AdminController@occupationID');
