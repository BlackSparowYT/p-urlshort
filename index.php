<?php

    session_start();

    if (isset($_COOKIE["filledin"]) && $_COOKIE["filledin"] != "true") {
        setcookie("filledin", "false", time() + 2 * 60 * 60 * 24);
    } else if (!isset($_COOKIE["filledin"])) {
        setcookie("filledin", "false", time() + 2 * 60 * 60 * 24);
    }

    $page['name'] = "home";
    $page['categorie'] = "default";
    $page['path_lvl'] = 1;
    include("./files/config.php");

    if (isset($_SESSION['loggedin'])) {
        $user_id = $_SESSION['id'];
    } else {
        $user_id = "0";
    }
    
    $shortcode = bin2hex(random_bytes(4));
    $copyurl = $site['url'].'redirect.php?id='.$shortcode;




    if (isset($_POST['submit'])) {
        $url = $_POST['url'];
        if ($url != "" && preg_match('#^(https?://|www\.)#i', $url) === 1) {
            $stmt = $link->prepare("SELECT COUNT(*) FROM redirects WHERE shortcode = ?");
            $stmt->bind_param("s", $shortcode);
            $stmt->execute();
            $data = $stmt->get_result();
            $results = mysqli_fetch_assoc($data);

            if ($results['COUNT(*)'] == 0) {
                unset($results);

                if (isset($_POST['logips'])) {
                    $log_ips = 1;
                } else {
                    $log_ips = 0;
                }

                $stmt = $link->prepare("INSERT INTO `redirects`(`user_id`, `shortcode`, `url`, `log_ips`) VALUES (?,?,?,?)");
                $stmt->bind_param("issi", $user_id, $shortcode, $url, $log_ips);
                $stmt->execute();
                $succes = $copyurl;

                setcookie("filledin", "true", time() + 2 * 60 * 60 * 24);
                setcookie("last_value", $succes, time() + 2 * 60 * 60 * 24);
                header('Location: index.php');
                exit;
            } else {
                $error = 'Short code already exists!';
            }
        } else {
            $error = 'Invalid url!';
        }
    }
?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <?php echo '<title>' . ucfirst($page['name']) . ' | ' . $site['name'] . '</title>' ?>
        <?php echo '<link rel="stylesheet" href="' . $path . 'files/styles/styles.css">' ?>
        <?php echo '<link rel="icon" type="image/x-icon" href="' . $path . 'files/logos/favicon.png">' ?>
    </head>

    <body>

        <main>
            <section class="hero">
                <h1>URL Shortener</h1>

                <?php 

                if (isset($_SESSION['loggedin'])) {
                    echo '
                    <div class="js-dropdown dropdown">
                        <a class="js-dropbtn dropbtn">
                            <div class="user-profile">
                                <img src="' . $path . 'files/icons/unknown-user.png" alt="User Profile">
                            </div>
                        </a>
                        <div class="dropdown-content js-dropContent" data-state="closed">
                            <a href="' . $path . 'account/">Dashboard</a>
                            <a href="' . $path . 'account/redirects.php">Your redirects</a>
                        </div>
                    </div>';
                } else {
                    
                    echo '
                    <div class="js-dropdown dropdown">
                        <a class="dropbtn" href="'.$path.'account/">
                            <div class="user-profile">
                                <img src="' . $path . 'files/icons/unknown-user.png" alt="User Profile">
                            </div>
                        </a>
                    </div>';
                }

                ?>
            </section>

            <?php script('dropdown.js') ?>

            <section class="container">
                <form method="POST">
                    <h2>Input a URL to shorten</h2>
                    <input type="text" name="url" placeholder="https://domain.com/" required autofocus>
                    <?php

                        if (isset($_SESSION['loggedin'])) {

                            echo '
                            <div class="toggle">
                                <label class="switch">
                                    <input type="checkbox" name="logips" checked>
                                    <span class="slider round"></span>
                                </label>
                                <h4>Log ips</h4>
                            </div>';
                        }

                    ?>
                    <div class="buttons">
                        <input class="button" type="submit" name="submit">
                        <?php

                            if ($_COOKIE['filledin'] == "true" && isset($_COOKIE['last_value'])) {
                                echo '<button class="button" type="button" id="copyButton" data-copy="'.$_COOKIE['last_value'].'">Copy Last Redirect</button>';
                            }

                            if ($_COOKIE['filledin'] == "true") {
                                echo '<script>
                                    const copyButton = document.getElementById("copyButton");
                                    copyButton.addEventListener("click", function() {
                                        const textToCopy = copyButton.getAttribute("data-copy");
                                        const textArea = document.createElement("textarea");
                                        textArea.value = textToCopy;
                                        document.body.appendChild(textArea);
                                        textArea.select();
                                        document.execCommand("copy");
                                        document.body.removeChild(textArea);
                                        alert("Link copied to clipboard: " + textToCopy);
                                    });
                                </script>';
                            }
                        ?>
                    </div>
                    <?php
                        if(isset($error)) {
                            echo '<h3 class="error error--active">'.$error.'</h3>';
                        } else {
                            echo '<h3 class="error"></h3>';
                        }
                    ?>
                </form>
            </section>
        </main>
    </body>
</html>
