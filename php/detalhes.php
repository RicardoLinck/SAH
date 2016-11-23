<?php
    session_start();
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

        $query = $db->query("SELECT periods.id
                            FROM periods
                            WHERE periods.start_date <= '" . $postData['date'] . "' 
                            AND periods.end_date >= '" . $postData['date'] . "'
                            AND periods.id_user = '" . $_SESSION['user']['id'] . "'");

        $id_period = $query->fetch_assoc();

        if(!$id_period){
            // Insert new period
        }

        $command = "INSERT INTO Entries (id_user, id_entry_type, date, start_time, end_time) 
                    VALUES (" . $_SESSION['user']['id'] . ", " .
                    $postData['description']['id'] . ", " .
                    "'" . $postData['date'] . "', " .
                    "'" . $postData['startHour'] . "', " .
                    "'" . $postData['endHour'] . "')";
                    
        $db->execute($command);

        print_r($command);

        // echo(json_encode($json,JSON_UNESCAPED_UNICODE));
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