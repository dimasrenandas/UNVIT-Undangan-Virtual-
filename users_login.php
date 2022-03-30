
<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header("location: index.php");
    exit;
}
require_once "cobaconnectdb.php";


$username = $password = "";
$username_err = $password_err="";


if($_SERVER["REQUEST_METHOD"]=="POST")
{
 
   
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Mohon input username atau email anda.";
      
    }
    else
    {
        $username = trim($_POST["username"]);
       
    }

    if(empty(trim($_POST["password"])))
    {
        $password_err = "Mohon input password anda.";
       
     
    }
    else
    {
        $password = trim($_POST["password"]);
    }

    if(empty($username_err) && empty($password_err))
    {
        $sql = "SELECT id , username,password FROM users WHERE username = ? OR email = ? LIMIT 1";
        if($stmt = mysqli_prepare($link,$sql))
        {
            mysqli_stmt_bind_param($stmt,"ss",$param_username,$param_username);

            $param_username = $username;

            if (mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt)==1)
                {
                    mysqli_stmt_bind_result($stmt,$id,$username,$hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if (password_verify($password,$hashed_password))
                        {
                            session_start ();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"]=$id;
                            $_SESSION["username"]=$username;

                            header("location: users_welcome.php");
                        }
                        else
                        {

                            $password_err = "Password Yang di Masukkan Salah !";
                           
                           

                        }
                    }
                }else{
                    $username_err = "Akun Tidak Terdaftar !";
                   
                }
            }else{
                echo "Oops! Something went wrong. Please Try Again Later";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);

 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
 <link href="fa5/css/all.css" rel="stylesheet"> <!--load all styles -->
<script src="pace/pace.js"></script>
<link href="pace/themes/silver/pace-theme-flash.css" rel="stylesheet" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">


    <style type="text/css">
        body{ 

		font: 14px sans-serif; 
		background-image: url("/SODA/uploads/bg.jpg");
		background-repeat:no-repeat;
		background-size:cover;
		background-position:center;


	     }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
 <div class="container py-5 d-flex justify-content-center ">
    <div class=" wrapper bg-secondary text-white ">
        <center>
        <a class="nav-link" href="index.html"><img src="img/Logo/logo2.png" class="rounded-circle" alt="Logo"  style="float:center"></a>
        </center>
        <form method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
               <i class="fas fa-user"> Username</i><input type="text" name="username" class="form-control" placeholder="Email/Username">
                <span class="help-block bg-danger"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <i class="fas fa-key"> Password</i><input type="password" name="password" class="form-control" placeholder="Password">
                <span class="help-block bg-danger"><?php echo $password_err ;echo"<br>"; ?></span>
                <br>
                <p>Belum Memiliki Akun? <a href="users_register.php" class="text-warning">Daftar Sekarang</a>.</p>
                <br>
                <p>Forgot Password? <a href="#" class="text-warning">Reset Password</a>.</p>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-success" value="Login"></input>
<br> <br> 
            <a href="uploads/asset/doc/soda2amobilev2.0.apk"class="form-control btn btn-dark">Unvit_Mobile_v1.0.Apk</a> 

            </div>
        </form>
    </div>    
</div>
</body>
</html>
