<?php

Breadcrumbs::register('admin.worker.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Gestion des Supérviseurs', route('admin.worker.index'));
});

Breadcrumbs::register('admin.worker.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.worker.index');
    $breadcrumbs->push('Ajouter Supérviseur', route('admin.worker.create'));
});

Breadcrumbs::register('admin.worker.edit', function ($breadcrumbs, $worker) {
    $breadcrumbs->parent('admin.worker.index');
    $breadcrumbs->push('Editer Supérviseur : ' . $worker->code, route('admin.worker.edit', $worker));
});
