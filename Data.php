<?php
class Data {
    private $users;
    private $events;
    
    function __construct() {
        if (file_exists("data")) {
            $data = unserialize(file_get_contents("data"));
            $this->users = $data->users;
            $this->events = $data->events;
        } else {
            $this->users = [];
            $this->events = [];
        }
    }

    function __destruct() {
        $fd = fopen("data", "w+") or die('[ERROR] Fail to open data.');
        $content = serialize($this);
        fwrite($fd, $content);
        fclose($fd);
    }
    
    function verifUser ($userVerif, $passwordVerif) {
        foreach ($this->users as $user) {
            if ($user->getUser() == $userVerif
                    && $user->getPassword() == hash("sha256", $passwordVerif . $user->getSalt())) {
                return true;
            }
        }
        return false;
    }
    
    function userExists ($username) {
        foreach ($this->users as $user) {
            if ($user->getUser() == $username) {
                return true;
            }
        }
        return false;        
    }
            
    function getUser($username) {
        foreach ($this->users as $user) {
            if ($user->getUser() == $username) {
                return $user;
            }
        }
        return false;
    }
    
    function addUser($user) {
        foreach ($this->users as $u) {
            if ($u->getUser() == $user->getUser()) {
                return ;
            }
        }
        if (isset($this->users) || count($this->users) == 0) {
            array_push($this->users, $user);            
        } else {
            $this->users = [$user];
        }
    }

    function addEvent(Event $event) {
        foreach ($this->events as $e) {
            if ($e->getTitle() == $event->getTitle()) {
                return ;
            }
        }
        if (isset($this->events) || count($this->events) == 0) {
            array_push($this->events, $event);            
        } else {
            $this->events = [$event];
        }
    }

    function getEvent($eventtitle) {
        foreach ($this->events as $event) {
            if ($event->getTitle() == $eventtitle) {
                return $event;
            }
        }
        return false;
    }    
    
    function affEvents() {
        foreach ($this->events as $event) {
            $event->html();
        }
    }
    
    function search($value) {
        if ($value != "") {
            echo "<h2>Users find:</h2>";
            foreach ($this->users as $u) {
                if (strpos($u->getUser(), $value) !== false) {
                    $u->toHtml();
                }
            }
            echo "<h2>Event find:</h2>";
            foreach ($this->events as $e) {
                if (strpos($e->getTitle(), $value) !== false) {
                    $e->html();
                }
            }
        }
    }
}