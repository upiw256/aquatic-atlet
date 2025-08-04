<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home dan Auth
$routes->get('/', 'Home::index');
$routes->get('/team-detail/(:segment)', 'Home::teamDetail/$1');
$routes->get('/register', 'RegisterController::index');
$routes->post('/register', 'RegisterController::store');

$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::authenticate');
$routes->get('/logout', 'LoginController::logout');

// Dashboard umum (jika mau redirect)
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'role:admin,owner,member']);

// Dashboard per role
$routes->get('/admin/dashboard', 'Admin\DashboardController::index', ['filter' => 'role:admin']);
$routes->get('/owner/dashboard', 'Owner\DashboardController::index', ['filter' => 'role:owner']);
$routes->get('/member/dashboard', 'Member\DashboardController::index', ['filter' => 'role:member']);

// Fitur lainnya
$routes->get('/admin', 'Admin\DashboardController::index', ['filter' => 'role:admin']);
$routes->get('/owner/team', 'OwnerTeamController::index', ['filter' => 'role:owner']);
// $routes->get('/member/profile', 'MemberController::profile', ['filter' => 'role:member']);

// Admin
$routes->get('/admin/members', 'Admin\DashboardController::members', ['filter' => 'role:admin']);
$routes->get('/admin/users', 'Admin\DashboardController::users', ['filter' => 'role:admin']);
$routes->put('/admin/users/reset/(:segment)', 'Admin\DashboardController::usersReset/$1', ['filter' => 'role:admin']);
$routes->put('/admin/makeadmin/(:segment)', 'Admin\DashboardController::makeAdmin/$1', ['filter' => 'role:admin']);
$routes->get('/admin/teams', 'Admin\DashboardController::teams', ['filter' => 'role:admin']);
$routes->get('/admin/teams/create', 'Admin\TeamController::create', ['filter' => 'role:admin']);
$routes->post('/admin/teams/store', 'Admin\TeamController::store', ['filter' => 'role:admin']);
$routes->get('/admin/assign-owner/(:segment)', 'Admin\TeamController::assignOwnerForm/$1', ['filter' => 'role:admin']);
$routes->post('/admin/assign-owner/(:segment)', 'Admin\TeamController::assignOwner/$1', ['filter' => 'role:admin']);

// Owner
$routes->post('/owner/dashboard/update-role', 'Owner\DashboardController::updateRole', ['filter' => 'role:owner']);
$routes->post('/owner/team/add', 'Owner\DashboardController::addMember', ['filter' => 'role:owner']);
$routes->post('/owner/dashboard/remove-member', 'Owner\DashboardController::removeMember', ['filter' => 'role:owner']);
$routes->get('/owner/team/edit/(:segment)', 'Owner\DashboardController::edit/$1', ['filter' => 'role:owner']);
$routes->post('/owner/team/update/(:segment)', 'Owner\DashboardController::update/$1', ['filter' => 'role:owner']);
$routes->get('/owner/profile', 'Owner\ProfileController::index', ['filter' => 'role:owner']);
$routes->post('/owner/profile', 'Owner\ProfileController::update', ['filter' => 'role:owner']);

// Admin bisa edit semua
$routes->get('/admin/biodata/edit/(:uuid)', 'Admin\BiodataController::edit/$1', ['filter' => 'role:admin']);
$routes->post('/admin/biodata/save/(:uuid)', 'Admin\BiodataController::save/$1', ['filter' => 'role:admin']);

// Owner
$routes->get('/owner/profile', 'Owner\ProfileController::index', ['filter' => 'role:owner']);
$routes->post('/owner/profile/save', 'Owner\ProfileController::save', ['filter' => 'role:owner']);

// Member
$routes->get('/member/profile', 'Member\ProfileController::index', ['filter' => 'role:member']);
$routes->post('/member/profile/save', 'Member\ProfileController::save', ['filter' => 'role:member']);
$routes->get('/member/accept-invite/(:segment)', 'Member\DashboardController::acceptInvite/$1', ['filter' => 'role:member']);
$routes->get('/member/reject-invite/(:segment)', 'Member\DashboardController::rejectInvite/$1', ['filter' => 'role:member']);
$routes->get('/member/leave-team', 'Member\DashboardController::leaveTeam', ['filter' => 'role:member']);
