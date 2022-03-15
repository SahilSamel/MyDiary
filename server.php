<?php
session_start();


$username = "";
$email = "";
$errors = array();

$db = mysqli_connect('localhost', 'root', '', 'registration');

if (isset($_POST['reg_user'])) {

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    $result = mysqli_query($db, "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }

    if (count($errors) == 0) {
        $password = md5($password_1);

        $query= "INSERT INTO users (username, email, password) 
                  VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
}

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Please enter a username");
    }

    if (empty($password)) {
        array_push($errors, "Please enter a password");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $results = mysqli_query($db, "SELECT * FROM users WHERE username='$username' AND password='$password'");
        
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['username'] = $username;
          $_SESSION['success'] = "You are now logged in";
          header('location: index.php');
        }
        else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

if (isset($_POST['save'])) {
    $username = mysqli_real_escape_string($db, $_SESSION['username']);
    $entry = mysqli_real_escape_string($db, $_POST['entry']);
    $date = date("y/m/d");
    $results = mysqli_query($db,"SELECT * FROM entries where username = '$username' AND date = '$date'");
    if ($entry === "") {
        array_push($errors, "Please enter something first");
    }
    else {
        if(mysqli_num_rows($results)==1){
            array_push($errors, "There is already an entry present for today");
        }
        else {
            mysqli_query($db,"INSERT INTO entries(username, date, entry) VALUES ('$username', '$date', '$entry')");
            header("Location:index.php");
            exit();
            
        }
    }
}

if (isset($_POST['goback'])) {
    header("Location:index.php");
    exit();
}

if (isset($_POST['delete'])) {
    $username = mysqli_real_escape_string($db, $_SESSION['username']);
    $date = date('Y-m-d',strtotime($_POST['datetoedit']));
    mysqli_query($db,"DELETE FROM entries where username = '$username' AND date = '$date'");
}

