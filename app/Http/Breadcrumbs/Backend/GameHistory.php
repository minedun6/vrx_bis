<?php

Breadcrumbs::register('admin.gaming.history', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Historique des Jeux Lancés', route('admin.worker.index'));
});