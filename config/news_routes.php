<?php 
    $route[FUEL_ROUTE.'new/news'] = 'news';

    $route[FUEL_ROUTE.'new/news/add_group'] = 'news/add_group';
    $route[FUEL_ROUTE.'new/news/add_images'] = 'news/add_images';
    $route[FUEL_ROUTE.'new/news/insert_images'] = 'news/insert_images';
    $route[FUEL_ROUTE.'new/news/update_image/(:num)'] = 'news/update_image/$1';
    $route[FUEL_ROUTE.'new/news/update_image/insert_images'] = 'news/insert_images';
    
    $route[FUEL_ROUTE.'new/news/insert_group'] = 'news/insert_group';
    $route[FUEL_ROUTE.'new/insert_group'] = 'news/insert_group';

    $route[FUEL_ROUTE.'new/update_status'] = 'news/update_status';

    $route[FUEL_ROUTE.'new/news/deleteNews/(:num)'] = 'news/deleteNews/$1';
    $route[FUEL_ROUTE.'new/news/deleteGroup/(:num)'] = 'news/deleteGroup/$1';
    $route[FUEL_ROUTE.'new/news/deleteNews/delete_process'] = 'news/delete_process';
    $route[FUEL_ROUTE.'new/news/deleteGroup/delete_process'] = 'news/delete_process';

    $route[FUEL_ROUTE.'new/news/delete'] = 'news/delete';
    $route[FUEL_ROUTE.'new/news/delete/delete_process'] = 'news/delete_process';
    $route[FUEL_ROUTE.'new/news/delete/(:any)'] = 'news/delete/$1';
    $route[FUEL_ROUTE.'new/news/multi_delete'] = 'news/multi_delete';
