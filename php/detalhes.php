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
        print_r($_REQUEST);
        handleDelete($_REQUEST);
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
                    "'" . $postData['dateFormatted'] . "', " .
                    "'" . $postData['startHourFormatted'] . "', " .
                    "'" . $postData['endHourFormatted'] . "')";
                    
        $stmt = $db->prepare($command);
        $result = $stmt->execute();

        $stmt->close();
        $db->close();

        if(!$result){
            header("HTTP/1.1 500 Internal Server Error");
            ob_clean();
            die('Erro ao executar comando.');
        }
    }

    function handleGet($getData){
        $db = createDatabaseConnection();

        $db->query('SET CHARACTER SET utf8');
        $query = $db->query("SELECT profiles.id, profiles.description 
                            FROM profiles INNER JOIN users_profiles ON profiles.id = users_profiles.id_profile
                            WHERE users_profiles.id_user = '" . $_SESSION['user']['id'] . "'");

        if(!$query){
            header("HTTP/1.1 500 Internal Server Error");
            ob_clean();
            die('Erro ao executar query no banco.');
        }

        $json = array();
        header('Content-Type: application/json; Charset=UTF-8');
        while($data = $query->fetch_assoc()){
            $json[] = $data;
        }

        echo(json_encode($json,JSON_UNESCAPED_UNICODE));
        $db->close();
    }

    function handlePut($putData){
        $db = createDatabaseConnection();

        echo(json_encode($json,JSON_UNESCAPED_UNICODE));
        $db->close();
    }

    function handleDelete($deleteData){
        $db = createDatabaseConnection();

        $command = "DELETE FROM Entries WHERE id = " . $deleteData['id'];
                    
        print_r($command);
        $stmt = $db->prepare($command);
        $result = $stmt->execute();

        $stmt->close();
        $db->close();

        if(!$result){
            header("HTTP/1.1 500 Internal Server Error");
            ob_clean();
            die('Erro ao executar comando.');
        }

    }

    function createDatabaseConnection(){
        $db = mysqli_connect('localhost', 'root',null, 'web_development');
        if(!$db){
            header("HTTP/1.1 500 Internal Server Error");
            ob_clean();
            die('Erro ao conectar no banco.');
        }

        return $db;
    }
?>