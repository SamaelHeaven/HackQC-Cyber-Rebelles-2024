<?php

/*
 * array $event: The event of the page
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/src/php/services/DatabaseService.php");

if (!isset($event)) {
    exit;
}

$sportTerrain = DatabaseService::query("SELECT * FROM sport_terrain WHERE id = '" . $event['sport_terrain_id'] . "'");

if ($sportTerrain === null || sizeof($sportTerrain) === 0) {
    header('location: /public/views/home/');
}

$sportTerrain = $sportTerrain[0];

?>
<div class="mx-2">
    <div class="wrapper-md my-4 border border-2 bg-light rounded p-3">
        <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
            <button class="btn btn-secondary" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <h2>
                <?= htmlspecialchars_decode($event['event_name']) ?>
            </h2>
            <form action="/public/views/event/" method="post">
                <button type="submit" name="deleteEvent" value="<?= htmlspecialchars_decode($event['id']) ?>" class="btn btn-danger">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
        <hr>
        <div class="pb-2">
            <span class="fw-bold">Organisateur:</span> <?= htmlspecialchars_decode($event['organizer']) ?>
        </div>
        <div class="pb-2">
            <span class="fw-bold">Date:</span> Du <?= htmlspecialchars_decode($event['start_date']) ?>
            : <?= substr(htmlspecialchars_decode($event['start_time']), 0, 5) ?>
            à <?= htmlspecialchars_decode($event['start_date']) === htmlspecialchars_decode($event['end_date']) ? "" : htmlspecialchars_decode($event['end_date']) . " : " ?><?= substr(htmlspecialchars_decode($event['end_time']), 0, 5) ?>
        </div>
        <p>
            <span class="fw-bold">Description:</span> <?= htmlspecialchars_decode($event['description']) ?>
        </p>
        <table class="table table-responsive table-striped on-top">
            <tbody>
            <tr>
                <th scope="row">Type de terrain</th>
                <td><?php echo htmlspecialchars_decode($sportTerrain['terrain']) ?> - <?php echo htmlspecialchars_decode($sportTerrain['type']) ?></td>
            </tr>
            <?php if ($sportTerrain['flooring'] !== null): ?>
                <tr>
                    <th scope="row">Revêtement du sol</th>
                    <td><?php echo htmlspecialchars_decode($sportTerrain['flooring']) ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <th scope="row">Municipalité</th>
                <td><?php echo htmlspecialchars_decode($sportTerrain['city']) ?></td>
            </tr>
            <?php if ($sportTerrain['address'] !== null): ?>
                <tr>
                    <th scope="row">Adresse</th>
                    <td><?php echo htmlspecialchars_decode($sportTerrain['address']) ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <th scope="row">Longitude</th>
                <td><?php echo htmlspecialchars_decode($sportTerrain['longitude']) ?></td>
            </tr>
            <tr>
                <th scope="row">Latitude</th>
                <td><?php echo htmlspecialchars_decode($sportTerrain['latitude']) ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
