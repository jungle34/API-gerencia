<?php 
$hostnameAPI = "localhost";
$dbAPI = "u934542582_usercontrol";
$dbuserAPI = "u934542582_ruth10";
$dbpassAPI = "SuMm9JY8+";

$conn = new mysqli($hostnameAPI, $dbuserAPI, $dbpassAPI, $dbAPI);
if ($conn ->connect_errno){
	echo "não deu certo por causa disso :" . $conn->connect_errno . "." . $conn->connect_error;
} else {
	// echo "Conectado com sucesso!";
}