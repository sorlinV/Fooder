<?php
class User {
    private $user;
    private $password;
    private $salt;
    private $img;
    
    function __construct($user, $password, $img) {
        $this->user = $user;
        $this->salt = hash("sha256", rand());
        $this->password = hash("sha256", $password.$this->salt);
        $this->img = $img;
    }
    
    function toHtml () {
        echo '<h2>' . $this->user . "</h2>";
        echo '<img src="' . $this->img . '" alt="avatar user image"/>';
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
}
