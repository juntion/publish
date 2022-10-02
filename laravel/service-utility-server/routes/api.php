<?php

use App\Http\Controllers\WorkSchedule\WorkScheduleController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', 'Auth\LoginController@login')->name('login.public');
Route::post('/auth/validateCodeEmail', 'Auth\LoginController@validateCodeEmail')->name('validateCodeEmail.public');
Route::post('/auth/refresh/{id}', 'Auth\LoginController@refreshToken')->name('refreshToken.public');
Route::post('/auth/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email.public');
Route::post('/auth/password/reset', 'Auth\ResetPasswordController@resetByName')->name('password.reset.public');
Route::post('/getUserByTicket', 'Auth\LoginController@getUserByTicket')->name('getUserByTicket.public');
// Rpc
Route::post('/rpc', 'Rpc\RpcController@rpc')->name('rpc.public');
// 附件下载
Route::any('/medias/download', 'MediasController@download')->name('medias.download.public');

Route::middleware('auth')->group(function () {
    Route::post('/webSocket/bind', 'GatewayWorkerController@bind')->name('webSocket.bind.public');
    Route::post('/auth/logout', 'Auth\LoginController@logout')->name('logout.public');
    Route::get('/amILogin', 'User\UsersController@amILogin')->name('amILogin.public');

    // 用户相关
    Route::get('/userInfo', 'User\UsersController@getLoginUser')->name('user.public');
    Route::get('/users/adminLevel', 'User\UsersController@adminLevel')->name('users.adminLevel.public');
    Route::get('/users', 'User\UsersController@index')->name('users.index');
    Route::post('/users', 'User\UsersController@store')->name('users.create');
    Route::get('/users/searchList', 'User\UsersController@searchList')->name('users.searchList.public');
    Route::get('/users/{id}', 'User\UsersController@show')->name('users.show');
    Route::delete('/users/{id}', 'User\UsersController@delete')->name('users.delete');
    Route::patch('/users/{id}', 'User\UsersController@update')->name('users.update');
    Route::post('/users/{id}/setDuty', 'User\UsersController@setDuty')->name('users.setDuty');
    Route::get('/user/loginHistory', 'User\UsersController@loginHistory')->name('user.loginHistory.public');
    Route::post('/users/{id}/resetPassword', 'User\UsersController@resetPassword')->name('users.resetPassword');
    Route::any('/users/userList/export', 'User\UsersController@userListExport')->name('users.userListExport.public');
    Route::get('/user/tempAuthCode', 'User\UsersController@tempAuthCode')->name('user.tempAuthCode.public');

    // 用户设置
    Route::patch('/users/setting/userInfo', 'User\SettingsController@update')->name('users.setting.update.public');
    Route::post('/users/setting/password', 'User\SettingsController@updatePassword')->name('users.setting.password.public');
    Route::post('/users/setting/avatar', 'User\SettingsController@setAvatar')->name('users.setting.avatar.public');
    Route::post('/users/setting/codeEmail', 'User\SettingsController@codeEmail')->name('users.setting.codeEmail.public');
    Route::get('/users/setting/assistantLevel', 'User\SettingsController@assistantLevel')->name('users.setting.assistantLevel.public');
    Route::post('/users/setting/assistantLevel', 'User\SettingsController@setAssistantLevel')->name('users.setting.setAssistantLevel.public');
    // 用户部门设置
    Route::post('/users/{id}/departments', 'User\DepartmentsController@setDefaultDepartment')->name('users.departments.setDefaultDepartment');
    Route::post('/users/departments', 'User\DepartmentsController@batchSetDefaultDepartment')->name('users.departments.batchSetDefaultDepartment');
    Route::post('/users/{id}/otherDepartments', 'User\DepartmentsController@setOtherDepartment')->name('users.departments.setOtherDepartment');
    // 用户首页设置
    Route::post('/users/{id}/homepages', 'User\HomepagesController@setHomepage')->name('users.homepages.setHomepage');
    Route::post('/users/homepages', 'User\HomepagesController@batchSetHomepage')->name('users.homepages.batchSetHomepage');
    Route::get('/users/{id}/homepages', 'User\HomepagesController@getHomepage')->name('users.homepages.getHomepage');
    // 用户职称设置
    Route::post('/users/{id}/positions', 'User\PositionsController@setPosition')->name('users.positions.setPosition');
    Route::post('/users/positions', 'User\PositionsController@batchSetPosition')->name('users.positions.batchSetPosition');
    // 用户侧边栏模板设置
    Route::post('/users/sidebars', 'User\SidebarsController@bindSidebarTemplate')->name('users.sidebars.bindSidebarTemplate');
    Route::post('/users/sidebars/pages/forbid', 'User\SidebarsController@forbidPage')->name('users.sidebars.pages.forbid');
    Route::get('/users/{id}/sidebars', 'User\SidebarsController@template')->name('users.sidebars.template');
    // 用户子系统设置
    Route::post('/users/{id}/subsystems/forbid', 'User\SubsystemsController@addUserForbid')->name('users.subsystems.forbid.add');
    Route::delete('/users/{id}/subsystems/forbid', 'User\SubsystemsController@removeUserForbid')->name('users.subsystems.forbid.delete');
    Route::get('/users/{id}/subsystems/forbid', 'User\SubsystemsController@getForbidUser')->name('users.subsystems.forbid');
    Route::get('/users/subsystems/{id}/allow', 'User\SubsystemsController@allowUsers')->name('users.subsystems.allow');
    // 用户权限设置
    Route::post('/users/{id}/permissions', 'User\PermissionsController@permissions')->name('users.permissions');
    Route::patch('/users/{id}/permissions', 'User\PermissionsController@syncPermissions')->name('users.permissions.syncPermissions');
    Route::get('/users/{user}/permissionLogs', 'User\PermissionsController@permissionLogs')->name('users.permissionLogs');
    // 用户角色设置
    Route::post('/users/{id}/roles', 'User\RolesController@roles')->name('users.roles');
    Route::patch('/users/{id}/roles', 'User\RolesController@syncRoles')->name('users.roles.syncRoles');
    Route::post('/users/attachRoles', 'User\RolesController@attachRoles')->name('users.roles.attachRoles');
    Route::post('/users/{id}/getRolesAndPermissions', 'User\RolesController@getRolesAndPermissions')->name('users.roles.getRolesAndPermissions');
    // Erp 权限设置
    Route::get('/users/erp/profiles', 'Erp\PermissionsController@profiles')->name('users.erp.profiles.public');
    Route::get('/users/{id}/erp/profiles', 'Erp\PermissionsController@userProfiles')->name('users.erp.userProfiles.public');
    Route::delete('/users/{id}/erp/profiles', 'Erp\PermissionsController@deleteProfile')->name('users.erp.deleteProfile');
    Route::post('/users/{id}/erp/profiles', 'Erp\PermissionsController@setProfiles')->name('users.erp.setProfiles');
    Route::post('/users/erp/profiles', 'Erp\PermissionsController@batchSetProfiles')->name('users.erp.batchSetProfiles');
    Route::get('/users/erp/canSetProfileUsers', 'Erp\PermissionsController@canSetProfileUsers')->name('users.erp.canSetProfileUsers.public');
    // 用户子公司设置
    Route::post('/users/{id}/companies', 'User\CompaniesController@setUserCompany')->name('users.companies.setUserCompany');
    Route::post('/users/companies', 'User\CompaniesController@batchSetUserCompany')->name('users.companies.batchSetUserCompany');

    // 部门相关
    Route::post('/departments', 'Department\DepartmentsController@store')->name('departments.store');
    Route::patch('/departments/{id}', 'Department\DepartmentsController@update')->name('departments.update');
    Route::delete('/departments/{id}', 'Department\DepartmentsController@delete')->name('departments.delete');
    Route::get('/departments/{id}/getUsers', 'Department\DepartmentsController@getUsers')->name('departments.getUsers.public');
    Route::get('/departments/{id}/getDepartments', 'Department\DepartmentsController@getDepartments')->name('departments.getDepartments.public');
    Route::post('/departments/getAllDepartments', 'Department\DepartmentsController@getAllDepartments')->name('departments.getAllDepartments.public');
    Route::get('/departments/tree', 'Department\DepartmentsController@tree')->name('departments.tree.public');
    Route::get('/departments/all', 'Department\DepartmentsController@all')->name('departments.all.public');

    // 职称相关
    Route::post('/positions', 'Position\PositionsController@store')->name('positions.store');
    Route::patch('/positions/{id}', 'Position\PositionsController@update')->name('positions.update');
    Route::delete('/positions/{id}', 'Position\PositionsController@delete')->name('positions.delete');
    Route::get('/positions/{id}/users', 'Position\PositionsController@users')->name('positions.users.public');
    Route::get('/positions/all', 'Position\PositionsController@all')->name('positions.all.public');
    Route::get('/positions', 'Position\PositionsController@list')->name('positions.list.public');

    // 子公司相关
    Route::get('/companies', 'Company\CompaniesController@index')->name('companies.index.public');

    // 子系统相关
    Route::patch('/subsystems/{id}', 'Subsystem\SubsystemsController@update')->name('subsystems.update');
    Route::get('/subsystems', 'Subsystem\SubsystemsController@list')->name('subsystems.list.public');
    Route::get('/subsystems/guardNames', 'Subsystem\SubsystemsController@guardNames')->name('subsystems.guardNames.public');
    Route::post('/subsystems/{id}/setHomepage', 'Subsystem\SubsystemsController@setHomepage')->name('subsystems.setHomepage');
    Route::post('/subsystems/{id}/setSidebar', 'Subsystem\SubsystemsController@setSidebar')->name('subsystems.setSidebar');
    Route::post('/subsystems/{id}/forbid/users', 'Subsystem\SubsystemsController@addForbidUsers')->name('subsystems.addForbidUsers');
    Route::delete('/subsystems/{id}/forbid/users', 'Subsystem\SubsystemsController@removeForbidUsers')->name('subsystems.removeForbidUsers');
    Route::get('/subsystems/{id}/forbid/users', 'Subsystem\SubsystemsController@forbidUsers')->name('subsystems.forbidUsers');

    // 页面相关
    Route::get('/pages', 'Page\PagesController@list')->name('pages.list.public');
    Route::get('/pages/all', 'Page\PagesController@all')->name('pages.all.public');
    Route::post('/pages/homepages', 'Page\PagesController@homepages')->name('pages.homepages.public');
    Route::patch('/pages/{id}', 'Page\PagesController@update')->name('pages.update');

    // 侧边栏相关
    // 侧边栏模板
    Route::post('/sidebars/templates', 'Sidebar\SidebarsTemplatesController@store')->name('sidebars.templates.store');
    Route::patch('/sidebars/templates/{id}', 'Sidebar\SidebarsTemplatesController@update')->name('sidebars.templates.update');
    Route::delete('/sidebars/templates/{id}', 'Sidebar\SidebarsTemplatesController@delete')->name('sidebars.templates.delete');
    Route::post('/sidebars/templates/all', 'Sidebar\SidebarsTemplatesController@all')->name('sidebars.templates.all.public');
    Route::get('/sidebars/templates', 'Sidebar\SidebarsTemplatesController@list')->name('sidebars.templates.list.public');
    Route::get('/sidebars/templates/{id}/categories', 'Sidebar\SidebarsTemplatesController@categories')->name('sidebars.templates.categories');
    Route::get('/sidebars/templates/{id}/trees', 'Sidebar\SidebarsTemplatesController@trees')->name('sidebars.templates.trees');
    Route::get('/sidebars/templates/{id}/pages', 'Sidebar\SidebarsTemplatesController@pages')->name('sidebars.templates.pages');
    // 侧边栏分类
    Route::post('/sidebars/categories', 'Sidebar\SidebarsCategoriesController@store')->name('sidebars.categories.store');
    Route::patch('/sidebars/categories/{id}', 'Sidebar\SidebarsCategoriesController@update')->name('sidebars.categories.update');
    Route::delete('/sidebars/categories/{id}', 'Sidebar\SidebarsCategoriesController@delete')->name('sidebars.categories.delete');
    Route::post('/sidebars/categories/{id}/pages', 'Sidebar\SidebarsCategoriesController@addPages')->name('sidebars.categories.addPages');
    Route::delete('/sidebars/categories/{id}/pages', 'Sidebar\SidebarsCategoriesController@removePages')->name('sidebars.categories.removePages');
    Route::post('/sidebars/categories/{id}/sort', 'Sidebar\SidebarsCategoriesController@sort')->name('sidebars.categories.sort');
    Route::post('/sidebars/categories/batchSort', 'Sidebar\SidebarsCategoriesController@batchSort')->name('sidebars.categories.batchSort');
    Route::post('/sidebars/categories/{id}/pages/{pid}/sort', 'Sidebar\SidebarsCategoriesController@pageSort')->name('sidebars.categories.pages.sort');
    Route::post('/sidebars/categories/pages/batchSort', 'Sidebar\SidebarsCategoriesController@batchPageSort')->name('sidebars.categories.pages.batchSort');

    // 权限管理
    Route::get('/permissions', 'Permission\PermissionsController@index')->name('permissions.list');
    Route::patch('/permissions/{id}', 'Permission\PermissionsController@update')->name('permissions.update');
    Route::post('/permissions/groups', 'Permission\PermissionsController@group')->name('permissions.group');
    //角色管理
    Route::post('/roles', 'Permission\RolesController@store')->name('permissions.roles.store');
    Route::patch('/roles/{id}', 'Permission\RolesController@update')->name('permissions.roles.update');
    Route::delete('/roles/{id}', 'Permission\RolesController@delete')->name('permissions.roles.delete');
    Route::get('/roles', 'Permission\RolesController@list')->name('permissions.roles.list');
    Route::get('/roles/export', 'Permission\RolesController@export')->name('permissions.roles.export');
    Route::post('/roles/all', 'Permission\RolesController@all')->name('permissions.roles.all');
    Route::patch('/roles/{id}/permissions', 'Permission\RolesController@givePermissions')->name('permissions.roles.givePermissions');
    Route::get('/roles/{id}/permissions', 'Permission\RolesController@getPermissions')->name('permissions.roles.getPermissions');
    Route::get('/roles/{role}/users', 'Permission\RolesController@getUsers')->name('permissions.roles.getUsers');
    Route::get('/roles/{role}/logs', 'Permission\RolesController@logs')->name('permissions.roles.logs');

    Route::post('/medias/upload', 'MediasController@upload')->name('medias.upload.public');
    // Route::delete('/medias/{media}', 'MediasController@delete')->name('medias.delete');

    // 公司相关信息管理
    Route::name('company.')->prefix("company")->namespace("Company")->group(function () {
        Route::get("/list", "CompanyController@list")->name("list.public");
        Route::post("/store", "CompanyController@addCompany")->name("add");
        Route::post("/{id}", "CompanyController@updateCompany")->name("update");
        Route::get("/tree", "CompanyController@getTreeData")->name("tree");
        Route::post("/{id}/status", "CompanyController@changeStatus")->name("changeStatus");
        Route::get("/{id}/status", "CompanyController@companyStatusLog")->name("status");
        Route::post("/{id}/registryInfo", "CompanyController@updateCompanyRegistry")->name("registry.update");
        Route::post("/{id}/office", "CompanyController@updateCompanyOffice")->name("office.update");
        Route::post("/office/{id}/status", "CompanyController@updateOfficeStatus")->name("office.status.update");
        Route::get("/office/{id}/statusLog", "CompanyController@officeStatusLogs")->name("office.statusLogs");
        Route::post("/warehouse/{id}/status", "CompanyController@updateWarehouseStatus")->name("warehouse.status.update");
        Route::get("/warehouse/{id}/statusLog", "CompanyController@warehouseStatusLogs")->name("warehouse.statusLogs");
        Route::post("/{id}/warehouse", "CompanyController@updateCompanyWarehouse")->name("warehouse.update");
        Route::post("/bank/{id}/status", "CompanyController@updateBankStatus")->name("bank.status.update");
        Route::get("/bank/{id}/statusLog", "CompanyController@bankLogs")->name("bank.statusLogs");
        Route::post("/{id}/bank", "CompanyController@updatePayInfo")->name("bank.update");
        Route::get("/country", "CompanyController@getCountry")->name("getCountry.public");
        Route::get("/currencies", "CompanyController@getCurrencies")->name("getCurrencies.public");
        Route::get("/all/info", "CompanyController@allInfo")->name("getAllCompanyInfo.public");
        Route::get("/{id}/info", "CompanyController@getCompanyInfo")->name("getInfo");
        Route::get("/{id}/office", "CompanyController@getCompanyOffice")->name("getCompanyOffice.public");
        Route::get("/{id}/warehouse", "CompanyController@getCompanyWarehouse")->name("getCompanyWarehouse.public");
        Route::get("/{id}/bank", "CompanyController@getCompanyBank")->name("getCompanyBank.public");
        Route::get("/type/all", "CompanyController@getTypeCompany")->name("getTypeCompany.public");
    });

    // 班次管理
    Route::get('/schedules/{year}/{month}', [WorkScheduleController::class, 'scheduleList'])->name('schedules.list.public');
    Route::patch('/schedules/{schedule}', [WorkScheduleController::class, 'update'])->name('schedules.update');

});

Route::any('/departments/export', 'Department\DepartmentsController@export')->name('departments.export.public');
