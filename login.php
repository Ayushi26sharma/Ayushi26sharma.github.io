<?php 

include "dbconfig.php";

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);

    if($email!="" && $pwd!="") {
        $sql_query = "SELECT count(*) AS usercount FROM user WHERE email='$email';";
        $result = mysqli_query($conn,$sql_query);
        $row = mysqli_fetch_array($result);
        if($row['usercount']==1) {
            $sql_query = "SELECT name AS username,email As useremail,id AS userid,password AS hashpwd FROM users WHERE email='$email';";
            $result = mysqli_query($conn,$sql_query);
            $row = mysqli_fetch_array($result);
            if(password_verify($pwd,$row['hashpwd'])) {
              $_SESSION['userid'] = $row['userid'];
              $_SESSION['username'] = $row['username'];
              $_SESSION['useremail'] = $row['useremail'];
              header("location:index.php");
            }
            else {
              $errmsg = "Username and password did not match";
            }
        }
        else if($row['usercount']==0) {
            $errmsg = "Username and password did not match";
        }
        else {
            $errmsg = "There was an error while logging in. Please try again";
        }
    }
    else {
        $errmsg = "All fields are mandatory";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      -webkit-font-smoothing: antialiased;
    }

    body {
      background: #e35869;
      font-family: 'Rubik', sans-serif;
    }

    .login-form {
      background: #fff;
      width: 500px;
      margin: 125px auto;
      display: -webkit-box;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
              flex-direction: column;
      border-radius: 4px;
      box-shadow: 0 2px 25px rgba(0, 0, 0, 0.2);
    }
    .login-form h1 {
      padding: 35px 35px 0 35px;
      font-weight: 300;
    }
    .login-form .content {
      padding: 35px;
      text-align: center;
    }
    .login-form .input-field {
      padding: 12px 5px;
    }
    .login-form .input-field input {
      font-size: 16px;
      display: block;
      font-family: 'Rubik', sans-serif;
      width: 100%;
      padding: 10px 1px;
      border: 0;
      border-bottom: 1px solid #747474;
      outline: none;
      -webkit-transition: all .2s;
      transition: all .2s;
    }
    .login-form .input-field input::-webkit-input-placeholder {
      text-transform: uppercase;
    }
    .login-form .input-field input::-moz-placeholder {
      text-transform: uppercase;
    }
    .login-form .input-field input:-ms-input-placeholder {
      text-transform: uppercase;
    }
    .login-form .input-field input::-ms-input-placeholder {
      text-transform: uppercase;
    }
    .login-form .input-field input::placeholder {
      text-transform: uppercase;
    }
    .login-form .input-field input:focus {
      border-color: #222;
    }
    .login-form button.link {
      text-decoration: none;
      background-color: green;
      padding:5px 10px;
      border-radius: 5px;
      color:white;
      letter-spacing: 0.2px;
      text-transform: uppercase;
      display: inline-block;
      margin-top: 20px;
      margin-bottom: 10px;
    }
    .login-form .action {
      display: -webkit-box;
      display: flex;
      -webkit-box-orient: horizontal;
      -webkit-box-direction: normal;
              flex-direction: row;
    }
    .login-form .action button {
      width: 100%;
      border: none;
      padding: 18px;
      font-family: 'Rubik', sans-serif;
      cursor: pointer;
      text-transform: uppercase;
      background: #e8e9ec;
      color: #777;
      border-bottom-left-radius: 4px;
      border-bottom-right-radius: 0;
      letter-spacing: 0.2px;
      outline: 0;
      -webkit-transition: all .3s;
      transition: all .3s;
    }
    .login-form .action button:hover {
      background: #d8d8d8;
    }
    .login-form .action button:nth-child(1) {
      background: #2d3b55;
      color: #fff;
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 4px;
    }
    .login-form .action button:nth-child(1):hover {
      background: #3c4d6d;
    }
    .login-form .error {
      color: red;
      margin-top: 20px;
      margin-bottom: 10px;
    }

  </style>
</head>
    <body>
        <div class="login-form">
            <form method="post" action=""> 
                <h1>Login</h1>
                <div class="content">
                <div class="input-field">
                    <input type="email" placeholder="Email" name="email">
                </div>
                <div class="input-field">
                    <input type="password" placeholder="Password" name="pwd" cautocomplete="new-password">
                <div>
                <p class="error"></p>
                <button type="submit" name="Submit" value="submit" class="link">Login</button><br>
                <a href="#" class="link">Forgot Your Password?</a>
            
                </div>
                <div class="action">
                <button>Sign in</button>
                <button>Register</button>
                </div>
            </form>
        </div>
    </body>
</html>