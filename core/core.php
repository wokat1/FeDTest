<?php

class WM_CMS {

    public $template, $auth, $database, $cms, $post, $event;

    function __construct($server = null, $user = null, $pass = null, $db = null) {
        /*
         * Połaczenie bazą danych 
         */

         $this->database = new SQLite3(APP_PATH . 'includes/test.db');
        
		/*
         *  aktywacja obiektu szablonu struktury strony
         */
        include(APP_PATH . 'core/models/m_templete.php');

        $this->template = new Template();
        $this->template->setAlertTypes(array('success', 'warning', 'error'));

        /*
         *  aktywacja obiektu autoryzacji 
         */
        include(APP_PATH . 'core/models/m_auth.php');

        $this->auth = new Auth();

        include(APP_PATH . 'core/models/m_post.php');
        $this->post = new Post();
        
         include(APP_PATH . 'core/models/m_event.php');
        $this->event = new Event();
        session_start();
    }

    function __destruct() {
        $this->database->close();
    }

    function head() {
        if (!$this->auth->checkLoginStatus()) {
            include(APP_PATH . 'core/templates/t_head.php');
        }
        if (isset($_GET['login']) && $this->auth->checkLoginStatus() == FALSE) {
           include(APP_PATH . 'core/templates/t_login.php');
        }
    }

    function toolbar() {
        if ($this->auth->checkLoginStatus()) {
            include(APP_PATH . 'core/templates/t_toolbar.php');
        }
    }

    function login_link() {
        if ($this->auth->checkLoginStatus()) {
            echo "<a href='" . SITE_PATH . "app/c_logout.php' class='btn btn-success btn-large'>Wyloguj</a>";
        } 
    }

}
