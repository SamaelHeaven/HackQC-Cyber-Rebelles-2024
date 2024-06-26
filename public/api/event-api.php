<?php

$terrainId = $_GET["terrainId"] ?? null;

if ($terrainId === null) {
    exit;
}

require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/src/php/services/DatabaseService.php");

$events = DatabaseService::query("SELECT * FROM event WHERE sport_terrain_id = '" . DatabaseService::escapeString($terrainId) . "'");

echo json_encode($events);