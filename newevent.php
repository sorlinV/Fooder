<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Event</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php
        include_once 'header.php';
        if (session_status() != 2) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if (isset($post['title']) && isset($post['place']) && isset($post['type']) &&
                    isset($post['date'])) {
                echo "tout est set ! ";
                if (isset($_FILES['eventimg'])) {
                    echo 'le fichier aussi !';
                    if (!is_dir("imgEvent")) {
                        mkdir("imgEvent");
                    }
                    move_uploaded_file($_FILES['eventimg']['tmp_name'],
                            "imgEvent/" . $post['title'] . ".png");
                    $event = new Event($post['title'], $post['date'], $post['type'],
                        $post['place'], "imgEvent/".$post['title'].'.png', $_SESSION['user']);
                } else {
                    $event = new Event($post['title'], $post['date'], $post['type'],
                        $post['place'], false, $_SESSION['user']);
                }
                $data->addEvent($event);
            }
        ?>
        <form enctype="multipart/form-data" action="" method="post">
            <label for="title">Titre de l'event</label>
            <input type="text" name="title">
            <label for="date">Date</label>
            <input type="datetime" name="date">
            <label for="place">Adresse</label>
            <input type="text" name="place">
            <label for="type">Type of repas :</label>
            <ul>
                <li><input type="radio" name="type" value="home">Home</li>
                <li><input type="radio" name="type" value="resto">Restaurant</li>
            </ul>
            <label for="eventimg">Image for event (optionnal)</label>
            <input type="file" name="eventimg">
            <input type="submit" value="Adding Event">
        </form>
            <?php } else {
                header('location: index.php');
            }
?>
    </body>
</html>