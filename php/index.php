<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $_POST = json_decode(file_get_contents('php://input'), true);

    if(!isset($_POST['email']) || !isset($_POST['password'])){
        die();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = mysqli_connect('localhost', 'root',null, 'web_development');
    if(!$db){
        header("HTTP/1.1 500 Internal Server Error");
        ob_clean();
        die('Error connecting to the database.');
    }

    $db->query('SET CHARACTER SET utf8');
    $query = $db->query("SELECT users.id, users.name, users_profiles.id users_profiles_id 
                        FROM users INNER JOIN users_profiles ON users.id = users_profiles.id_user 
                        WHERE email ='" .  $email . "' AND password = '" . $password . "'");

    $json = array();
    if($query){
        $num_rows = $query->num_rows;
        $data = $query->fetch_assoc();
        $_SESSION['user']['id'] = $data['id'];
        $_SESSION['user']['name'] = $data['name'];

        $json['success'] = $num_rows > 0;
        $json['hasManyProfiles'] = $num_rows > 1;
    }
    else{
        header("HTTP/1.1 500 Internal Server Error");
        ob_clean();
        die('Error executing query to the database.'); 
    }
    

    header('Content-Type: application/json; Charset=UTF-8');
    echo(json_encode($json,JSON_UNESCAPED_UNICODE));
    $db->close();

?>