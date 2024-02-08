<?php
//Slaptažodžio atkūrimas jei telefono numeris ir elektroninis sutampa
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['change']))
{

if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Neteisingas patvirtinimo kodas');</script>" ;
    } 
        else {
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$newpassword=$_POST['newpassword'];
  $sql ="SELECT Email FROM users WHERE Email=:email and MobileNumber=:mobile";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update users set Password=:newpassword where Email=:email and MobileNumber=:mobile";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
$chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
echo "<script>alert('Slaptažodis sėkmingai pakeistas');</script>";
}
else {
echo "<script>alert('E-paštas arba telefono numeris neteisingas');</script>"; 
}
}
}
?>
<!DOCTYPE html>
<html xmlns="http://ww
w.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Slaptažodžio atkūrimas </title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />

    <link href="assets/css/font-awesome.css" rel="stylesheet" />

    <link href="assets/css/style.css" rel="stylesheet" />

    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <script type="text/javascript">
     //Ar slaptažodžiai sutampa
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("Slaptažodžiai nesutampa. Bandykite dar kartą");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>

</head>
<body>

<?php include('includes/header.php');?>

<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<!-- Slaptažodžio atkūrimo forma -->
<h4 class="header-line">Slaptažodžio atkūrimas</h4>
</div>
</div>
             
          
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<div class="panel-heading">
 Atkūrimas
</div>
<div class="panel-body">
<form role="form" name="chngpwd" method="post" onSubmit="return valid();">

<div class="form-group">
<label>E-paštas</label>
<input class="form-control" type="email" name="email" required autocomplete="off" />
</div>

<div class="form-group">
<label>Telefono numeris</label>
<input class="form-control" type="text" name="mobile" required autocomplete="off" />
</div>

<div class="form-group">
<label>Slaptažodis</label>
<input class="form-control" type="password" name="newpassword" required autocomplete="off"  />
</div>

<div class="form-group">
<label>Patvirtinkite slaptažodį</label>
<input class="form-control" type="password" name="confirmpassword" required autocomplete="off"  />
</div>

 <div class="form-group">
<label>Patvirtinimo kodas : </label>
<input type="text" class="form-control1"  name="vercode" maxlength="5" autocomplete="off" required  style="height:25px;" />&nbsp;<img src="captcha.php">
</div> 

 <button type="submit" name="change" class="btn btn-info">Pakeisti slaptažodį</button> | <a href="index.php">Login</a>
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
