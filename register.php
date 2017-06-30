<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php
            include_once 'Data.php';
            include_once 'User.php';
            
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = new Data();
            if (isset($post['user']) && isset($post['password']) && isset($post['password2'])
                    && $post['password'] == $post['password2'] && isset($post['adresse'])
                     && isset($post['firstname']) && isset($post['lastname'])) {
                if (!is_dir("imgUser")) {
                    mkdir("imgUser");
                }
                if (isset($_FILES['avatar']) && count($_FILES) != 0
                        && $_FILES['avatar']['tmp_name'] !== "") {
                    $img = "imgUser/" . $post['user'] . ".png";
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $img);
                } else {
                    $img = "img/default.png";
                }
                $user = new User($post['user'], hash("sha256", $post['password']), $img
                        , $post['adresse'], $post['firstname'], $post['lastname']);
                $data->addUser($user);
            }
            include_once 'header.php';
        ?>
        <main>
            <form  enctype="multipart/form-data" action="" method="POST">
                <label for="user">Username :</label>
                <input type="text" name="user">
                <label for="lastname">Lastname :</label>
                <input type="text" name="lastname">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstname">
                <label for="adresse">Adresse :</label>
                <input type="text" name="adresse">
                <label for="password">Password :</label>
                <input type="password" name="password">
                <label for="password2">Confirm password :</label>
                <input type="password" name="password2">
                <label for="avatar">Image Profile</label>
                <input type="file" name="avatar">
                <input type="submit" value="Register">
            </form>
        </main>
    </body>
</html>