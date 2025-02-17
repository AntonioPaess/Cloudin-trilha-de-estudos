<?php

use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

session_start();

include('dbcon.php');

if (isset($_SESSION['verified_user_id'])) {

    $uid = $_SESSION['verified_user_id'];
    $idTokenString = $_SESSION['idTokenString'];


    try {
        $verifiedIdToken = $auth->verifyIdToken($idTokenString);
    } catch (FailedToVerifyToken $e) {
        $_SESSION['expiry_status'] = "Login Expired/Invalid. Login Again.";
        header('Location: logout.php');
        exit();
    }
} else {
    $_SESSION['status'] = "Login to acess this page.";
    header('Location: login.php');
    exit();
}
