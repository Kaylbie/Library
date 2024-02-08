<?php 
//Patikra ar yra užregistruotas elektroninis paštas
require_once("includes/config.php");

if(!empty($_POST["emailid"])) {
	$email= $_POST["emailid"];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

		echo "klaida : Neteisingas e-paštas";
	}
	else {
		$sql ="SELECT Email FROM users WHERE Email=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Vartotojas su šiuo e-paštu jau užregistruotas</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> E-paštas galimas registracijai</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
}


?>
