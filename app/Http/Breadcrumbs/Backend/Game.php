<?php

Breadcrumbs::register('admin.game.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Gestion des Jeux', route('admin.game.index'));
});

Breadcrumbs::register('admin.game.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.game.index');
    $breadcrumbs->push('Ajouter un Jeu', route('admin.game.create'));
});
