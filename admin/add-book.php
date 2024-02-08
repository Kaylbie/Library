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

if(isset($_POST['add']))
{
$bookname=$_POST['bookname'];

$author=$_POST['author'];
$isbn=$_POST['isbn'];
$bookdate=$_POST['bookdate'];

$sql="INSERT INTO  books(BookName,AuthorId,BookNum,BookDate) VALUES(:bookname,:author,:isbn,:bookdate)";
$query = $dbh->prepare($sql);
$query->bindParam(':bookname',$bookname,PDO::PARAM_STR);

$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->bindParam(':isbn',$isbn,PDO::PARAM_STR);
$query->bindParam(':bookdate',$bookdate,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$_SESSION['msg']="Knyga pridėta sėkmingai";
header('location:manage-books.php');
}
else 
{
$_SESSION['error']="Knygos pridėti nepavyko. Bandykite dar kartą";
header('location:manage-books.php');
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
    <title>Knygos pridėjimas</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />

    <link href="assets/css/font-awesome.css" rel="stylesheet" />

    <link href="assets/css/style.css" rel="stylesheet" />

    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>

<?php include('includes/header.php');?>

    <div class="content-wra
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Pridėti knygą</h4>
                
                            </div>

</div>
<!-- Pridėjimo forma -->
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
Knygos informacija
</div>
<div class="panel-body">
<form role="form" method="post">
<div class="form-group">
<label>Knygos pavadinimas<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="bookname" autocomplete="off"  required />
</div>

<div class="form-group">
<label> Autorius<span style="color:red;">*</span></label>
<select class="form-control" name="author" required="required">
<option value=""> Pasirinkite autorių</option>
<?php 

$sql = "SELECT * from  authors ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->AuthorName);?></option>
 <?php }} ?> 
</select>
</div>

<div class="form-group">
<label>Knygos numeris<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="isbn"  required="required" autocomplete="off"  />

</div>

<div class="form-group">
<label>Knygos išleidimo metai<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="bookdate" autocomplete="off"  required />
</div>

<button type="submit" name="add" class="btn btn-info">Pridėti </button>

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
