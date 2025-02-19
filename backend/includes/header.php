<!doctype html>
<html lang="pt-BR" dir="ltr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <title>Cloudin Trilha</title>
    <style>
        :root {
            --primary-color: <?php echo $storeInfo['primary_color'] ?? '#343a40'; ?>;
            --secondary-color: <?php echo $storeInfo['secondary_color'] ?? '#6c757d'; ?>;
        }
        
        .custom-primary {
            background-color: var(--primary-color) !important;
        }
        
        .custom-secondary {
            background-color: var(--secondary-color) !important;
        }
    </style>
  </head>
  <body>

  <?php include('navbar.php'); ?>

  <div class= "py-4">