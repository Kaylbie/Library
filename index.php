<?php
session_start();
//Prisijungimas
error_reporting(0);
include('includes/config.php');
if($_SESSION['login']!=''){
$_SESSION['login']='';
}
if(isset($_POST['login']))
{
//Patvirtinimo kodo patikra
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Neteisingas patvirtinimo kodas');</script>" ;
    } 
        else {
$email=$_POST['emailid'];
$password=$_POST['password'];
$sql ="SELECT Email,Password,UserId,Status FROM users WHERE Email=:email and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)
{
 foreach ($results as $result) {
 $_SESSION['stdid']=$result->UserId;
 //Ar vartotojas neužblokuotas
if($result->Status==1)
{
$_SESSION['login']=$_POST['emailid'];
echo "<script type='text/javascript'> document.location ='my-profile.php'; </script>";
} else {
echo "<script>alert('Vartotojas užblokuotas. Susisiekite su administratoriumi');</script>";

}
}

} 

else{
echo "<script>alert('Neteisingi duomenys');</script>";
}
}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Prisijungimas</title>
   
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
   
    <link href="assets/css/style.css" rel="stylesheet" />
   
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>

<?php include('includes/header.php');?>

<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<h4 class="header-line">Prisijungimas</h4>
</div>
</div>
   <!-- Vartotojo prisijungimo forma -->          
         
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<div class="panel-heading">
 Prisijungimas
</div>
<div class="panel-body">
<form role="form" method="post">

<div class="form-group">
<label>E-paštas</label>
<input class="form-control" type="text" name="emailid" required autocomplete="off" />
</div>
<div class="form-group">
<label>Slaptažodis</label>
<input class="form-control" type="password" name="password" required autocomplete="off"  />
<p class="help-block"><a href="user-forgot-password.php">Atkurti slaptažodį`</a></p>
</div>

 <div class="form-group">
<label>Patvirtinimo kodas : </label>
<input type="text" class="form-control1"  name="vercode" maxlength="5" autocomplete="off" required  style="height:25px;" />&nbsp;<img src="captcha.php">
</div> 

 <button type="submit" name="login" class="btn btn-info">Prisijungti </button> | <a href="signup.php">Registracija</a>
</form>
 </div>
</div>
</div>
</div>  
           
             
 
    </div>
    </div>
 
 <?php include('includes/footer.php');?>

    <script src="assets/js/jquery-1.10.2.js"></script>

    <script src="assets/js/bootstrap.js"></script>

    <script src="assets/js/custom.js"></script>

</body>
</html>
