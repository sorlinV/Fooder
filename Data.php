<?php
class Data {
    private $users;
    private $events;
    
    private function verif_event() {
        foreach ($this->events as $key=>$event) {
            $eventdate = intval(str_replace("-", "", $event->getDate()));
            $actualdate = intval(str_replace("-", "", date("Y-m-d-H-i")));
            if ($eventdate < $actualdate) {
                array_splice($this->events, $key, 1);
            }
        }
    }
            
    function __construct() {
        if (file_exists("users") && file_exists("events")) {
            $this->users = unserialize(file_get_contents("users"));
            $this->events = unserialize(file_get_contents("events"));
        } else {
            $this->users = [];
            $this->events = [];
        }
        $this->verif_event();
    }

    function saveData() {
        $fd = fopen((__DIR__) . "/users", "w+");
        fwrite($fd, serialize($this->users));
        fclose($fd);
        $fdm = fopen((__DIR__) . "/events", "w+");
        fwrite($fdm, serialize($this->events));
        fclose($fdm);
    }
    
    function __destruct() {
        $this->saveData();
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
        array_push($this->users, $user);
    }

    function addEvent(Event $event) {
        foreach ($this->events as $e) {
            if ($e->getTitle() == $event->getTitle()) {
                return ;
            }
        }
        array_push($this->events, $event);
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