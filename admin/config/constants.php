<?php
session_start();
define('ROOT_URL', 'http://localhost/PHP/Providence-log/');

function isloggedIn() {
    if (isset($_SESSION['user'])) {
        return true;
    }
    else {
        return false;
    }
}


function dd($data) {
    var_dump($data);
    die;
}