<?php
    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die(error());

    if(isset($_POST['auth_username']) && isset($_POST['auth_password']))
    {
        $un_temp = get_post($conn, 'auth_username');
        $pw_temp = get_post($conn, 'auth_password');
        $query = "SELECT * FROM `users` WHERE `username` = '$un_temp'";
        $result = $conn->query($query);
        if(!$result) die(error());
        elseif($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_NUM);
            $result->close();
            $salt = $row[3];


            $token = hash('ripemd128', "$salt$pw_temp");


            if($token == $row[2])
            {
                echo $un_temp . " log in succesfully.<br>";
                $query = "SELECT * FROM `material` WHERE `username` = '$un_temp'";
                $result = $conn->query($query);
                if (!$result) echo "No data in the database.";
                $rows = $result->num_rows;

                for ($j = 0 ; $j < $rows ; ++$j)
                {
                    $result->data_seek($j);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    echo '<br>' . nl2br($row['string']) . '</br>';
                    // $string = strip_tags($row['string']);
                    // if (strlen($string) > 3) {

                    //     $stringCut = substr($string, 0, 500);
                    //     $endPoint = strrpos($stringCut, ' ');

                    //     $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                    //     $string .= '... <a href='.nl2br($row['string']).'>Read More</a>';
                    // }
                    // echo $string;

                }

                if(isset($_POST['submit'])){
                    
                }


                echo<<<_END
                <form action="add.php" method="post">
                <textarea rows="5" cols="30" name = 'material'></textarea>
                <input type="hidden" name="user" value="$un_temp">
                <input type="submit" value="Upload text">
                </form>

                <form action="add.php" method="post" enctype="multipart/form-data">
                <input required type="file" accept=".txt" name="fil"><br/>
                <input type="hidden" name="user" value="$un_temp">
                <button type="submit" name="submit">Upload meterial</button>
                </form>
                _END;
                
            }
            else echo "Invalid username/password.";
        }
        else echo "Invalid username/password.";
    }
    
    else echo "Please enter username and passowrd.";

    


    function get_post($conn, $var)
    {
        return $conn->real_escape_string($_POST[$var]);
    }

    function error()
    {
        echo "Sorry, error.";
    }

    function readMoreHelper($story_desc, $chars = 30) {
        $story_desc = substr($story_desc,0,$chars);  
        $story_desc = substr($story_desc,0,strrpos($story_desc,' '));  
        $story_desc = $story_desc." <a href='#'>Read More...</a>";  
        return $story_desc;  
    } 

    $result->close();
    $conn->close();

?>