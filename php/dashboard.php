<?php
    session_start();

    if(!isset($_SESSION['user'])){
        header("HTTP/1.1 402 Unauthorized");
        ob_clean();
        die('Session Expired!');
    }


    $db = mysqli_connect('localhost', 'root',null, 'web_development');
    if(!$db){
        header("HTTP/1.1 500 Internal Server Error");
        ob_clean();
        die('Error connecting to the database.');
    }

    $db->query('SET CHARACTER SET utf8');
    $query = $db->query("SELECT periods.start_date, periods.end_date, 
                        status_periods.description period_description, 
                        SUM(TIMESTAMPDIFF(HOUR,entries.start_time,entries.end_time)) hours, 
                        entry_types.description 
                        FROM entries 
                        INNER JOIN users ON users.id = entries.id_user
                        INNER JOIN periods ON periods.id_user = users.id AND periods.start_date <= entries.date AND periods.end_date >= entries.date
                        INNER JOIN status_periods on periods.id_status_periods = status_periods.id
                        INNER JOIN entry_types ON entries.id_entry_type = entry_types.id
                        WHERE MONTH(periods.start_date) = " . date('n') . " and users.id = '" . $_SESSION['user']['id'] . "'
                        GROUP BY periods.start_date, periods.end_date, status_periods.description, entry_types.description");
    
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

    $period = null;
    if($query->num_rows > 0){
        $period = [
            'start' => $json[0]['start_date'],
            'end' => $json[0]['end_date'],
            'status' => $json[0]['period_description'],
            'details' => $json
        ];
    }

     $model = [ 
        'user' => [
            'name' => $_SESSION['user']['name'],
            'profile' => $_SESSION['user']['selectedProfile']['description']
        ],
        'period' => $period
     ];

    echo(json_encode($model,JSON_UNESCAPED_UNICODE));
    $db->close();
?>