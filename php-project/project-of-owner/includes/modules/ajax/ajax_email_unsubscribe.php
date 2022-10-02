<?php
if ($_GET['ajax_request_action'] == 'unsubscribe') {
    $id = 2;
    $type = $_POST['type'] ? $_POST['type'] : "";
    $text = $_POST['text'] ? $_POST['text'] : "";
    $insertid =  $_POST['insertid'];
    if (!empty($_POST['type']) && $insertid) {
        $data = array(
            'type' => $_POST['type'],
            'text' => $_POST['text'],
            'time' => time(),
            'state' => 1,
        );
        if(!empty($_POST['email'])){
            $data['email'] = $_POST['email'];
        }
    }
    echo !empty($id) ? 1 : 2;
}