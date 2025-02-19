<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('dbcon.php');

if(isset($_POST['personalize_store']))
{
    $store_name = $_POST['store_name'];
    $description = $_POST['description'];
    $primary_color = $_POST['primary_color'];
    $secondary_color = $_POST['secondary_color'];
 
    $postData = [
        'store_name' => $store_name,
        'description' => $description,
        'primary_color' => $primary_color,
        'secondary_color' => $secondary_color,
    
    ];
    $ref_table = "stores";
    $postRef_result = $database->getReference($ref_table)->push($postData);

    if($postRef_result)
    {
        $_SESSION['status'] = "Store Personalized Successfully";
        header('Location: mystore.php');
    }
    else
    {
        $_SESSION['status'] = "Store Not Personalized";
        header('Location: mystore.php');
    }
}






if(isset($_POST['register_btn']))
{
    $admin_name = $_POST['admin_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userProperties = [
        'email' => $email,
        'emailVerified' => false,
        'password' => $password,
        'displayNameStore' => $store_name,
    ];
    
    try {
        $createdUser = $auth->createUser($userProperties);
        
        // Adiciona flag de primeiro login
        $database->getReference('users/'.$createdUser->uid)->set([
            'first_login' => true
        ]);
        
        if($createdUser)
        {
            $_SESSION['status'] = "User registered successfully";
            header('Location: login.php');
            exit();
        }
    }
    catch (\Kreait\Firebase\Exception\Auth\EmailExists $e) {
        $_SESSION['status'] = "User not registered";
        header('Location: register.php');
        exit();
    }
}







if(isset($_POST['delete_btn']))
{
    $del_id = $_POST['delete_btn'];
    
    $ref_table = 'stores/'.$del_id;
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

    
    $ref_table = 'stores/'.$key;
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
    $ref_table = "stores/.$key/products";
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