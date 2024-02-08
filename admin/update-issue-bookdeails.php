<?php
session_start();
error_reporting(0);
include('includes/config.php');
//Patikra ar administratorius prisijungęs
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['return']))
{
$rid=intval($_GET['rid']);

$rstatus=1;
$sql="update Issuedbooks set ReturnStatus=:rstatus where id=:rid";
$query = $dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);

$query->bindParam(':rstatus',$rstatus,PDO::PARAM_STR);
$query->execute();

$_SESSION['msg']="Knyga sėkmingai grąžinta";
header('location:manage-issued-books.php');



}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Išduotos knygos</title>
   
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
   
    <link href="assets/css/style.css" rel="stylesheet" />
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<script>

function getstudent() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_user.php",
data:'userid='+$("#userid").val(),
type: "POST",
success:function(data){
$("#get_student_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

function getbook() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_book.php",
data:'bookid='+$("#bookid").val(),
type: "POST",
success:function(data){
$("#get_book_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

</script> 
<style type="text/css">
  .others{
    color:red;
}

</style>


</head>
<body>
<!-- Išduotų knygų grąžinimas -->    
<?php include('includes/header.php');?>

    <div class="content-wra
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Išduotos knygos</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1"">
<div class="panel panel-info">
<div class="panel-heading">
Išduotos knygos
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$rid=intval($_GET['rid']);
$sql = "SELECT users.FullName,books.BookName,books.BookNum,Issuedbooks.IssuesDate,Issuedbooks.ReturnDate,Issuedbooks.id as rid,Issuedbooks.ReturnStatus from  Issuedbooks join users on users.UserId=Issuedbooks.UserId join books on books.id=Issuedbooks.BookId where Issuedbooks.id=:rid";
$query = $dbh -> prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                   
<!-- Kam išduota knyga -->


<div class="form-group">
<label>Vartotojo vardas, pavardė :</label>
<?php echo htmlentities($result->FullName);?>
</div>

<div class="form-group">
<label>Knygos pavadinimas :</label>
<?php echo htmlentities($result->BookName);?>
</div>


<div class="form-group">
<label>Knygos numeris :</label>
<?php echo htmlentities($result->BookNum);?>
</div>

<div class="form-group">
<label>Knygos išdavimo data :</label>
<?php echo htmlentities($result->IssuesDate);?>
</div>


<div class="form-group">
<label>Knygos grąžinimo data :</label>
<?php if($result->ReturnDate=="")
                                            {
                                                echo htmlentities("Negrąžinta");
                                            } else {


                                            echo htmlentities($result->ReturnDate);
}
                                            ?>
</div>

 <?php if($result->ReturnStatus==0){?>

<button type="submit" name="return" id="submit" class="btn btn-info">Grąžinti knygą </button>

 </div>

<?php }}} ?>
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
