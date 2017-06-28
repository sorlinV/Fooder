<?php
//            <label for="title">Titre de l'event</label>
//            <input type="text" name="title">
//            <label for="place">Adresse</label>
//            <input type="text" name="place">
//            <label for="type">Type of repas :</label>
//            <ul>
//                <li><input type="radio" name="type" value="home">Home</li>
//                <li><input type="radio" name="type" value="resto">Restaurant</li>
//            </ul>
//            <label for="file">Image for event (optionnal)</label>
//            <input type="file" name="img">
class Event {
    private $title;
    private $date;
    private $type;
    private $adresse;
    private $img;
    private $creator;
    private $users;

    function __construct($title, $date, $type, $adresse, $img, User $creator, array $users = []) {
        $this->title = $title;
        $this->date = $date;
        $this->type = $type;
        $this->adresse = $adresse;
        $this->img = $img;
        $this->creator = $creator;
        $this->users =$users;
    }

    function html() {
        if (session_status() != 2) {
            session_start();
        }
        echo '<article class="event">';
        echo '<h2>' . $this->title . '</h2>';
        echo '<p>Event date: ' . $this->date . '</p>';
        echo '<p>Event type : ' . $this->type . '</p>';
        echo '<p>Event create by : ' . $this->creator->getUser() . '</p>';
        echo '<p>' . count($this->users) . ' user(s) registered<p>';
        if ($this->img != false) {
            echo '<img src="' . $this->img . '" alt="event image"/>';            
        }
        if (isset($_SESSION['user'])) {
            echo '<form action="" method="post">';
            if (in_array($_SESSION['user'], $this->users) || $_SESSION['user'] == $this->creator) {
                echo '<p> adresse: ' . $this->adresse . '</p>';
            } else {
                echo '<input type="hidden" name="sub" value="' . $this->title . '"/>';
                echo '<input type="submit" value="Subscribe"/>';
            }
            echo '</form>';
        }
        echo '</article>';
    }
    
    function addUser($user) {
        if (in_array($user, $this->users) == false) {
            if (isset($this->users) || count($this->users) == 0) {
                array_push($this->users, $user);            
            } else {
                $this->users = [$user];
            }
        }
    }
    
    function getTitle() {
        return $this->title;
    }


}
