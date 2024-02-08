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

   
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=0;
$sql = "update users set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:reg-users.php');
}




if(isset($_GET['id']))
{
$id=$_GET['id'];
$status=1;
$sql = "update users set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:reg-users.php');
}

if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from users  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$_SESSION['delmsg']="Vartotojas pašalintas";
header('location:reg-users.php');

}

    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Vartotojai</title>
   
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
   
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
   
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    
    <link href="assets/css/style.css" rel="stylesheet" />
   
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
     
<?php include('includes/header.php');?>

    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Vartotojai</h4>
    </div>

<!-- Informacija apie registruotus vartotojus -->
        </div>
            <div class="row">
                <div class="col-md-12">
                   
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Registruoti vartotojai
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Vartotojo ID</th>
                                            <th>Vardas, pavardė</th>
                                            <th>E-paštas </th>
                                            <th>Telefono numeris</th>
                                            <th>Adresas</th>
                                            <th>Registracijos data</th>
                                            <th>Statusas</th>
                                            <th>Veiksmas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT * from users";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                              <!-- Duomenys -->        
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->UserId);?></td>
                                            <td class="center"><?php echo htmlentities($result->FullName);?></td>
                                            <td class="center"><?php echo htmlentities($result->Email);?></td>
                                            <td class="center"><?php echo htmlentities($result->MobileNumber);?></td>
                                            <td class="center"><?php echo htmlentities($result->Adress);?></td>
                                            <td class="center"><?php echo htmlentities($result->RegDate);?></td>
                                            <td class="center"><?php if($result->Status==1)
                                            {
                                                echo htmlentities("Aktyvus");
                                            } else {


                                            echo htmlentities("Užblokuotas");
}
                                            ?></td>
                                            <td class="center">
                                            
                                            
<?php if($result->Status==1)
 {?>
<a href="reg-users.php?inid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Ar tikrai norite užblokuoti vartotoją? ');"" >  <button class="btn btn-danger"> Užblokuoti</button>

<?php } else {?>

                                            
                                            <a href="reg-users.php?id=<?php echo htmlentities($result->id);?>" onclick="return confirm('Ar tikrai norite aktyvuoti vartotoją ?');""><button class="btn btn-primary"> Suaktyvinti</button> 
                                            
                                            <?php } ?>
                                            <p></p>
                                            <a href="reg-users.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Ar tikrai norite pašalinti ?');"" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> Pašalinti</button>
                                            </td>
                                            
                                        </tr>
                                        
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                   
                </div>
            </div>


            
    </div>
    </div>

    
  <?php include('includes/footer.php');?>
      
    <script src="assets/js/jquery-1.10.2.js"></script>
   
    <script src="assets/js/bootstrap.js"></script>
    
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
     
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
