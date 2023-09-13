<?php

    $page['name'] = "redirects edit";
    $page['cat'] = "account";
    $page['path_lvl'] = 2;
    require_once("../files/components/account-setting.php");

    // Get the username from the session
    $username = $_SESSION['name'];

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    if(isset($_GET['mode'])) {
        $mode = $_GET['mode'];
    }


    if(isset($_POST['save'])) {

        $url = $_POST['url'];
        if ($_POST['log_ips'] == "0") {
            $log_ips = 0;
        } else {
            $log_ips = 1;
        }

        $stmt = $link->prepare("UPDATE redirects SET `url` = ?, `log_ips` = ? WHERE id = ?");
        $stmt->bind_param("sii", $url, $log_ips, $id);
        $stmt->execute();
        
        header("Location: ?mode=view&id=".$id."");
        exit;
    }

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

        <main class="redirect-page user-page">

            <div class="hero">
                <div class="hero-text">
                    <h1 class="t1">Redirects</h1>
                </div>
            </div>
            <div class="admin-content container">
                <form class="table-content" method="POST">
                    <?php
                        require_once('../files/config.php');

                        $stmt = $link->prepare("SELECT * FROM `redirects` WHERE user_id = ? AND id = ?");
                        $stmt->bind_param("ii", $_SESSION['id'], $id);
                        $stmt->execute();
                        $is_run = $stmt->get_result();
                        $result = mysqli_fetch_assoc($is_run);

                        echo "<div class='table-div'>";
                            echo "
                                <div class='table-nav'>
                                    <h2>Redirect ".$result["id"].":</h2>
                                    <div>";
                                        if($mode == 'edit') { echo"<input type='submit' value='Save' name='save'>"; }
                                        if($mode == 'view') { echo"<a href='?mode=edit&id=".$result['id']."' id='btn-edit'>Edit</a>"; }
                                        echo "<a href='redirects.php' id='btn-back'>Back</a>
                                    </div>
                                </div>";
                            echo "<div class='admin-table'>";
                                echo "<table>";
                                    echo '<tr>';
                                        echo '<th><p>Name</p></th>';
                                        echo '<th><p>Value</p></th>';
                                    echo '</tr>';

                                    $ips = array();

                                    if ($result['log_ips'] == 1) {
                                        $result['log_ips'] = "yes";
                                    } else {
                                        $result['log_ips'] = "no";
                                    }

                                    if ($result['redirected_ips'] !== NULL) {
                                        $exploded_ips = explode(';',$result['redirected_ips']);
                                        for ($i = 0; $i < count($exploded_ips) -1; $i++) {
                                            $ips[$i] = explode(':',$exploded_ips[$i]);
                                        }
                                    }

                                    echo '<tr>';
                                        echo '<td><p>ID</p></td>';
                                        echo '<td><p>' . $result['id'] . '</p></td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '<td><p>Shortcode</p></td>';
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
                                    echo '</tr>';
                                    echo '<tr>';
                                        echo '<td><p>URL</p></td>';
                                        
                                        if($mode == 'edit') { echo'<td><input type="text" name="url" value="'.$result['url'].'"></p></td>'; }
                                        if($mode == 'view') { echo'<td><p>'.$result['url'].'</p></td>'; }
                                    echo '</tr>';
                                    echo '<tr>';
                                        echo '<td><p>Redirect Count</p></td>';
                                        echo '<td><p>' . $result['total_redirects'] . '</p></td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                        echo '<td><p>Log IPs?</p></td>';
                                        if($mode == 'edit') {
                                            echo'
                                                <td>
                                                    <select name="log_ips" >
                                                        <option value="1">yes</option>
                                                        <option value="0">no</option>
                                                    </select>
                                                </td>'; }
                                        if($mode == 'view') { echo'<td><p>' . $result['log_ips'] . '</p></td>'; }
                                    echo '</tr>';
                                    echo '<tr>';
                                        echo '<td><p>IPs logged</p></td>';
                                        echo '<td><p>'; foreach ($ips as $ip) { echo $ip[0].' : '.$ip[1].';<br>'; } echo '</p></td>';
                                    echo '</tr>';
                                echo "</table>";
                            echo "</div>";
                        echo "</div>";
                    ?>
                </form>
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