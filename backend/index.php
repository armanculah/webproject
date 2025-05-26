<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'rest/services/AuthService.php'; // Updated to match the new file name
require "middleware/AuthMiddleware.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Register services and middleware
Flight::register('auth_service', "AuthService");
Flight::register('auth_middleware', "AuthMiddleware");


// Global middleware for token verification
Flight::route('/*', function() {
    if (
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0
    ) {
        return true;
    } else {
        try {
            $token = Flight::request()->getHeader("Authentication");
            if (Flight::auth_middleware()->verifyToken($token)) {
                return true;
            }
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});

// Include route files
require_once __DIR__ .'/rest/routes/AuthRoutes.php';
require_once __DIR__ .'/rest/routes/routes.php';

// Start the FlightPHP framework
Flight::start();
