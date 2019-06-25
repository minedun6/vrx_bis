<?php

Breadcrumbs::register('admin.customer.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Customer', route('admin.customer.index'));
});

Breadcrumbs::register('admin.customer.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.customer.index');
    $breadcrumbs->push('Create Customer', route('admin.customer.create'));
});
