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
            if (file_exists("data")) {
                $data = unserialize(file_get_contents("data"));
            } else {
                $data = new Data();
                $data->saveData();
            }
            if (isset($post['user']) && isset($post['password']) && isset($post['password2'])) {
                if (!is_dir("imgUser")) {
                    mkdir("imgUser");
                }
                if (isset($_FILES['avatar'])) {
                    move_uploaded_file($_FILES['avatar']['tmp_name'],
                            "imgUser/" . $post['user'] . ".png");
                    $user = new User($post['user'],
                            hash("sha256", $post['password']), "imgUser/" . $post['user'] . ".png");
                } else {
                    $user = new User($post['user'],
                            hash("sha256", $post['password']), "imgUser/default.png");
                }
                $data->addUser($user);
            }
            include_once 'header.php';
        ?>
        <main>
            <form  enctype="multipart/form-data" action="" method="POST">
                <label for="user">Username :</label>
                <input type="text" name="user">
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
