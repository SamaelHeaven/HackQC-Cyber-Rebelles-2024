<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/src/php/models/Template.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/php/models/CurrentPage.php";
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/php/services/DatabaseService.php");

$headTemplate = new Template($_SERVER["DOCUMENT_ROOT"] . "/public/templates/head-template.php");
$headTemplate->setVariable("title", "FitQuest - Ajout d'événement");

$formTemplate = new Template($_SERVER["DOCUMENT_ROOT"] . "/public/templates/add-event-form-template.php");

$legsTemplate = new Template($_SERVER["DOCUMENT_ROOT"] . "/public/templates/legs-template.php");

$terrainId = null;
$organizer = "";
$eventName = "";
$description = "";
$dateStart = "";
$dateEnd = "";
$timeStart = "";
$timeEnd = "";
$errorMessage = "";

$receivedElement = null;
if (isset($_POST['terrainId'])) {
    $terrainId = $_POST['terrainId'];
} else if (isset($_GET['terrainId'])) {
    $terrainId = $_GET['terrainId'];
} else {
    header('Location: ' . "/public/views/home");
}
$receivedElement = DatabaseService::query("SELECT * FROM  sport_terrain where id = '$terrainId'");
if ($receivedElement == []) {
    header('Location: ' . "/public/views/home");
}

$formTemplate->setVariable('terrainId', $terrainId);

if (isset($_POST['organizer']) &&
    isset($_POST['eventName']) &&
    isset($_POST['description']) &&
    isset($_POST['dateStart']) &&
    isset($_POST['dateEnd']) &&
    isset($_POST['timeStart']) &&
    isset($_POST['timeEnd'])) {

    $organizer = DatabaseService::escapeString($_POST['organizer']);
    $eventName = DatabaseService::escapeString($_POST['eventName']);
    $description = DatabaseService::escapeString($_POST['description']);
    $dateStart = DatabaseService::escapeString($_POST['dateStart']);
    $dateEnd = DatabaseService::escapeString($_POST['dateEnd']);
    $timeStart = DatabaseService::escapeString($_POST['timeStart']);
    $timeEnd = DatabaseService::escapeString($_POST['timeEnd']);

    $formTemplate->setVariable('organizer', $organizer);
    $formTemplate->setVariable('eventName', $eventName);
    $formTemplate->setVariable('description', $description);
    $formTemplate->setVariable('dateStart', $dateStart);
    $formTemplate->setVariable('dateEnd', $dateEnd);
    $formTemplate->setVariable('timeStart', $timeStart);
    $formTemplate->setVariable('timeEnd', $timeEnd);


} else {
    $formTemplate->setVariable('detectError', false);
}

?>

<?= $headTemplate->render() ?>

<form class="mt-4 mb-3" action="index.php" method="post">
    <?= $formTemplate->render() ?>
</form>

<?= $legsTemplate->render() ?>
