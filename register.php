<?php
include "dbconfig.php";
if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
    $cpwd = mysqli_real_escape_string($conn,$_POST['cpwd']);

    if($name!="" && $email!="" && $pwd!="" && $cpwd!="") {
        if($pwd===$cpwd) {
            $sql_query = "SELECT count(*) AS usercount FROM register WHERE email='$email';";
            $result = mysqli_query($conn,$sql_query);
            $row = mysqli_fetch_array($result);
            if($row['usercount']==0) {
                $hashpwd = password_hash($pwd,PASSWORD_BCRYPT);
                $sql_query = "INSERT INTO users(name,email,password) VALUES ('$name','$email','$hashpwd');";
                $result = mysqli_query($conn,$sql_query);
                if($result) {
                    header("Location:login.php");
                }
                else {
                    $errmsg = "There was an error while signing in. Please try again";
                }
            } else {
                $errmsg = "User account already exists. Please login.";
            }
        }
        else {
            $errmsg = "Passwords entered did not match";
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
    <title>Registration Page</title>
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

    .register-form {
      background: #fff;
      width: 500px;
      margin: 75px auto;
      display: -webkit-box;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
              flex-direction: column;
      border-radius: 4px;
      box-shadow: 0 2px 25px rgba(0, 0, 0, 0.2);
    }
    .register-form h1 {
      padding: 35px 35px 0 35px;
      font-weight: 300;
    }
    .register-form .content {
      padding: 35px;
      text-align: center;
    }
    .register-form .input-field {
      padding: 12px 5px;
    }
    .register-form .input-field input {
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
    .register-form .input-field input::-webkit-input-placeholder {
      text-transform: uppercase;
    }
    .register-form .input-field input::-moz-placeholder {
      text-transform: uppercase;
    }
    .register-form .input-field input:-ms-input-placeholder {
      text-transform: uppercase;
    }
    .register-form .input-field input::-ms-input-placeholder {
      text-transform: uppercase;
    }
    .register-form .input-field input::placeholder {
      text-transform: uppercase;
    }
    .register-form .input-field input:focus {
      border-color: #222;
    }
    .register-form button.link {
      text-decoration: none;
      background-color: green;
      padding:5px 10px;
      border-radius: 5px;
      color:white ;
      letter-spacing: 0.2px;
      text-transform: uppercase;
      display: inline-block;
      margin-top: 20px;
    }
    .register-form .action {
      display: -webkit-box;
      display: flex;
      -webkit-box-orient: horizontal;
      -webkit-box-direction: normal;
              flex-direction: row;
    }
    .register-form .action button {
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
    .register-form .action button:hover {
      background: #d8d8d8;
    }
    .register-form .action button:nth-child(1) {
      background: #2d3b55;
      color: #fff;
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 4px;
    }
    .register-form .action button:nth-child(1):hover {
      background: #3c4d6d;
    }
    .register-form .error {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
    <body>
        <div class="register-form">
            <form method="post" action=""> 
                <h1>Register</h1>
                <div class="content">
                <div class="input-field">
                    <input type="text" placeholder="Username" name="name">
                </div>
                <div class="input-field">
                    <input type="email" placeholder="Email" name="email">
                </div>
                <div class="input-field">
                    <input type="password" placeholder="Password" name="pwd" cautocomplete="new-password">
                </div>
                <div class="input-field">
                    <input type="password" placeholder="Confirm Password" name="cpwd" cautocomplete="new-password">
                </div>
                <p class="error"><?php echo $errmsg ?></p>
                <button type="submit" name="submit" value="login" class="link">SUBMIT</button><br>
                <a href="#" class="link">Forgot Your Password?</a>
                </div>
                <div class="action">
                <button>Register</button>
                <button>Sign in</button>
                
                </div>
            </form>
        </div>
    </body>
</html>