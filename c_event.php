
<!-- ============================================================== -->
<!-- Kontroler event -->
<!-- ============================================================== -->    
<?php

include 'init.php';

if (isset($_GET)) {
    print_r($_GET);
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'del') {
            $wm_cms->event->deleteEvent($_GET['event_id']);
            $wm_cms->template->load(APP_PATH . 'core/views/v_events.php');
        } else {
            $wm_cms->event->getEvent($_GET['event_id']);
            $wm_cms->template->load(APP_PATH . 'core/views/v_events.php');
        }
    }
}
