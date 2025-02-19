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
                
                // Busca informações do usuário no Firebase
                $userRef = $database->getReference('users/'.$uid);
                $firstLogin = $userRef->getChild('first_login')->getValue();
                
                // Busca informações da loja
                $storeRef = $database->getReference('stores/'.$uid);
                $storeInfo = $storeRef->getValue();
                
                // Verifica se tem um token na URL
                $store_token = isset($_GET['store']) ? $_GET['store'] : null;
                
                if ($store_token) {
                    // Se tiver token na URL, redireciona direto para a loja específica
                    header('Location: mystore.php?store=' . $store_token);
                    exit();
                } else if ($firstLogin === true) {
                    header("Location: store-personalize.php");
                    exit();
                } else {
                    if ($storeInfo && isset($storeInfo['store_token'])) {
                        header('Location: mystore.php?store=' . $storeInfo['store_token']);
                    } else {
                        header('Location: store-personalize.php');
                    }
                    exit();
                }

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
}
