<?php
function path($name)
{
    $routes = [
        'home' => '/',
        'messages' => '/messages',
        'login' => '/login',
        'register' => '/register',
        'logout' => '/logout',
        'profile' => '/profile',
        'about' => '/about',
        'forgot_password' => '/forgot_password',
        'handle_forgot_password' => '/handle_forgot_password',
        'reset_password' => '/reset_password',
        'handle_reset_password' => '/handle_reset_password',
    ];

    return $routes[$name] ?? '#';
}
function includeNavbarAndFooter($route)
{
    $excludedRoutes = ['login', 'register', 'logout'];
    return !in_array($route, $excludedRoutes);
}

?>