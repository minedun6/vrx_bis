<?php

Breadcrumbs::register('admin.box.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Gestion des Boxes', route('admin.box.index'));
});

Breadcrumbs::register('admin.box.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.box.index');
    $breadcrumbs->push('Ajouter une Boxe', route('admin.box.create'));
});

Breadcrumbs::register('admin.box.show', function ($breadcrumbs, $box) {
    $breadcrumbs->parent('admin.box.index');
    $breadcrumbs->push('Affichage détails Box : ' . $box->code, route('admin.box.show', $box));
});

Breadcrumbs::register('admin.box.edit', function ($breadcrumbs, $box) {
    $breadcrumbs->parent('admin.box.index');
    $breadcrumbs->push('Editer Box : ' . $box->code, route('admin.box.edit', $box));
});
