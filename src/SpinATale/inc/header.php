<?php

    error_reporting(E_ALL);
    session_start();

function authenticate() {
    if(!isLoggedIn())
        header("Location:index.php");
}
function isLoggedIn() {
    return isset($_SESSION["login"]) && ($_SESSION["login"]===true);
}

?>