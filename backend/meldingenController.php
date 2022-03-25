<?php

//Variabelen vullen
$attractie = $_POST['attractie'];
if(empty($attractie))
{
	$errors[] = "Vul de attractie-naam in.";
}
$type = $_POST['type'];
if(empty($type))
{
	$errors[] = "Selecteer een type.";
}

$capaciteit = $_POST['capaciteit'];
if(!is_numeric($capaciteit))
{
	$errors[] = "Vul voor capaciteit een geldig getal in.";
	header("Location:../meldingen/index.php?msg=ERROR: capaciteit niet juist ingevuld");
}
if(isset($_POST['prioriteit']))
{
	$prioriteit = true;
}
else
{
	$prioriteit = false;
}

$melder = $_POST['melder'];
if(empty($melder))
{
	$errors[] = "Vul een naam in.";
}
$overig = $_POST['overig'];

if(isset($errors))
{
	var_dump($errors);
	die();
}

//1. Verbinding
require_once 'conn.php';

//2. Query
$query ="INSERT INTO meldingen (attractie, type,  capaciteit, prioriteit, melder, gemeld_op, overige_info) VALUES(:attractie, :type, :capaciteit, :prioriteit, :melder, :gemeld_op, :overige_info)";

//3. Prepare
$statement = $conn->prepare($query);
//4. Execute
$statement->execute([
	":attractie" => $attractie,
	":type" => $type,
	":capaciteit" => $capaciteit,
	":prioriteit" => $prioriteit,
	":melder" => $melder,
	":gemeld_op" => $gemeld_op,
	":overige_info" => $overig,
]);

header("Location:../meldingen/index.php?msg=Melding opgeslagen");
