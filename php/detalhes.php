<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(empty($_POST))
            $_POST = json_decode(file_get_contents('php://input'), true);
        handlePost($_POST);
    }else if($_SERVER['REQUEST_METHOD'] == 'GET'){
        handleGet($_GET);
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

        $query_text = "SELECT entries.id, 
                            entries.date,
                            entries.start_time startTime, 
                            entries.end_time endTime, 
                            TIMESTAMPDIFF(HOUR,entries.start_time,entries.end_time) hours,
                            entry_types.id entry_types_id,
                            entry_types.description
                            FROM entries INNER JOIN entry_types ON entries.id_entry_type = entry_types.id
                            WHERE entries.id_user = '" . $_SESSION['user']['id'] . "'";

        if(isset($getData['startDate']) && $getData['startDate']){
            $query_text = $query_text . " AND entries.date >= '" . $getData['startDate'] . "'";
        } else {
            $query_text = $query_text . " AND MONTH(entries.date) >= " . date('n');
        }

        if(isset($getData['endDate']) && $getData['endDate']){
            $query_text = $query_text . " AND entries.date <= '" . $getData['endDate'] . "'";
        } else {
            $query_text = $query_text . " AND MONTH(entries.date) <= " . date('n');
        }

        if(isset($getData['entryType']) && $getData['entryType']){
            $query_text = $query_text . " AND entries.id_entry_type = " . $getData['entryType'];
        }

        $query_text = $query_text . " ORDER BY entries.date ";  

        $query = $db->query($query_text);

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

        $model = [ 
        'user' => [
                'name' => $_SESSION['user']['name'],
                'profile' => $_SESSION['user']['selectedProfile']['description']
            ],
            'results' => $json
        ];

        echo(json_encode($model,JSON_UNESCAPED_UNICODE));
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