<?php
include "conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function check($data){
  $data= trim($data);
  $data= htmlspecialchars($data);
  $data= stripslashes($data);
  return $data;
}
function email_verify($fullname , $email){


$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 0;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                       
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'najeebth9505@gmail.com';                    
    $mail->Password   = 'mbfp cjkg kreq aqob';                    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
    $mail->Port       = 587;                                    

    //Recipients
    $mail->setFrom('najeebth9505@gmail.com', 'RHMS');
    $mail->addAddress($email);     

    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'Email Verification';
    $mail->Body = 'Please click the below link to complete registration: <a href="http://localhost/project/RHMS/rental_house/login.php">Complete Registration</a>';

    $mail->send();
     echo "<script type='text/javascript'>alert('A Message has been sent to your email. Please check  to complete registration');</script>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}

if(isset($_POST["submit"])){

  $fname = check($_POST['FirstName']);
  $lname = check($_POST['LastName']);
  $prog = @check($_POST['programme']);
  $reg = @check($_POST['regno']);
  $occ = @check($_POST['occupation']);
  $pno1 = check($_POST['pno1']);
  $pno2 = check($_POST['pno2']);
  $postal = check($_POST['postal']);
  $city = check($_POST['city']);
  $region = check($_POST['region']);
  $uname = check($_POST['uname']);
  $pword = check($_POST['password']);
  $rpword = check($_POST['repeatPassword']);
  $date_reg = date('Y-m-d');
  #$date_reg1 = date('Y-m-d H:i:s');
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  #$stat = "Active";
  $status = 1;

  // validation//

if (!ctype_alpha($fname) || strlen($fname) < 3 || strlen($fname) > 10) {
    $fnameErr = "The first name should only contain letters and be between 3 and 10 characters long!";
    echo "<script> alert('$fnameErr');</script>";
} elseif (!ctype_alpha($lname) || strlen($lname) < 3 || strlen($lname) > 10) {
    $lnameErr = "The last name should only contain letters and be between 3 and 10 characters long!";
    echo "<script> alert('$lnameErr');</script>";
} elseif (!ctype_alpha($occ)) {
    $occErr = "The occupation should only contain letters!";
    echo "<script> alert('$occErr');</script>";
} elseif (!is_numeric($pno1) || !is_numeric($pno2)) {
    $pno1Err = "The phone number should only contain numbers!";
    echo "<script> alert('$pno1Err');</script>";
} elseif (strlen($pno1) !== 10 || strlen($pno2) !== 10) {
    $pno1Err = "The phone number should be exactly 10 digits long!";
    echo "<script> alert('$pno1Err');</script>";
} elseif (strlen($pword) < 8 || strlen($rpword) < 8) {
    echo "<script> alert('Password is too short');</script>";
} elseif ($pword !== $rpword) {
    echo "<script> alert('Passwords do not match');</script>";
} else {
    // Validation passed, proceed with database operations


    // Hash password
    $pword = md5($pword);

    // Check if username exists
    $sql4 = "SELECT * FROM tenant WHERE u_name = '$uname'";
    $query = mysqli_query($con, $sql4);
    if (mysqli_num_rows($query) > 0) {
        echo "<script> alert('Username already exists!');</script>";
    } else {
        // Insert into database
        $sql = "INSERT INTO tenant VALUES ('','$fname','$lname','$prog','$reg','$occ','$pno1','$pno2','$email','$postal','$city','$region','$uname','$pword','$date_reg','$status')";
        mysqli_query($con, $sql);
        $fullname = $fname . ' ' . $lname;
        email_verify($fullname, $email);
    }
}

 }




?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="wnameth=device-wnameth, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Rental House Management System</title>
  <link rel="icon" href="rent.ico">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body style="background-image: linear-gradient(white,#4e73dd,#4e73df); background-size: cover;">



  <div class="container">

    <div class="card o-hnameden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">

          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4"><b><b>TENANT REGISTRATION</b></b></h1>
              </div>
              <p><span style = "color:#4e73df;"><b><b>PERSONAL PARTICULARS</b></b></span></p>
              <form class="user" action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="FirstName" value="<?php echo @$fname; ?>" placeholder="First Name" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="LastName" value="<?php echo @$lname; ?>" placeholder="Last Name" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    Are you a student?&nbsp&nbsp&nbsp
                    <input type="radio" name="radio"  value="Enable" required>Yes
                  </div>
                  <div class="col-sm-6">
                    <input type="radio" name="radio"  value="Disable">No
                  </div>

                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="programme" value="<?php echo @$prog; ?>"placeholder="Programme e.g; BEDA" disabled>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="regno" value="<?php echo @$reg; ?>" placeholder="Registration Number" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="occupation" value="<?php echo @$occ; ?>" placeholder="Occupation" disabled>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="pno1" value="<?php echo @$pno1; ?>" placeholder="Phone Number 1 e.g; 255717******" required>
                  </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="text" class="form-control form-control-user" name="pno2" value="<?php echo @$pno2; ?>" placeholder="Phone Number 2 e.g; 255717******" required>
                </div>
                <div class="col-sm-6">
                  <input type="email" class="form-control form-control-user" name="email" value="<?php echo @$email; ?>" placeholder="Email Address" required>
                </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="postal" value="<?php echo @$postal; ?>" placeholder="Postal Address" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="city" value="<?php echo @$city; ?>" placeholder="City" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="region" value="<?php echo @$region; ?>" placeholder="Region" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="uname" value="<?php echo @$uname; ?>" placeholder="Username" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" name="repeatPassword" placeholder="Repeat Password" required>
                  </div>
                </div>
                
               
              <center>

                <input class="btn btn-primary btn-user btn-sm" type="submit" name="submit" value="Register Account">

              </center>

              </form>

              <div class="text-center">
                <a class="small" href="forgot-password.php">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script type="text/javascript">
    $('input[name = "radio"]').on('change', function()
    {
      $('input[name = "programme"]').attr('disabled', this.value != "Enable");
      $('input[name = "regno"]').attr('disabled', this.value != "Enable");
      $('input[name = "occupation"]').attr('disabled', this.value != "Disable");
      $('input[name = "programme"]').attr('required', this.value == "Enable");
      $('input[name = "regno"]').attr('required', this.value == "Enable");
      $('input[name = "occupation"]').attr('required', this.value == "Disable");
    });


  </script>
  <!--  
  <script type="text/javascript">
    $("#durations").on('change',function(){
      $('#terms option[value = 2]').attr('disabled',this.value == 3);
      $('#terms option[value = 4]').attr('disabled',this.value == 3);
      $('#terms option[value = 4]').attr('disabled',this.value == 6);

     });


  </script>-->
  <script>
$(document).ready(function(){
    $('input:checkbox').click(function() {
        $('input:checkbox').not(this).prop('checked', false);
    });
});

</script>


<script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
</script>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery-1.12.4.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>


</body>

</html>
