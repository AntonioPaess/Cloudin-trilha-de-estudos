<?php
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

session_start();
include('dbcon.php');

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {

        $user = $auth->getUserByEmail("$email");

        try {

            $signInResult = $auth->signInWithEmailAndPassword($email, $password);
            $idTokenString = $signInResult->idToken();
            
            try {
                $verifiedIdToken = $auth->verifyIdToken($idTokenString);
                $uid = $verifiedIdToken->claims()->get('sub');

                $_SESSION['verified_user_id'] = $uid;
                $_SESSION['idTokenString'] = $idTokenString;
                
                $_SESSION['status'] = "Logged in successfuly.";
                header('Location: home.php');
                exit();

            } catch (FailedToVerifyToken $e) {
                echo 'The token is invalid: ' . $e->getMessage();
            }
        } catch (Exception $e) {
            $_SESSION['status'] = "Invalid email address or password.";
            header('Location: login.php');
            exit();
        }
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {

        $_SESSION['status'] = "Invalid email address or password.";
        header('Location: login.php');
        exit();
    }
} else {
    $_SESSION['status'] = "Invalid email address or password.";
    header('Location: login.php');
    exit();
}
