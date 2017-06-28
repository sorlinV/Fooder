<?php
class User {
    private $user;
    private $password;
    private $salt;
    
    private $img;
    private $adresse;
    private $firstname;
    private $lastname;
    private $recette;
    private $followers;
    private $subscribes;
 
    function __construct($user, $password, $img, $adresse, $firstname, $lastname,
            $recette = [], $followers = [], $subscribes = []) {
        $this->user = $user;
        $this->salt = hash("sha256", random_int());
        $this->password = hash("sha256", $password.$this->salt);
        $this->img = $img;
        $this->adresse = $adresse;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->recette = $recette;
        $this->followers = $followers;
        $this->subscribes = $subscribes;
    }

    function toHtml () {
        echo '<article class="user">';
        echo '<img src="' . $this->img . '" alt="' . $this->user . ' avatar"/>';
        echo '<aside>';
        echo '<h2>' . $this->user . "</h2>";
        echo '</aside>';
        if (in_array($this->user, $this->subscribes) == false) {
            echo '<form method="POST">';
            echo '<input type="hidden" name="subuser" value="' . $this->user . '"/>';
            echo '<input type="submit" value="Subscribe" />';
            echo '</form>';            
        } else {
            echo '<form method="POST">';
            echo '<input type="hidden" name="unsubuser" value="' . $this->user . '"/>';
            echo '<input type="submit" value="Unsubscribe" />';
            echo '</form>';                        
        }
        echo '</article>';
    }

    function toHtmlPrivate () {
        echo '<article class="user">';
        echo '<img src="' . $this->img . '" alt="' . $this->user . ' avatar"/>';
        echo '<section>';
        echo '<h2>' . $this->user . "</h2>";
        echo '<p>' . $this->adresse . '</p>';
        echo '<p>' . $this->firstname . '</p>';
        echo '<p>' . $this->lastname . '</p>';
        echo '</section>';
        if (count($this->subscribes) != 0) {
            echo '<section>';
            echo '<h3>Subscribes : </h3>';
            echo '<ul>';
            foreach ($this->subscribes as $sub) {
                echo '<li>' . $sub->getUser() . '</li>';
            }
            echo '</ul>';
            echo '</section>';            
        }
        if (count($this->followers) != 0) {
            echo '<section>';
            echo '<h3>Followers : </h3>';
            echo '<ul>';
            foreach ($this->followers as $follower) {
                echo '<li>' . $follower->getUser() . '</li>';
            }
            echo '</ul>';
            echo '</section>';
            echo '</article>';            
        }
    }
    
    function getUser() {
        return $this->user;
    }

    function getPassword() {
        return $this->password;
    }

    function getSalt() {
        return $this->salt;
    }
    
    function addFollower (String $follower) {
        array_push($this->followers, $follower);
    }
    
    function rmFollower (String $follower) {
        array_diff($this->followers, [$follower]);
    }
    
    function addSubscribe (String $sub) {
        array_push($this->followers, $sub);
    }
    
    function rmSubscribes (String $sub) {
        array_diff($this->followers, [$sub]);
    }
}
