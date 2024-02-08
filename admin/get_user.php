<?php 
//Vartotojo ieškojimas išduodant knygą
require_once("includes/config.php");
if(!empty($_POST["userid"])) {
  $userid= strtoupper($_POST["userid"]);
 
  $sql ="SELECT FullName,Status FROM users WHERE UserId=:userid";
$query= $dbh -> prepare($sql);
$query-> bindParam(':userid', $userid, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
foreach ($results as $result) {
if($result->Status==0)
{
echo "<span style='color:red'> Vartotojas užblokuotas </span>"."<br />";
echo "<b>Vartotojo vardas, pavardė-</b>" .$result->FullName;
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else {
?>


<?php  
echo htmlentities($result->FullName);
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
}
 else{
  
  echo "<span style='color:red'> Neteisingas vartotojo ID. Bandykite dar kartą</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
}
}



?>
