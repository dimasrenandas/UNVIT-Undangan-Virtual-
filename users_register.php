<?php
// Include config file
require_once "cobaconnectdb.php";
// Define variables and initialize with empty values
$username = $email = $password = $confirm_password =$phone = $status=$kota=$address=$agree=$fullname="";
$username_err = $email_err = $password_err = $confirm_password_err = $phone_err=$status_err=$kota_err=$address_err=$agree_err=$fullname_err="";  
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
      //validate fullname
      if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Mohon isi Nama Lengkap Anda .";     
    }
    elseif(strlen(trim($_POST["fullname"])) < 5){
        $fullname_err = "Mohon Isi Nama Lengkap Dengan Benar";
    }
    else{
        $fullname = trim($_POST["fullname"]);
    }
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

// Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter valid email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt2 = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt2, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt2)){
                /* store result */
                mysqli_stmt_store_result($stmt2);
                
                if(mysqli_stmt_num_rows($stmt2) == 1){
                    $email_err = "This email is already taken.";
                } 
                elseif(strlen(trim($_POST["email"])) < 12)
                {
                    $email_err = "Please enter valid email .";
                }
                else
                {
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt2);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //validate No Handphone
    if(empty(trim($_POST["confirm_phone"]))){
        $phone_err = "Please Enter a Phone Number .";     
    }
    elseif(strlen(trim($_POST["confirm_phone"])) < 9){
        $phone_err = "Phone Number must have atleast 9 characters.";
    }
    else{
        $phone = trim($_POST["confirm_phone"]);
    }

     //validate Status
     if(empty(trim($_POST["status"]))){
        $status_err = "Mohon Pilih Status Anda .";     
    }
    else{
        $status = trim($_POST["status"]);
    }

    //validate kota
    if(empty(trim($_POST["kota"]))){
        $kota_err = "Mohon Pilih Kota Asal Anda .";     
    }
    else{
        $kota = trim($_POST["kota"]);
    }

     //validate alamat
     if(empty(trim($_POST["address"]))){
        $address_err = "Mohon isi alamat Anda .";     
    }
    elseif(strlen(trim($_POST["address"])) < 6){
        $address_err = "Mohon Isi Alamat Dengan Benar";
    }
    else{
        $address = trim($_POST["address"]);
    }

    if(empty(trim($_POST["agree"]))){
        $agree_err = "Mohon Menyetujui Peraturan Smart Kost Anda .";     
    }
    else{
        $agree = trim($_POST["agree"]);
    }
    
    // Check input errors before inserting in database
      if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err) && empty($status_err) &&empty($kota_err) &&empty($address_err) &&empty($agree_err) &&empty($email_err) &&empty($fullname_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (fullname,username,email, password , phone , status , kota , address) VALUES (?,?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss",$param_fullname,$param_username,$param_email, $param_password , $param_phone , $param_status , $param_kota , $param_address);
            
            // Set parameters
            $param_fullname = $fullname;
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_phone = $phone;
            $param_status = $status;
            $param_kota = $kota;
            $param_address = $address;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo '<script type="text/javascript">'; 
                echo 'alert("Akun Berhasil dibuat!");'; 
                echo 'window.location.href = "mail_register.php";';
                echo '</script>';
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }    
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="pace/pace.js"></script>
<link href="pace/themes/silver/pace-theme-flash.css" rel="stylesheet" />

    <style type="text/css">
        body{

 font: 14px sans-serif; 
background-image: url("/SODA/uploads/bg.jpg");
		background-repeat:no-repeat;
		background-size:cover;
		background-position:center;




}
        .wrapper{ width: 800px; padding: 20px; }
    </style>
</head>
<body>
<div class="container-fluid  d-flex justify-content-center">
    <div class="wrapper bg-secondary text-white ">
    <?php 
            if (!empty($fullname_err))
            {
                echo '<script type="text/javascript">'; 
                echo 'alert("Cek Kembali Nama Lengkap Anda!");'; 
                echo 'window.location.href = "users_register.php";';
                echo '</script>';
            }
            else if(!empty($username_err))
            {
                echo '<script type="text/javascript">'; 
                echo 'alert("Cek Kembali Username Anda!");'; 
                echo 'window.location.href = "users_register.php";';
                echo '</script>';
            }
            else if (!empty($email_err))
            {
                echo '<script type="text/javascript">'; 
                echo 'alert("Cek Kembali Email Anda!");'; 
                echo 'window.location.href = "users_register.php";';
                echo '</script>';
            }

            else if (!empty($password_err))
            {
                echo '<script type="text/javascript">'; 
                echo 'alert("Cek Kembali Password Anda!");'; 
                echo 'window.location.href = "users_register.php";';
                echo '</script>';
            }
            else if (!empty($confirm_password_err))
            {
                echo '<script type="text/javascript">'; 
                echo 'alert("Cek Kembali konfirmasi Password Anda!");'; 
                echo 'window.location.href = "users_register.php";';
                echo '</script>';
            }

            else if (!empty($status_err))
            {
               
            
                echo '<script type="text/javascript">'; 
                echo 'alert("Mohon isi Status Anda !");'; 
                echo 'window.location.href = "users_register.php";';
                echo '</script>';
            
            }

            else if (!empty($phone_err))
            {
               
                if(strlen(trim($_POST["confirm_phone"])) < 9)
                {
                    echo '<script type="text/javascript">'; 
                    echo 'alert("Nomor Handphone Minimal > 9 digit angka!");'; 
                    echo 'window.location.href = "users_register.php";';
                    echo '</script>';
                }
                echo '<script type="text/javascript">'; 
                echo 'alert("isi Nomor Handphone yang benar memiliki > 9 digit angka!");'; 
                echo 'window.location.href = "users_register.php";';
                echo '</script>';
            
            }

            else if (!empty($kota_err))
            {
               
            
                echo '<script type="text/javascript">'; 
                echo 'alert("Mohon isi Asal Kota Anda!");'; 
                echo 'window.location.href = "users_register.php";';
                echo '</script>';
            
            }

            else if (!empty($address_err))
            {
               
            
                echo '<script type="text/javascript">'; 
                echo 'alert("Mohon Isi alamat dengan benar!");'; 
                echo 'window.location.href = "users_register.php";';
                echo '</script>';
            
            }

            else if (!empty($agree_err))
            {
                echo '<script type="text/javascript">'; 
                echo 'alert("Mohon Menyetujui Peraturan Unvit dengan klik box pada form !");'; 
                echo 'window.location.href = "users_register.php";';
                echo '</script>';
            }

            
            ?>


<div class="text-center">
<a class="nav-link" href="index.html"><img src="img/Logo/logo2.png" class="rounded-circle" alt="Logo" width="100" height="100"> </a>
<br>
<br>
            <br>
</div>
<h2>Tamu Undangan</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($fullname_err)) ? 'has-error' : ''; ?>">
                <label>Nama Lengkap </label>
                <input type="text" name="fullname" class="form-control" value="<?php echo $fullname; ?>"required>
                <span class="help-block"><?php echo $fullname_err; ?></span>
            </div>   
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>E-mail</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>"required>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($password_err) ) ? 'has-error' : ''; ?>">
            
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>"required>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>"required>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>">
                <label>Status / Pekerjaan</label>
                <select id="selectType" name="status" class = "custom-select">
                <option value="">--Pilihan--</option> 
                <option value="Mahasiswa" >Pelajar/Mahasiswa</option> 
		<option value="PNS" >PNS</option> 
                <option value="Swasta">Swasta</option> 

                </select>
                <span class="help-block"><?php echo $status_err; ?></span>
               
            </div>
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>No Handphone</label>
                <input type="text" name="confirm_phone" class="form-control" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" value="<?php echo $phone; ?>"required>
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($kota_err)) ? 'has-error' : ''; ?>">
                <label>Kota</label>
                <select id="selectType" class = "custom-select" name="kota" >
                <option value="">--Pilihan--</option> 
                <?php
                require_once "cobaconnectdb.php";
                  $sql="SELECT  id_kota , kota FROM kota";
                  $result = $link -> query($sql);
                  while ($row = $result -> fetch_assoc()) {
                ?>
                  <option value="<?=$row['kota']?>"><?=$row['kota']?></option> 
                <?php
                  }
                ?>
                <span class="help-block"><?php echo $kota_err; ?></span>
                </select>
                
            </div>
            <div class="form-group">
                <label>Alamat </label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>"required>
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>
            <div class="form-group">
            <input type="checkbox" name="agree" id="agree" value="agree" required/> <label for='agree'>Menyetujui <a target="_blank" rel="noopener noreferrer"  href="uploads/asset/doc/agreement.pdf">Peraturan</a> UNVIT.</label>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-info" value="Submit">
                <input type="reset" class="btn btn-warning" value="Reset">
            </div>
            <p>Sudah Memiliki Akun? <a href="users_login.php">Login disini</a>.</p>
            </form>  
            
    </div>  
    
</div>

</body>
</html>