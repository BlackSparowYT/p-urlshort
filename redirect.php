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

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];
    $mode = 'redirect';
} else if (!isset($_GET['id']) || $_GET['id'] == '') {
    $error = "No ID has been provided!";
    $mode = "stay";
}

if ($mode == 'redirect') {
    $stmt = $link->prepare("SELECT * FROM redirects WHERE shortcode = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $data = $stmt->get_result();

    if ($data->num_rows == 1) {

        $results = mysqli_fetch_assoc($data);
        $url = $results['url'];
        
        if ($results['log_ips'] == 1) {

            $total_redirects = $results['total_redirects'] + 1;

            $ip = '0.0.0.0';
            $ip = $_SERVER['REMOTE_ADDR'];
            $ip = '81.173.58.132';
            $clientDetails = json_decode(file_get_contents("http://ipinfo.io/$ip/json"), true);
            $user_ip =  $results['redirected_ips'].$clientDetails['ip'].':'.$clientDetails['country'].','.$clientDetails['city'].';';

            $stmt = $link->prepare("UPDATE `redirects` SET `total_redirects`=? , `redirected_ips`=? WHERE shortcode = ?");
            $stmt->bind_param("iss", $total_redirects, $user_ip, $id);
            $stmt->execute();
        }

        echo '<script>window.location.href = "'.$url.'";</script>';
    
    } else {
        $error = 'Invalid ID!';
    }
}



if (isset($error)) {
    echo '<h1 style="color: darkred;">'.$error.'</h1>';
} else {
    echo '<h1>You are being redirected!</h1>';
}

?>