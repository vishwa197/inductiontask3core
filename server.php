<?php
    session_start();

    $db = mysqli_connect('localhost','root','','registration');
    $errors=[];
    if(isset($_POST['register'])){
        $username=mysqli_real_escape_string($db,$_POST['username']);
        $email=mysqli_real_escape_string($db,$_POST['email']);
        $password_1=mysqli_real_escape_string($db,$_POST['password_1']);
        $password_2=mysqli_real_escape_string($db,$_POST['password_2']);
        $name=mysqli_real_escape_string($db,$_POST['name']);
        $role=mysqli_real_escape_string($db,$_POST['role']);

        if(empty($role)){
            array_push($errors,"Your role is required");
        }
        if(empty($name)){
            array_push($errors,"Name is required");
        }
        if(empty($username)){
            array_push($errors,"Username is required");
        }
        if(empty($email)){
            array_push($errors,"Email is required");
        }
        if(empty($password_1)){
            array_push($errors,"Password is required");
        }
        if (strlen($_POST["password_1"]) <= '8') {
            array_push($errors,"Your Password Must Contain At Least 8 Characters!");
        }
        elseif(!preg_match("#[0-9]+#",$password_1)) {
            array_push($errors,"Your Password Must Contain At Least 1 Number!");
        }
        elseif(!preg_match("#[A-Z]+#",$password_1)) {
            array_push($errors,"Your Password Must Contain At Least 1 Capital Letter!");
        }
        elseif(!preg_match("#[a-z]+#",$password_1)) {
            array_push($errors,"Your Password Must Contain At Least 1 Lowercase Letter!");
        }
        if($password_1 != $password_2){
            array_push($errors,"Passwords do not match");
        }
        
        if(count($errors)==0 && $role=='buyer'){
            $sql="INSERT INTO users (username, email, password1, name1, role1)
                        VALUES ('$username', '$email', '$password_1', '$name', '$role')";
            mysqli_query($db,$sql);
            $_SESSION['username']=$username;
            $_SESSION['success']="Successfully logged in!";
            header('location:buyerdashboard.php');
        }
        elseif(count($errors)==0 && $role=='seller'){
            $sql="INSERT INTO users (username, email, password1, name1, role1)
                        VALUES ('$username', '$email', '$password_1', '$name', '$role')";
            mysqli_query($db,$sql);
            $_SESSION['username']=$username;
            $_SESSION['success']="Successfully logged in!";
            header('location:sellerdashboard.php');
        }
    }

?>