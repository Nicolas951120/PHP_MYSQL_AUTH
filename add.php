<?php 
    require_once 'login.php';

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die(error());

    $query = "SELECT * 
    FROM information_schema.tables
    WHERE table_schema = 'cs174' 
        AND table_name = 'material'
    LIMIT 1";

    $result = $conn->query($query);
    if(!$result) 
    {
        $query = "CREATE TABLE material(
            username VARCHAR(32) NOT NULL,
            string TEXT NOT NULL)";
    
        $result = $conn->query($query);
        if(!$result) die(error());
    }
    
    

    if(null !== $_POST['material'])
    {
        $user = get_post($conn, 'user');
        $string = get_post($conn, 'material');
        echo $user;
        echo $string;
        $query = "INSERT INTO `material`(`username`, `string`) VALUES ('$user','$string')";
    
        $result = $conn->query($query);
        if(!$result) die(error());
        else echo "Text added successfully.";
    }
    
    if (null !== $_FILES["fil"]["tmp_name"]){
        $u=get_post($conn,'user');
        $file = addslashes(file_get_contents($_FILES["fil"]["tmp_name"]));
        $query = "INSERT INTO `material`(`username`, `string`) VALUES ('$u','$file')";

        //$query = "INSERT INTO 'material' ('username','string') VALUES ('".$u."', '".$file."')";
        $result = $conn->query($query);
        if (!$result) die (error());
        else echo "File added successfully.";
    }


    function get_post($conn, $var)
    {
        return $conn->real_escape_string($_POST[$var]);
    }

    function error()
    {
        echo "Sorry, error.";
    }
?>