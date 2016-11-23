<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(empty($_POST))
            $_POST = json_decode(file_get_contents('php://input'), true);
        handlePost($_POST);
    }else if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(empty($_GET))
            $_GET = json_decode(file_get_contents('php://input'), true);
        handleGet($_GET);
    }else if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $putData = json_decode(file_get_contents('php://input'), true);
        handlePut($putData);
    }else if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $putData = json_decode(file_get_contents('php://input'), true);
        handleDelete($putData);
    }

    function handlePost($postData){
        $db = createDatabaseConnection();

        echo(json_encode($json,JSON_UNESCAPED_UNICODE));
        $db->close();
    }

    function handleGet($getData){
        $db = createDatabaseConnection();

        echo(json_encode($json,JSON_UNESCAPED_UNICODE));
        $db->close();
    }

    function handlePut($putData){
        $db = createDatabaseConnection();

        echo(json_encode($json,JSON_UNESCAPED_UNICODE));
        $db->close();
    }

    function handleDelete($putData){
        $db = createDatabaseConnection();

        echo(json_encode($json,JSON_UNESCAPED_UNICODE));
        $db->close();
    }

    function createDatabaseConnection(){
        $db = mysqli_connect('localhost', 'root',null, 'web_development');
        if(!$db){
            header("HTTP/1.1 500 Internal Server Error");
            ob_clean();
            die('Error connecting to the database.');
        }

        return $db;
    }
?>