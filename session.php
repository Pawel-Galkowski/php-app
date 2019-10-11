<?php
ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');
session_start();    
    if(isset($_POST['logToApp'])) {
        $user=$_POST['uname'];
        $password=$_POST['psw'];
        $query="select * from users where nick='$user' and password='$password'";
        $con=connectDatabase();
        $run=mysqli_query($con,$query);

        if(mysqli_num_rows($run)>0) {
            $_SESSION['logged']=$user;
        } else {
            echo"<script>alert('incorrect user name or password')</script>";
        }
        if(isset($_SESSION['logged']) && !empty($_SESSION['logged'])){
            $location = "";
        }
        else{
            $location = './login.php';
            header('Refresh: 4; url='.$location);
        }
    }

function connectDatabase(){
        $servername = "localhost";
        $username = "admin";
        $password = "admin";
        $base_name = "zad3";
        
        $baza = new mysqli($servername, $username, $password, $base_name);
        
        if ($baza->connect_errno) {
            printf("Connect failed: %s\n", $baza->connect_error);
            exit();
        }
        
        return $baza; 
    }   
?>