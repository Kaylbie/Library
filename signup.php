<?php 
//Registracija
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signup']))
{

if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Neteisingas patvirtinimo kodas');</script>" ;
    } 
        else {    

$count_my_page = ("userid.txt");
$hits = file($count_my_page);
$hits[0] ++;
$fp = fopen($count_my_page , "w");
fputs($fp , "$hits[0]");
fclose($fp); 
$UserId= $hits[0];   
$fname=$_POST['fullanme'];
$adress=$_POST['adreess'];
$mobileno=$_POST['mobileno'];
$email=$_POST['email']; 
$password=$_POST['password']; 
$status=1;
$sql="INSERT INTO  users(UserId,FullName,MobileNumber,Email,Password,Status,Adress) VALUES(:UserId,:fname,:mobileno,:email,:password,:status,:adress)";
$query = $dbh->prepare($sql);
$query->bindParam(':UserId',$UserId,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':adress',$adress,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
//Vartotojo ID gavimas
if($lastInsertId)
{
echo '<script>alert("Registracija sėkminga jūsų vartotojo ID  "+"'.$UserId.'")</script>';
}
else 
{
echo "<script>alert('Įvyko klaida. Bandykite dar kartą');</script>";
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
    <title>Registracija</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" /> 
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<script type="text/javascript">
//Ar slaptažodžiai sutampa
function valid()
{
if(document.signup.password.value!= document.signup.confirmpassword.value)
{
alert("Slaptažodžiai nesutampa");
document.signup.confirmpassword.focus();
return false;
}
return true;
}
</script>
<script>
//Elektroninio pašto patikra
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>    

</head>
<body>

<?php include('includes/header.php');?>
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Registracija</h4>
                
                            </div>

        </div>
             <div class="row">
  <!-- Vartotojo registracijos forma -->         
<div class="col-md-9 col-md-offset-1">
               <div class="panel panel-danger">
                        <div class="panel-heading">
                           Registracija
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post" onSubmit="return valid();">

<div class="form-group">
<label>Įveskite pilną vardą ir pavardę</label>
<input class="form-control" type="text" name="fullanme" autocomplete="off" required />
</div>

<div class="form-group">
<label>Telefono numeris</label>
<input class="form-control" type="text" name="mobileno" maxlength="10" autocomplete="off" required />
</div>
                                        
<div class="form-group">
<label>E-paštas</label>
<input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()"  autocomplete="off" required  />
   <span id="user-availability-status" style="font-size:12px;"></span> 
</div>

<div class="form-group">
<label>Adresas</label>
<input class="form-control" type="text" name="adreess" autocomplete="off" required />
</div>

<div class="form-group">
<label>Slaptažodis</label>
<input class="form-control" type="password" name="password" autocomplete="off" required  />
</div>

<div class="form-group">
<label>Patvirtinkite slaptažodį </label>
<input class="form-control"  type="password" name="confirmpassword" autocomplete="off" required  />
</div>
 <div class="form-group">
<label>Patvirtinimo kodas : </label>
<input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
</div>                                
<button type="submit" name="signup" class="btn btn-danger" id="submit">Užsiregistruoti </button>

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
