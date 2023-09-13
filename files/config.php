<?php


    //ini_set('display_errors', 0);

    $path_lvl[1] = './';
    $path_lvl[2] = '../';
    $path_lvl[3] = '../../';

    if ($page['path_lvl'] == 1) {
        $path = $path_lvl[1];
    } else if ($page['path_lvl'] == 2) {
        $path = $path_lvl[2];
    } else if ($page['path_lvl'] == 3) {
        $path = $path_lvl[3];
    }

    // Set some settings
    $site['url'] = 'https://urlshort.design-atlas.nl/';
    $site['name'] = 'URL Shorter';
    $site['description'] = 'Short any url without hassel!';

    // Get the credentials for all the connections
    include($path.'files/credentials.php');

    // Get some preset functions
    include($path.'files/functions.php');
    
    // Link the DB
    $link = new mysqli($db_host, $db_user, $db_password, $db_name);
    if (!$link){
        echo "<p style='color: red;'>Connection Unsuccessful!!!</p>";
    }

?>