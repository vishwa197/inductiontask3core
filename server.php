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
     $sql_u = "SELECT * FROM users WHERE username='$username'";
  	$sql_e = "SELECT * FROM users WHERE email='$email'";
  	$res_u = mysqli_query($db, $sql_u);
  	$res_e = mysqli_query($db, $sql_e);

  	if (mysqli_num_rows($res_u) > 0) {
  	  array_push($errors,"Sorry... username already taken"); 	
  	}else if(mysqli_num_rows($res_e) > 0){
  	  array_push($errors,"Sorry... email already taken"); 	
      }
      else{
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
    }

    if(isset($_POST['login'])){
        $username=mysqli_real_escape_string($db,$_POST['username']);
        $password_1=mysqli_real_escape_string($db,$_POST['password_1']);
        $email=mysqli_real_escape_string($db,$_POST['email']);
        if(!empty($username)){
            $query2="SELECT role1 FROM users WHERE username='$username'";
        }
        elseif(!empty($email)){
            $query2="SELECT role1 FROM users WHERE email='$email'";
        }
        else{
            array_push($errors,"Username or Email is required");
        }
        if(empty($password_1)){
            array_push($errors,"Password is required");
        }
        if(count($errors)==0){
            $query="SELECT * FROM users WHERE (username ='$username' AND password1='$password_1') OR (email='$email' AND password1='$password_1')";
            $result=mysqli_query($db,$query);
            $result2=mysqli_query($db,$query2);
            $row = mysqli_fetch_array($result2);
            if(mysqli_num_rows($result)==1){
                $_SESSION['username']=$username;
                $_SESSION['success']="Successfully logged in";
                if($row['role1']=="buyer"){
                    header('location:buyerdashboard.php');
                }
                else{
                    header('location:sellerdashboard.php');
                }
            }
            else{
                array_push($errors,"Your credentials do not match!");
            }
        }
    }
    if(isset($_GET['logout'])){
        unset($_SESSION['cart']);
        unset($_SESSION['username']);
        header('location:login.php');
    }
?>