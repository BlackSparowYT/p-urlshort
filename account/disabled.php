<?php

    $page['name'] = "disabled";
    $page['cat'] = "account";
    $page['lvl'] = 2;
    require_once("../files/components/account-setting.php");

    $email = $_SESSION['email'];

    $stmt = $link->prepare("SELECT id, is_disabled FROM `users` WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $is_run = $stmt->get_result();
    $result = mysqli_fetch_assoc($is_run);

    $is_disabled = $result['is_disabled'];

    if ($is_disabled == 0) {
        $_SESSION['disabled'] == false;
    } else {
        $_SESSION['disabled'] == true;
    }
 
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

        <title>Geblockeerd || Remote Reizen</title>
        <?php echo '<link rel="stylesheet" href="'.$path.'files/styles.css">' ?>
    </head>

    <body>

        <main class="login-page account-page">
            <div class="content">
                <?php echo '
                <a href="'.$path.'index.php">
                    <div class="image-block">
                        <img src="'.$path.'files/images/logo-blank.png"/>
                    </div>
                </a>
                '; ?>
                <div class="form">
                    <form method="post">
                        <h2>Geblockeerd</h2>
                        <div class="link">
                            <hr>
                            <h5>
                                GEBLOCKEERD ACCOUNT
                            </h5>
                            <hr>
                        </div>
                        <div>
                            <h4>Je account is geblockeerd!</h4>
                            <p>Je account is door ons system geblockeerd, neem contact met ons op voor meer informatie en om je account te deblockeren.</p>
                        </div>
                        <?php if (isset($error)) : ?>
                            <div>
                                <p class="errors" style="color: darkred;"><?php echo $error; ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="link">
                            <hr>
                            <h5>
                                <a href="logout.php">LOG UIT</a>
                            </h5>
                            <hr>
                        </div>
                    </form>
                    
                </div>
            </div>
        </main>

    </body>

</html>