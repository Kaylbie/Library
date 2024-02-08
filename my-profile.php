<?php 
//Vartotojo profilis
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 
if(isset($_POST['update']))
{    
$sid=$_SESSION['stdid'];  
$fname=$_POST['fullanme'];
$adress=$_POST['adreess'];
$mobileno=$_POST['mobileno'];
$sql="update users set FullName=:fname,MobileNumber=:mobileno, Adress=:adress where UserId=:sid";
$query = $dbh->prepare($sql);
$query->bindParam(':sid',$sid,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':adress',$adress,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->execute();
echo '<script>alert("Profilis sėkmingai atnaujintas")</script>';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Vartotojo profilis</title>
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
                <h4 class="header-line">Vartotojo profilis</h4>
                
                            </div>
        </div>
             <div class="row">
             <!-- Informacija apie vartotojo profilį -->
<div class="col-md-9 col-md-offset-1">
               <div class="panel panel-danger">
                        <div class="panel-heading">
                           Vartotojo profilis
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post">
<?php 
$sid=$_SESSION['stdid'];
$sql="SELECT UserId,FullName,Email,MobileNumber,RegDate,Status, Adress from  users  where UserId=:sid ";
$query = $dbh -> prepare($sql);
$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<div class="form-group">
<label>Vartotojo ID : </label>
<?php echo htmlentities($result->UserId);?>
</div>
<div class="form-group">
<label>Registracijos data : </label>
<?php echo htmlentities($result->RegDate);?>
</div>
<div class="form-group">
<label>Profilio statusas : </label>
<?php if($result->Status==1){?>
<span style="color: green">Aktyvus</span>
<?php } else { ?>
<span style="color: red">Užblokuotas</span>
<?php }?>
</div>
<!-- Vartotojo profilio atnaujinimas -->
<div class="form-group">
<label>Vardas, pavardė</label>
<input class="form-control" type="text" name="fullanme" value="<?php echo htmlentities($result->FullName);?>" autocomplete="off" required />
</div>
<div class="form-group">
<label>Telefono numeris</label>
<input class="form-control" type="text" name="mobileno" maxlength="10" value="<?php echo htmlentities($result->MobileNumber);?>" autocomplete="off" required />
</div>
<div class="form-group">
<label>Adresas</label>
<input class="form-control" type="text" name="adreess" value="<?php echo htmlentities($result->Adress);?>" autocomplete="off" required />
</div>                             
<div class="form-group">
<label>E-paštas</label>
<input class="form-control" type="email" name="email" id="emailid" value="<?php echo htmlentities($result->Email);?>"  autocomplete="off" required readonly />
</div>
<?php }} ?>
<button type="submit" name="update" class="btn btn-primary" id="submit">Atnaujinti </button>
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
<?php } ?>
