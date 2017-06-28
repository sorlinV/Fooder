<?php
    include_once 'Data.php';
    include_once 'User.php';
    include_once 'Event.php';
    
    if (session_status() != 2) {
        session_start();
    }
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    // DEFINE $data
    $data = new Data();
    //VERIF LOGIN/REGISTER FOR SESSION
    if (isset($post['user']) && isset($post['password'])) {
        $post['password'] = hash("sha256", $post['password']);
        if ($data->verifUser($post['user'], $post['password'])) {
            $_SESSION['user'] = $data->getUser($post['user']);
        }
    }
    //VERIF SUB FOR EVENT
    if (isset($post['sub']) && isset($_SESSION['user'])) {
        $data->getEvent($post['sub'])->addUser($_SESSION['user']);
    }
    //VERIF SUB/UNSUUB fOR USER
    if (isset($_SESSION['user']) && isset($post['subuser'])) {
        $suber = $data->getUser($_SESSION['user']->getUser());
        $suber->addSubscriber($post['subuser']);
        $u = $data->getUser($post['subuser']);
        $u->addFollower($_SESSION['user']->getUser());
        $_SESSION['user'] = $suber;
    }
    if (isset($_SESSION['user']) && isset($post['unsubuser'])) {
        $suber = $data->getUser($_SESSION['user']->getUser());
        $suber->rmSubscriber($post['subuser']);
        $u = $data->getUser($post['subuser']);
        $u->rmFollower($_SESSION['user']->getUser());
        $_SESSION['user'] = $suber;
    }
    //VERIF DECONNECTION
    if (isset($post['deco'])) {
        unset($_SESSION['user']);
    }
?>
<header>
    <a href="index.php" ><img src="img/logo.png" alt="Logo FOODer" id="logo"></a>
    <ul>
        <?php if (!isset($_SESSION['user'])) { ?>
        <li><a href="register.php">Register</a></li>
        <?php }
        if (isset($_SESSION['user'])) { ?>
        <li><a href="newevent.php">Create Event</a></li>           
        <li><a href="profil.php">Profil</a></li>
        <?php } ?>
        <li><a href="contact.php">Contact</a></li>
    </ul>
    <form action="search.php" method="POST">
        <input type="text" name="search">
        <input type="submit" value="Search">
    </form>
    <?php if (!isset($_SESSION['user'])) { ?>
    <form method="POST">
        <input type="text" name="user" placeholder="Username"/>
        <input type="password" name="password" placeholder="Password" />
        <a href="register.php">Register</a>
        <input type="submit" value="Connection" />
    </form>
    <?php } else { ?>
        <h2><?php echo $_SESSION['user']->getUser(); ?></h2>
        <form method="POST">
            <input type="submit" name="deco" value="Deconnection">
        </form>
    <?php }
    ?>
</header>