<?php

Breadcrumbs::register('admin.location.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Gestion des Adresses', route('admin.location.index'));
});

Breadcrumbs::register('admin.location.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.location.index');
    $breadcrumbs->push('Ajouter une Adresse', route('admin.location.create'));
});
