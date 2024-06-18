<?php

namespace PHPMaker2021\sppsampah;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // report
    $app->any('/reportlist[/{id}]', ReportController::class . ':list')->add(PermissionMiddleware::class)->setName('reportlist-report-list'); // list
    $app->any('/reportadd[/{id}]', ReportController::class . ':add')->add(PermissionMiddleware::class)->setName('reportadd-report-add'); // add
    $app->any('/reportview[/{id}]', ReportController::class . ':view')->add(PermissionMiddleware::class)->setName('reportview-report-view'); // view
    $app->any('/reportedit[/{id}]', ReportController::class . ':edit')->add(PermissionMiddleware::class)->setName('reportedit-report-edit'); // edit
    $app->any('/reportdelete[/{id}]', ReportController::class . ':delete')->add(PermissionMiddleware::class)->setName('reportdelete-report-delete'); // delete
    $app->any('/reportsearch', ReportController::class . ':search')->add(PermissionMiddleware::class)->setName('reportsearch-report-search'); // search
    $app->group(
        '/report',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ReportController::class . ':list')->add(PermissionMiddleware::class)->setName('report/list-report-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ReportController::class . ':add')->add(PermissionMiddleware::class)->setName('report/add-report-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ReportController::class . ':view')->add(PermissionMiddleware::class)->setName('report/view-report-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ReportController::class . ':edit')->add(PermissionMiddleware::class)->setName('report/edit-report-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ReportController::class . ':delete')->add(PermissionMiddleware::class)->setName('report/delete-report-delete-2'); // delete
            $group->any('/' . Config("SEARCH_ACTION") . '', ReportController::class . ':search')->add(PermissionMiddleware::class)->setName('report/search-report-search-2'); // search
        }
    );

    // status
    $app->any('/statuslist[/{id}]', StatusController::class . ':list')->add(PermissionMiddleware::class)->setName('statuslist-status-list'); // list
    $app->any('/statusadd[/{id}]', StatusController::class . ':add')->add(PermissionMiddleware::class)->setName('statusadd-status-add'); // add
    $app->any('/statusview[/{id}]', StatusController::class . ':view')->add(PermissionMiddleware::class)->setName('statusview-status-view'); // view
    $app->any('/statusedit[/{id}]', StatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('statusedit-status-edit'); // edit
    $app->any('/statusdelete[/{id}]', StatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('statusdelete-status-delete'); // delete
    $app->group(
        '/status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', StatusController::class . ':list')->add(PermissionMiddleware::class)->setName('status/list-status-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', StatusController::class . ':add')->add(PermissionMiddleware::class)->setName('status/add-status-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', StatusController::class . ':view')->add(PermissionMiddleware::class)->setName('status/view-status-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', StatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('status/edit-status-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', StatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('status/delete-status-delete-2'); // delete
        }
    );

    // users
    $app->any('/userslist[/{id}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('userslist-users-list'); // list
    $app->any('/usersadd[/{id}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('usersadd-users-add'); // add
    $app->any('/usersview[/{id}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('usersview-users-view'); // view
    $app->any('/usersedit[/{id}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('usersedit-users-edit'); // edit
    $app->any('/usersdelete[/{id}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('usersdelete-users-delete'); // delete
    $app->group(
        '/users',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('users/list-users-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('users/add-users-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('users/view-users-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('users/edit-users-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('users/delete-users-delete-2'); // delete
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->any('/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // change_password
    $app->any('/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
