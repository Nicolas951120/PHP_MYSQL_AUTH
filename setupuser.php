<?php 
    require_once 'login.php';

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die(error());

    $query = "SELECT * 
    FROM information_schema.tables
    WHERE table_schema = 'cs174' 
        AND table_name = 'users'
    LIMIT 1";

    $result = $conn->query($query);
    if(!$result) 
    {
        $query = "CREATE TABLE users(
        username VARCHAR(32) NOT NULL UNIQUE,
        email VARCHAR(32) NOT NULL,
        password CHAR(32) NOT NULL,
        salt VARCHAR(32) NOT NULL)";
        
        $result = $conn->query($query);
        if(!$result) die(error());
    }
    


    

    $salt = generateRandomString();

    $email = get_post($conn, 'email');
    $username = get_post($conn, 'username');
    $password = get_post($conn, 'password');


    $token = hash('ripemd128',"$salt$password");

    add_user($conn, $username, $email, $token, $salt);

    function get_post($conn, $var)
    {
        return $conn->real_escape_string($_POST[$var]);
    }

    function error()
    {
        echo "Sorry, error.";
    }

    function add_user($conn, $un, $em, $pw, $st)
    {
        echo "haha";
        $stmt = $conn->prepare('INSERT INTO users VALUES(?,?,?,?)');
        $stmt->bind_param('ssss',$p_un, $p_em, $p_pw, $p_st);
        $p_un = $un;
        $p_em = $em;
        $p_pw = $pw;
        $p_st = $st;
        
        $stmt->execute();

        printf("%d Row inserted.\n", $stmt->affected_rows);

        if(!$stmt)
        { 
            die(error());
        }
        else echo "account Created.";

    }

    function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $stmt->close();

    $result->close();
    $conn->close();

?>