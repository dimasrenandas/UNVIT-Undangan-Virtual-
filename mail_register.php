<?php 

 ?>
<html>
   
   <head>
      <title>Welcome User</title>
   </head>
   
   <body>
      
      <?php
      
require_once "admin_connect.php";
$sql = "SELECT username , id , fullname , email from users where id = (SELECT max(id) FROM users) ";

$result = $link -> query($sql);

if ($result -> num_rows > 0 )
{
    while ($row = $result -> fetch_assoc())
    {
        $hotspot = $row["username"];
        $user = $row["id"];
        $namanya = $row["fullname"];
        $emailnya = $row["email"];
    }
}

  //  echo "Mengirim Akun ke Email Anda Mohon Menunggu...<br>";
	// echo "Halaman otomatis redirect pada login soda2a...<br>";
         $to = $emailnya;
         $subject = "Welcome to Unvit ";
         $hotspot .= $user;
         $message = '<table width="100%" cellpadding="0" cellspacing="0" border="0">
         <tr>
             <td width="100%">
                 <div class="column-1">
                     <div class="content">
                         <img src="http://id-8.hostddns.us:5465/Event/unvit/assets/img/Logo/logo2.png" alt="" style="max-width:100%;">
                     </div>
                 </div>
                 <div class="column-2">
                     <div class="content">
                         <h2>UNVIT</h2>
                     </div>
                 </div>
             </td>
         </tr>
         <tr>
             <td width="100%">
                 <p>Undangan Virtual</p>
             </td>
         </tr>
         <tr>
         <td width="100%">
             No Hp
         </td>
     </tr>
     <tr>
     <td width="100%">
 <p> UNVIT.id@gmail.com </p>
     </td>
 </tr>
 <tr>
 <td width="100%">
 <p>UNVIT , tinyurl.com/unvit-id</p>
 <a href="https://tinyurl.com/unvit-id">Website.</a>
 </td>
</tr>
<tr>
<td width="100%">
<p>Luangkan waktu sejenak untuk berbagi ulasan pengalaman </p><a href="https://tinyurl.com/ulasansoda2a">Review Kami disini. </a> <p>terimakasih.</p>
</td>
</tr>
         <tr>
         <td width="100%">
             <p>Hi '.$namanya.',
             Selamat Datang di aplikasi website Unvit Terimakasih telah memilih untuk tinggal bersama kami dan berharap dapat memberikan Anda pengalaman yang tak terlupakan.
             Untuk kenyamanan Anda, Kami mengucapkan terima kasih telah memilih Aplikasi ini dan berharap Anda mendapatkan pengalaman event yang tak terlupakan..</p>
         </td>
     </tr>
     <br>
     <tr>
     <td width="100%">
     <p>Terimakasih Salam,</p>
   <p>  ( MANAGEMENT UNVIT)</p>
 </td>
</tr>
     </table>';
if (!empty($emailnya))
{
          $header = "From:abc@somedomain.com \r\n";
          $header .= "Cc:soda2a.sub@gmail.com \r\n";
          $header .= "MIME-Version: 1.0\r\n";
          $header .= "Content-type: text/html\r\n";
          $retval = mail ($emailnya,$subject,$message,$header);
          if( $retval == true ) {
                echo '<script type="text/javascript">'; 
                echo 'alert("Welcome user berhasil di kirim ke email anda! Apabila tidak menerima inbox silhakan check folder spam email anda. Halaman ini akan redirect login soda2a mohon segera mengupload scan foto identitas anda setelah login.");'; 
                //echo 'window.location.href = "users_login.php";';
                echo '</script>';
          }else {
             echo '<script type="text/javascript">'; 
                echo 'alert("Mohon Maaf Sedang Terjadi Kesalahan");'; 
                //echo 'window.location.href = "users_login.php";';
                echo '</script>';

          }
}
else
{
 echo '<script type="text/javascript">'; 
                echo 'alert("Nothing Found Here !");'; 
                //echo 'window.location.href = "users_login.php";';
                echo '</script>';

echo "Data tidak ditemukan.";
}

      ?>
      
   </body>
</html>