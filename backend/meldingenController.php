<?php
$action = $_POST['action'];
require_once 'conn.php';
if($action == "create"){
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
	$gemeld_op = $_POST['gemeld_op'];
	if(empty($gemeld_op))
	{
		$errors[]= "Vul een datum in.";
	}
	$overig = $_POST['overig'];

	if(isset($errors))
	{
		var_dump($errors);
		die();
	}
	$query ="INSERT INTO meldingen (attractie, type,  capaciteit, prioriteit, melder, gemeld_op, overige_info) VALUES(:attractie, :type, :capaciteit, :prioriteit, :melder, :gemeld_op, :overige_info)";

	$statement = $conn->prepare($query);
	
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
}

if ($action == "update") {

	$capaciteit = $_POST['capaciteit'];
	$prioriteit = $_POST['prioriteit'];
	if (isset($_POST['prioriteit']))
	{
		$prioriteit = true;
	}
	else
	{
		$prioriteit = false;
	}

	$query = "UPDATE meldingen SET capaciteit = :capaciteit, prioriteit = :prioriteit, melder = :melder, overige_info = :overige_info WHERE id = :id";


	$statement = $conn->prepare($query);

	$statement->execute([	
		":capaciteit" => $capaciteit,
		":prioriteit" => $prioriteit,
		":melder" => $_POST['melder'],
		":overige_info" => $_POST['overig'],
		":id" => $_POST['id'],
	]);
	header("Location:../meldingen/index.php?msg=Melding updated");
}