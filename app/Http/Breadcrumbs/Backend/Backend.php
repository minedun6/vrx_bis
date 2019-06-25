<?php

Breadcrumbs::register('admin.dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Tableau de Bord', route('admin.dashboard'));
});

require __DIR__ . '/Search.php';
require __DIR__ . '/Customer.php';
require __DIR__ . '/Box.php';
require __DIR__ . '/Game.php';
require __DIR__ . '/Location.php';
require __DIR__ . '/Worker.php';
require __DIR__ . '/GameHistory.php';
require __DIR__ . '/Access.php';
require __DIR__ . '/LogViewer.php';
