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

if (isset($_SESSION['verified_user_id'])) {
    $uid = $_SESSION['verified_user_id'];
    $idTokenString = $_SESSION['idTokenString'];

    try {
        $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        $user = $auth->getUser($uid);
        
        $userRef = $database->getReference('users/'.$uid);
        $firstLogin = $userRef->getChild('first_login')->getValue();
        
        // Verifica se NÃO está na página de personalização
        if (!strpos($_SERVER['PHP_SELF'], 'store-personalize.php')) {
            if ($firstLogin === true) {
                // Se for primeiro login, redireciona para personalização
                header("Location: store-personalize.php");
                exit();
            }
        } 
        // Se estiver na página de personalização e NÃO for primeiro login
        else if (strpos($_SERVER['PHP_SELF'], 'store-personalize.php') && $firstLogin === false) {
            // Redireciona para mystore
            header("Location: mystore.php");
            exit();
        }
        
    } catch (FailedToVerifyToken $e) {
        $_SESSION['expiry_status'] = "Login Expired/Invalid. Login Again.";
        header('Location: logout.php');
        exit();
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        $_SESSION['status'] = "Não autorizado";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['status'] = "Login to access this page.";
    header('Location: login.php');
    exit();
}