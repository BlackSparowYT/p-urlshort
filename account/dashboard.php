<?php

    $page['name'] = "dashboard";
    $page['cat'] = "account";
    $page['path_lvl'] = 2;
    require_once("../files/components/account-setting.php");

    // Get the username from the session
    $username = $_SESSION['name'];

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sono:wght@300;600;800&display=swap" rel="stylesheet">

        <?php echo '<title>' . ucfirst($page['name']) . ' | ' . $site['name'] . '</title>' ?>
        <?php echo '<link rel="stylesheet" href="'.$path.'files/styles/styles.css">' ?>
        <?php echo '<link rel="icon" type="image/x-icon" href="' . $path . 'files/logos/favicon.png">' ?>
    </head>

    <body>
        

        <main class="dash-page account-page">
            <div class="hero">
                <div class="hero-text">
                    <h1 class="t1">Welcome, <?php echo $username; ?>!</h1>
                </div>
            </div>
            <div class="dash-content">
                <div class="flex">
                    <a id="settings" href="settings.php">Settings</a>
                    <a id="links" href="redirects.php">Your links</a>
                    <a id="create" href="home.php">Generate a link</a>
                    <a id="logout" href="logout.php">logout</a> 
                </div>
            </div>
        </main>

    </body>

</html>