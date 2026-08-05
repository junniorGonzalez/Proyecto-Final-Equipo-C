<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
// Invalidate navigation cached data in session so nav.config.json changes take effect
try {
    \Utilities\Nav::invalidateNavData();
} catch (Exception $e) {
    // ignore
}
// Redirect back to home
header('Location: index.php');
exit;
