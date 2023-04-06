<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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

Route::get('/admin/current',function () {
	return view('admin.current-projects');
  }
);
Route::get('/admin/aproject',function () {
	return view('admin.project');
  }
);

Route::get('/admin/qsaved',function () {
	return view('admin.saved-qoutations');
  }
);


Route::middleware(['employee'])->group(function (){
	Route::get('/notifications',"HomeController@notifications");
	Route::get('/', "attendanceController@index");
	Route::get('/home', "attendanceController@index");
	Route::resource('task','taskController');
	Route::get('/project/tasks/{id}',"projectController@mytask");
	Route::resource('attendance','attendanceController');
	Route::post('attendance/update/{id}','attendanceController@update')->name('attendance.update');


	Route::get('/responsibilities',"HomeController@responsibilities");


});

Route::get('getToken',function () {
      return csrf_token();

    }
);

Route::resource('role','roleController');
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
Route::middleware(['admin'])->group(function (){

Route::group([ 'prefix' => 'admin'], function() {
	Route::get('notifications',"HomeController@notifications");
		Route::resource('client','clientController');
       // Route::get('client/{id}/destroy','clientController@destroy');

       Route::get('/client/{id}/destroy','clientController@destroy');
       Route::get('/client/{id}/restore', 'clientController@restore');


       Route::get('admin/client/trashed/','clientController@trashed')->name('client.trashed');

		Route::get('pagination-client',"clientController@pagination_ajax")->name('pagination-client');


//----------USER--------------------------------------------------------------


		Route::resource('user','userController');
        Route::get('/user/{id}/restore/', 'userController@restore');
        Route::get('user/{id}/destroy','userController@destroy');
		Route::post('user.image','userController@changImage')->name('user.image');
        Route::get('admin/user/trashed/','userController@trashed')->name('user.trashed');

		Route::get('pagination-users',"userController@pagination_ajax")->name('pagination-users');

		/////////////////////////// project ////////////////

        Route::get('/project/{id}/destroy','projectController@destroy');
        Route::get('/project/{id}/restore', 'projectController@restore');

        Route::get('admin/project/trashed/','projectController@trashed')->name('project.trashed');




		Route::resource('project','projectController');
		Route::post('project_myupdate','projectController@update_employee')->name('project.myupdate');
		Route::get('pagination-projects',"projectController@pagination_ajax");
	    Route::get('current',"projectController@currentProject");
		Route::get('attendance/all', 'attendanceController@attendance')->name('attendance');


//-----------------------Department-----------------------------------
		Route::resource('department','departmentController');
        Route::get('/department/{id}/destroy','departmentController@destroy');
        Route::get('/department/{id}/restore', 'departmentController@restore');

        Route::get('admin/department/trashed/','departmentController@trashed')->name('department.trashed');
		Route::get('pagination-department',"departmentController@pagination_ajax");


		Route::resource('position','positionController');
        Route::get('/position/{id}/destroy','positionController@destroy');
        Route::get('/position/{id}/restore', 'positionController@restore');

        Route::get('admin/position/trashed/','positionController@trashed')->name('position.trashed');


		Route::resource('currency','currencyController');
		Route::get('home','HomeController@statics')->name('admin.dash');


		///                    quotation                 ///////////////////////////////
		Route::resource('quotation','quotationController');
		Route::post('setProject','quotationController@setProject')->name('setProject');
		Route::get('quotation/{id}/{q}/drop','quotationController@drop')->name('quotation.drop');
		Route::post('project/drop','projectController@drop')->name('project.drop');

		Route::post('myupdate','quotationController@update')->name('quotation.myupdate');

		Route::post('addEmployee','projectController@addEmployee')->name('addEmployee');
	    ////////////////////////////

		/////////////////////////// Salary ////////////////
		Route::resource('salary','salaryController');
		Route::post('employee.project.task', 'salaryController@tasks')->name('employee.project.task');
		Route::post('bonus.store','salaryController@bonus')->name('bonus.store');
		Route::post('salary.pay','salaryController@pay')->name('salary.pay');
		Route::post('salary.employee','salaryController@salary_employee')->name('salary.employee');
		Route::post('salary.overtime','salaryController@salary_overtime')->name('salary.overtime');

		///////////////////////// Reports ////////////////////////

		Route::get('reports/projects', 'projectController@report');
		Route::post('reports/bydate',   'HomeController@reportProject')->name('project.report');
		Route::post('reports/employeeR',   'HomeController@reportEmployee')->name('employee.report');
		Route::get('reports/salary',   'HomeController@salary');
		Route::get('reports/employee',  'projectController@employee');
		Route::get('reports/attendance',  'projectController@attendance');
		Route::get('reports/Ecard',  'HomeController@Ecard');
		Route::get('reports/inventory',  'HomeController@inventory');
		Route::get('project/{id}/show', 'projectController@cproject');
});
});






Route::resource('employee','employeeController');
Route::post('assign','employeeController@assign')->name('assign');

Route::resource('position','positionController');


Route::resource('client_project','clientProjectController');
Route::resource('employee_project','employeeProjectController');
Route::resource('project_review','projectReviewController');




Auth::routes();






