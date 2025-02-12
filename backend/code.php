<?php
session_start();
include('dbcon.php');

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