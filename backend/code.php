<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('dbcon.php');

if(isset($_POST['register_btn']))
{
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userProperties = [
        'email' => $email,
        'emailVerified' => false,
        'phoneNumber' => '+55'.$phone,
        'password' => $password,
        'displayName' => $full_name,
    ];
    
    $createdUser = $auth->createUser($userProperties);

    if($createdUser)
    {
        $_SESSION['status'] = "User registered successfully";
        header('Location: index.php');
        exit();
    }
    else
    {
        $_SESSION['status'] = "User not registered";
        header('Location: register.php');
        exit();
    }
}







if(isset($_POST['delete_btn']))
{
    $del_id = $_POST['delete_btn'];
    
    $ref_table = 'contacts/'.$del_id;
    try {
        $deletequery_result = $database->getReference($ref_table)->remove();
        if($deletequery_result) {
            $_SESSION['status'] = "Contact deleted successfully";
            header('Location: index.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['status'] = "Erro, contact not deleted: " . $e->getMessage();
        header('Location: index.php');
        exit();
    }
}









if(isset($_POST['update']))
{    
    $key = $_POST['key'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $updateData = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'phone' => $phone
    ];

    
    $ref_table = 'contacts/'.$key;
    try {
        $updatequery_result = $database->getReference($ref_table)->update($updateData);
        
        if($updatequery_result) {
            $_SESSION['status'] = "Contact Updated";
            header('Location: index.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['status'] = "Erro, contact not updated: " . $e->getMessage();
        header('Location: index.php');
        exit();
    }
}

if(isset($_POST['save_contact']))
{
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $postData = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'phone' => $phone
    ];
    $ref_table = "contacts";
    $postRef_result = $database->getReference($ref_table)->push($postData);

    if($postRef_result)
    {
        $_SESSION['status'] = "Contact added successfully";
        header('Location: index.php');
    }
    else
    {
        $_SESSION['status'] = "Contact not added";
        header('Location: index.php');
    }

}

?>