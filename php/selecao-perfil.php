<?php
    session_start();

    if(!isset($_SESSION['user'])){
        header("HTTP/1.1 402 Unauthorized");
        ob_clean();
        die('Session Expired!');
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(empty($_POST))
            $_POST = json_decode(file_get_contents('php://input'), true);
        handlePost($_POST);
    }
    else{
        handleGet();
    }

    function handlePost($selectedProfile){
        $_SESSION['user']['selectedProfile'] = $selectedProfile;
    }

    function handleGet(){
        $db = mysqli_connect('localhost', 'root',null, 'web_development');
        if(!$db){
            header("HTTP/1.1 500 Internal Server Error");
            ob_clean();
            die('Error connecting to the database.');
        }

        $db->query('SET CHARACTER SET utf8');
        $query = $db->query("SELECT profiles.id, profiles.description 
                            FROM profiles INNER JOIN users_profiles ON profiles.id = users_profiles.id_profile
                            WHERE users_profiles.id_user = '" . $_SESSION['user']['id'] . "'");

        if(!$query){
            header("HTTP/1.1 500 Internal Server Error");
            ob_clean();
            die('Error executing query to the database.');
        }

        $json = array();
        header('Content-Type: application/json; Charset=UTF-8');
        while($data = $query->fetch_assoc()){
            $json[] = $data;
        }

        echo(json_encode($json,JSON_UNESCAPED_UNICODE));
        $db->close();
    }
?>