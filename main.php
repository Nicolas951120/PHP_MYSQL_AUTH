<?php 
    echo<<<_END
    <form action="setupuser.php" method="post">
    Sign Up <br>
    Username:    <input type="text"  name = "username"/><br>
    password:    <input type="text"  name = "password"/><br>
    email:       <input type="text"  name = "email"/><br>
    <input type="submit" value="Sign Up">
    </form>
    <br>
    <br>
    <br>
    <form action="authenticate.php" method="post">
    Log In<br>
    Username:    <input type="text"  name = "auth_username"/><br>
    password:    <input type="text"  name = "auth_password"/><br>
    <input type="submit" value="Log In">
    </form>
    <br>
    _END;
?>