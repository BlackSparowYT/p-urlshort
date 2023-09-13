<?php

    $page['name'] = "redirects";
    $page['cat'] = "account";
    $page['path_lvl'] = 2;
    require_once("../files/components/account-setting.php");

    // Get the username from the session
    $username = $_SESSION['name'];

?>

<!DOCTYPE html>
<html lang="en">
    
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

        <style>
            
        </style>
    </head>

    <body>

        <main class="account-page admin-page">

            <div class="hero">
                <div class="hero-text">
                    <h1 class="t1">Redirects</h1>
                </div>
            </div>
            <div class="admin-content container">
                <div class="table-content">
                    <?php
                        require_once('../files/config.php');

                        $stmt = $link->prepare("SELECT * FROM `redirects` WHERE redirects.user_id = ?");
                        $stmt->bind_param("i", $_SESSION['id']);

                        echo "<div class='table-div'>";
                            echo "
                                <div class='table-nav'>
                                    <h2>Your Redirects:</h2>
                                    <a href='dashboard.php'id='btn-back'>Back</a>
                                </div>";
                            echo "<div class='admin-table'>";
                                echo "<table>";
                                    echo '<tr>';
                                        echo '<th><p>ID</p></th>';
                                        echo '<th><p>Shortcode</p></th>';
                                        echo '<th><p>Redirect URL</p></th>';
                                        echo '<th><p>Redirected Count</p></th>';
                                        echo '<th><p>Log IPs</p></th>';
                                        echo '<th><p>Redirected IPs</p></th>';
                                    echo '</tr>';

                        
    
    
                            if ($stmt->execute()) {
                                $is_run = $stmt->get_result();
                                while ($result = mysqli_fetch_assoc($is_run)) {

                                    $ips = array();

                                    if ($result['log_ips'] == 1) {
                                        $result['log_ips'] = "yes";
                                    } else {
                                        $result['log_ips'] = "no";
                                    }

                                    if ($result['redirected_ips'] !== NULL) {
                                        $exploded_ips = explode(';',$result['redirected_ips'], 4);
                                        for ($i = 0; $i < count($exploded_ips) -1; $i++) {
                                            $ips[$i] = explode(':',$exploded_ips[$i]);
                                        }
                                    }

                                    echo '<tr>';
                                        echo '<td><p>' . $result['id'] . '</p></td>';
                                        echo '
                                            <td class="shortcode">
                                                <p>'; 
                                                echo $result['shortcode'];
                                            echo '</p>
                                                <div class="js-copybtn copybtn btn">
                                                    <a class="js-btn" data-link="'.$site['url'].'/redirect.php?id='.$result['shortcode'].'"><img src="'.$path.'files/icons/clipboard.svg"></a>
                                                </div>
                                                <div class="linkbtn btn">
                                                    <a target="_blank" href="'.$site['url'].'/redirect.php?id='.$result['shortcode'].'"><img src="'.$path.'files/icons/link.svg"></a>
                                                </div>';
                                        echo '</td>';
                                        echo '<td><p>' . $result['url'] . '</p></td>';
                                        echo '<td><p>' . $result['total_redirects'] . '</p></td>';
                                        echo '<td><p>' . $result['log_ips'] . '</p></td>';
                                        echo '<td><p>'; foreach ($ips as $ip) { echo $ip[0].'; '; } echo '</p></td>';
                                        echo '<td><p>';
                                            echo '<a href="redirects-edit.php?mode=view&id=' . $result['id'] . '">View</a>';
                                        echo '</p></td>';
                                        echo '</tr>';
                                    }
                            } else {
                                echo "Error in execution!";
                            }

                                echo "</table>";
                            echo "</div>";
                        echo "</div>";
                    ?>
                </div>
            </div>
            <script>
                // Get all elements with the class "js-btn"
                const buttons = document.querySelectorAll('.js-btn');

                // Add a click event listener to each button
                buttons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        // Get the link from the data-link attribute of the clicked button
                        const link = this.getAttribute('data-link');

                        // Create a temporary textarea element to copy the link to the clipboard
                        const textarea = document.createElement('textarea');
                        textarea.value = link;
                        document.body.appendChild(textarea);

                        // Select and copy the link to the clipboard
                        textarea.select();
                        document.execCommand('copy');

                        // Remove the temporary textarea
                        document.body.removeChild(textarea);

                        // Provide feedback to the user
                        alert('Link copied to clipboard: ' + link);
                    });
                });
            </script>
        </main>
    </body>

</html>