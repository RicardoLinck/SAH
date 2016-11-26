<?php
    $db = mysqli_connect('localhost', 'root',null, 'web_development');
    if(!$db){
        header("HTTP/1.1 500 Internal Server Error");
        ob_clean();
        die('Error connecting to the database.');
    }

    $db->query('SET CHARACTER SET utf8');
    $query = $db->query("SELECT * 
                        FROM entry_types
                        ORDER BY id");
    
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
?>