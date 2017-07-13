<!-- ============================================================== -->
<!-- Model event -->
<!-- ============================================================== -->    

<?php

class Event {

    private $event_id, $event_date, $event_title, $event_cotent, $user_id;

    function __construct($event_id = null, $event_date = null, $event_title = null, $event_cotent = null, $user_id = null) {
        $this->event_id = $event_id;
        $this->event_date = $event_date;
        $this->event_title = $event_title;
        $this->event_cotent = $event_cotent;
        $this->user_id = $user_id;
    }

    function getEvents($linit = null) {
        global $wm_cms;
        if ($linit == null) {
            $linit = 100;
        }
        if ($stmt = $wm_cms->database->query('SELECT * from events ORDER BY event_date DESC LIMIT ' . $linit)) {
            
            $i = 0;
            while ($row = $stmt->fetchArray()) {
                $results[$i++] = $row;
            }
            return $results;
        }
    }

    function getEvent($id) {
        global $wm_cms;
        
        if ($stmt = $wm_cms->database->query('SELECT * from events WHERE event_id = ' . $id)) {
        
            while ($row = $stmt->fetchArray()) {
                $results[0] = $row;
            }
            return $results;
        }
    }

    public function addEvent() {
        global $wm_cms;
      
        if (isset($_POST['event_title'])) {

            
            $title = htmlspecialchars(($_POST['event_title']));
            $content = htmlspecialchars($_POST['event_content']);
            $date = date('Y-m-d');
            $link = htmlspecialchars($_POST['event_link']);
            echo $content . " " . $title . " " . $link . $date . "<br>";

            $stmt = $wm_cms->database->prepare("INSERT INTO events (event_title,event_content,event_date,event_link) VALUES (:title,:content,:date,:link)");

            $stmt->bindValue(':title', $title, SQLITE3_TEXT);
            $stmt->bindValue(':content', $content, SQLITE3_TEXT);
            $stmt->bindValue(':date', $date, SQLITE3_TEXT);
            $stmt->bindValue(':link', $link, SQLITE3_TEXT);

            $stmt->execute();
           
        }
    }

    public function deleteEvent($id) {
        global $wm_cms;
        $wm_cms->database->exec('DELETE FROM events WHERE event_id=' . $id);
       
    }

}
