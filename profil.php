<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
        <title>FOODer profil</title>
    </head>
    <body>
        <?php
            include_once 'header.php';
            if (isset($_SESSION['user'])) {
                $_SESSION['user']->toHtml();
            }
        ?>
    </body>
</html>
