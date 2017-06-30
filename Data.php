<?php
include_once 'User.php';
include_once 'Event.php';
class Data {
    private $users;
    private $events;
    private $tags;

    private function verif_event() {
        if (count($this->events)) {
            foreach ($this->events as $key=>$event) {
                $eventdate = intval(str_replace("-", "", $event->getDate()));
                $actualdate = intval(str_replace("-", "", date("Y-m-d-H-i")));
                if ($eventdate < $actualdate) {
                    array_splice($this->events, $key, 1);
                }
            }
        }
    }
            
    function __construct() {
        if (file_exists("users") && file_exists("events") && file_exists("tags")) {
            $this->users = unserialize(file_get_contents("users"));
            $this->events = unserialize(file_get_contents("events"));
            $this->tags = unserialize(file_get_contents("tags"));
        } else {
            $this->users = [];
            $this->events = [];
            $this->tags = [];
        }
//        $this->verif_event();
    }

    function saveData() {
        $fd = fopen((__DIR__) . "/users", "w+");
        fwrite($fd, serialize($this->users));
        fclose($fd);
        $fda = fopen((__DIR__) . "/events", "w+");
        fwrite($fda, serialize($this->events));
        fclose($fda);
        $fdb = fopen((__DIR__) . "/tags", "w+");
        fwrite($fdb, serialize($this->tags));
        fclose($fdb);
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
                return false;
            }
        }
        array_push($this->users, $user);
    }

    function addEvent(Event $event) {
        foreach ($this->events as $e) {
            if ($e->getTitle() == $event->getTitle()) {
                return false;
            }
        }
        array_push($this->events, $event);
    }
    
    function addTags ($tags) {
        if (gettype($tags) == "string") {
            array_push($this->tags, $tags);
        } else {
            foreach ($tags as $tag) {
                if (in_array($tag, $this->tags) === false) {
                    array_push($this->tags, $tag);                    
                }
            }
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
        if (count($this->events)) {
            foreach ($this->events as $event) {
                $event->html();
            }
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

    function getUsers() {
        return $this->users;
    }

    function getEvents() {
        return $this->events;
    }

    function getTags() {
        return $this->tags;
    }
}