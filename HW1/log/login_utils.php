<?php
    function anyEmpty(){
        if(!empty($_POST["name"]) && !empty($_POST["surname"]) && !empty($_POST["email"])
            && !empty($_POST["username"]) && !empty($_POST["password"]))
            return FALSE;
        else return TRUE;
    }

    function existsUsername($value) {
        $conn = mysqli_connect("localhost", "root", "", "hw1");
        $query = "SELECT * FROM users WHERE username = '".$value."'";
        $res = mysqli_query($conn, $query);
        return mysqli_num_rows($res);        
    }

    function existsEmail($value) {
        $conn = mysqli_connect("localhost", "root", "", "hw1");
        $query = "SELECT * FROM users WHERE email = '".$value."'";
        $res = mysqli_query($conn, $query);
        return mysqli_num_rows($res);        
    }
?>