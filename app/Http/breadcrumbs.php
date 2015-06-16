<?php

// Home
Breadcrumbs::register('cms.index', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('cms.index'));
});

// Home > Media
Breadcrumbs::register('cms.media.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Media', route('cms.media.index'));
});

// Home > Media > Add New
Breadcrumbs::register('cms.media.create', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.media.index');
    $breadcrumbs->push('Add New', route('cms.media.create'));
});

// Home > Media > Edit
Breadcrumbs::register('cms.media.show', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.media.index');
    $breadcrumbs->push('Edit', route('cms.media.show'));
});

// Home > News 

Breadcrumbs::register('cms.news.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('News', route('cms.news.index'));
});

// Home > News > Add New

Breadcrumbs::register('cms.news.create', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.news.index');
    $breadcrumbs->push('Add New', route('cms.news.create'));
});

// Home > News > Edit
Breadcrumbs::register('cms.news.show', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.news.index');
    $breadcrumbs->push('Edit', route('cms.news.show'));
});


//Home > Banner
Breadcrumbs::register('cms.banners.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Banner', route('cms.banners.index'));
});

//Home > Banner > Add New
Breadcrumbs::register('cms.Banners.add', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Add New', route('cms.Banners.add'));
});

//Home > Banner > Edit
Breadcrumbs::register('cms.banners.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.banners.index');
    $breadcrumbs->push('Edit', route('cms.banners.edit'));
});

//Home > Pages
Breadcrumbs::register('cms.pages.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Pages', route('cms.pages.index'));
});

//Home > Pages > Add New
Breadcrumbs::register('cms.pages.addPage', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.pages.index');
    $breadcrumbs->push('Add New', route('cms.pages.addPage'));
});

//Home > Editor
Breadcrumbs::register('cms.editor.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Editor', route('cms.editor.index'));
});


// Home > Menu
Breadcrumbs::register('cms.menu.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Menu', route('cms.menu.index'));
});

//Home > Modules 
Breadcrumbs::register('modules.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Modules', route('modules.index'));
});

//Home > Users 
Breadcrumbs::register('cms.user.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Users', route('cms.user.index'));
});

//Home > Users > Add Users
Breadcrumbs::register('cms.user.create', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.user.index');
    $breadcrumbs->push('Add', route('cms.user.create'));
});

//Home > Users > Edit
Breadcrumbs::register('cms.user.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.user.index');
    $breadcrumbs->push('Edit', route('cms.user.create'));
});

//Home > Users > User Access
Breadcrumbs::register('cms.role.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.user.index');
    $breadcrumbs->push('User Access', route('cms.role.index'));
});

Breadcrumbs::register('cms.role.create', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.role.index');
    $breadcrumbs->push('Add', route('cms.role.create'));
});

//Home > Users > User Access > Modify
Breadcrumbs::register('cms.role.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.role.index');
    $breadcrumbs->push('Modify', route('cms.role.edit'));
});

// Home > General Settings
Breadcrumbs::register('cms.general_settings.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('General Settings', route('cms.general_settings.index'));
});



Breadcrumbs::register('cms.user.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.user.index');
    $breadcrumbs->push('Edit', route('cms.user.create'));
});

//Home > Users > User Access
Breadcrumbs::register('cms.role.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.user.index');
    $breadcrumbs->push('User Access', route('cms.role.index'));
});

// Home > General Settings
Breadcrumbs::register('cms.general_settings.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('General Settings', route('cms.general_settings.index'));
});


//Home > Banner
Breadcrumbs::register('cms.banners.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Banner', route('cms.banners.index'));
});

//Home > Banner > Add New
Breadcrumbs::register('cms.Banners.add', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Add New', route('cms.Banners.add'));
});

//Home > Pages
Breadcrumbs::register('cms.pages.index', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.index');
    $breadcrumbs->push('Pages', route('cms.pages.index'));
});

//Home > Pages > Add New
Breadcrumbs::register('cms.pages.addPage', function($breadcrumbs)
{
    $breadcrumbs->parent('cms.pages.index');
    $breadcrumbs->push('Add New', route('cms.pages.addPage'));
});

