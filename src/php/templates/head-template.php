<?php

/*
 * string $title: The title of the page
 * CurrentPage $currentPage: The current page of the site
 */

require_once dirname($_SERVER["DOCUMENT_ROOT"]) . "/src/php/models/CurrentPage.php";

$title ??= "";
$currentPage ??= CurrentPage::None;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="/stylesheets/vendor/leaflet/marker-cluster.css">
    <link rel="stylesheet" href="/stylesheets/vendor/nova/nova.css">
    <link rel="stylesheet" href="/stylesheets/fit-quest/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/he/1.2.0/he.js"></script>
    <script src="/javascript/vendor/leaflet/marker-cluster.js"></script>
    <script type="module" src="/javascript/main.js"></script>
    <link rel="icon" type="image/png" href="/images/fit-quest-logo.png">
    <title><?= $title ?></title>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PN72YDLFT7"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'G-PN72YDLFT7');
</script>
<body>
<main class="d-flex flex-column justify-content-between home-body">
    <nav class="navbar navbar-expand-md bg-body-tertiary shadow-lg">
        <div class="container">
            <header class="w-100 d-md-flex justify-content-between">
                <div class="d-flex justify-content-between gap-2 flex-wrap">
                    <a class="navbar-brand d-flex gap-2 align-items-center" href="/views/home">
                        <img src="/images/fit-quest-logo.png" alt="Logo"
                             class="d-inline-block align-text-top nav-logo">
                        <h1 class="nav-name fw-light mb-0">FitQuest</h1>
                    </a>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#mobileMenu"
                                aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="mobileMenu">
                    <div class="navbar-nav w-100 d-flex flex-row align-items-center justify-content-end gap-4 ">
                        <a class="nav-link<?= $currentPage === CurrentPage::Home ? " active" : "" ?>"
                           href="/views/home">Accueil</a>
                        <a class="nav-link<?= $currentPage === CurrentPage::About ? " active" : "" ?>"
                           href="/views/about">À propos</a>
                    </div>
                </div>
            </header>
        </div>
    </nav>