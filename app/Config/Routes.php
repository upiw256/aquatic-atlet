<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth & Home
$routes->get('/', 'Home::index');
$routes->get('/team-detail/(:segment)', 'Home::teamDetail/$1');
$routes->get('/register', 'RegisterController::index');
$routes->post('/register', 'RegisterController::store');
$routes->get('/verify-email/(:segment)', 'RegisterController::verify/$1');
$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::authenticate');
$routes->get('/logout', 'LoginController::logout');
// Resend verification email
$routes->get('/resend-email', 'RegisterController::resendVerificationForm');
$routes->post('/resend-email', 'RegisterController::resendVerification');


// Dashboard umum
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'role:admin,owner,member,inspector']);
$routes->get('/member/profile', 'Member\ProfileController::index', ['filter' => 'role:admin,owner,member,inspector']);
$routes->post('/member/profile/save', 'Member\ProfileController::save', ['filter' => 'role:admin,owner,member,inspector']);
// Admin Group
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('dashboard', 'Admin\DashboardController::index');
    $routes->get('users/search', 'Admin\DashboardController::search');
    $routes->get('users', 'Admin\DashboardController::users');
    $routes->put('users/reset/(:segment)', 'Admin\DashboardController::usersReset/$1');
    $routes->put('users/updateRole/', 'Admin\DashboardController::makeAdmin');
    $routes->get('members', 'Admin\DashboardController::members');
    $routes->get('teams', 'Admin\DashboardController::teams');

    // Teams
    $routes->get('teams/create', 'Admin\TeamController::create');
    $routes->post('teams/store', 'Admin\TeamController::store');
    $routes->get('assign-owner/(:segment)', 'Admin\TeamController::assignOwnerForm/$1');
    $routes->post('assign-owner/(:segment)', 'Admin\TeamController::assignOwner/$1');
    $routes->get('teams/edit/(:segment)', 'Admin\TeamController::edit/$1');
    $routes->post('teams/update/(:segment)', 'Admin\TeamController::update/$1');
    $routes->delete('teams/delete/(:segment)', 'Admin\TeamController::delete/$1');
    $routes->get('teams/detail/(:segment)', 'Admin\TeamController::detail/$1');

    // Achievements
    $routes->get('achivements', 'Admin\AchivementController::index');
    $routes->get('achivement/create', 'Admin\AchivementController::create');
    $routes->post('achivement/save', 'Admin\AchivementController::store');
    $routes->get('achivements/edit/(:segment)', 'Admin\AchivementController::edit/$1');
    $routes->delete('achivements/delete/(:segment)', 'Admin\AchivementController::delete/$1');

    // Biodata
    $routes->get('biodata/edit/(:uuid)', 'Admin\BiodataController::edit/$1');
    $routes->post('biodata/save/(:uuid)', 'Admin\BiodataController::save/$1');
});

// Inspector Group
$routes->group('inspector', ['filter' => 'role:inspector'], function ($routes) {
    $routes->get('dashboard', 'Inspector\DashboardController::index');
    $routes->get('members', 'Admin\DashboardController::members');
    $routes->get('portfolio/(:segment)', 'Inspector\PortfolioController::pdf/$1');
    $routes->get('portfolio/preview/(:segment)', 'Inspector\PortfolioController::preview/$1');
    $routes->get('teams', 'Admin\DashboardController::teams');

});

// Owner Group
$routes->group('owner', ['filter' => 'role:owner'], function ($routes) {
    $routes->get('dashboard', 'Owner\DashboardController::index');
    $routes->post('dashboard/update-role', 'Owner\DashboardController::updateRole');
    $routes->post('dashboard/remove-member', 'Owner\DashboardController::removeMember');
    $routes->post('team/add', 'Owner\DashboardController::addMember');
    $routes->get('team/edit/(:segment)', 'Owner\DashboardController::edit/$1');
    $routes->post('team/update/(:segment)', 'Owner\DashboardController::update/$1');
    $routes->get('team', 'OwnerTeamController::index');

    // Profile
    $routes->get('profile', 'Owner\ProfileController::index');
    $routes->post('profile', 'Owner\ProfileController::update');
    $routes->post('profile/save', 'Owner\ProfileController::save');
});

// Member Group
$routes->group('member', ['filter' => 'role:member'], function ($routes) {
    $routes->get('dashboard', 'Member\DashboardController::index');
    $routes->get('accept-invite/(:segment)', 'Member\DashboardController::acceptInvite/$1');
    $routes->get('reject-invite/(:segment)', 'Member\DashboardController::rejectInvite/$1');
    $routes->get('leave-team', 'Member\DashboardController::leaveTeam');
});
