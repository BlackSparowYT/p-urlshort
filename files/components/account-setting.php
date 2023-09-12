<?php 

    require_once("../files/config.php");
    //ini_set('display_errors', 0);

    // Start a session
    session_start();

    if (
        $page['name'] != "login" &&
        $page['name'] != "register" &&
        $page['name'] != "forgot_pass"
    ) {
        // Every time on load check if the Session data is still up to date (looking for the disabled, admin and verify status)
        $id = $_SESSION['id'];
        $email = $_SESSION['email'];

        $stmt = $link->prepare("SELECT id, admin, disabled, verify FROM `users` WHERE email = ? AND id = ?");
        $stmt->bind_param("si", $email, $id);
        $stmt->execute();
        $is_run = $stmt->get_result();
        $row = mysqli_fetch_assoc($is_run);

        $admin = $row['admin'];
        if ($admin == 1) {
            $_SESSION["admin"] = true;
        } else {
            $_SESSION["admin"] = false;
        }
    
        $disabled = $row['disabled'];
        if ($disabled == 1) {
            $_SESSION["disabled"] = true;
        } else {
            $_SESSION["disabled"] = false;
        }
    
        $verify = $row['verify'];
        if ($verify == 1) {
            $_SESSION["verify"] = true;
        } else {
            $_SESSION["verify"] = false;
        }
    }


    if (
        $page['name'] != "login" &&
        $page['name'] != "verify" &&
        $page['name'] != "disabled" &&
        $page['name'] != "register" &&
        $page['name'] != "forgot_pass"
    ) {
        if (isset($_SESSION['loggedin'])) {
            $loggedin = true;
            if ($_SESSION['verify'] == true) {
                header("Location: verify.php");
            } else if ($_SESSION['disabled'] == true) {
                header("Location: disabled.php");
            }
        } else {
            header("Location: login.php");
        }
    } else if ($page['name'] == "login") {
        if (isset($_SESSION['loggedin'])) {
            $loggedin = true;
            if ($_SESSION['verify'] == true) {
                header("Location: verify.php");
            } else if ($_SESSION['disabled'] == true) {
                header("Location: disabled.php");
            } else {
                header("Location: dashboard.php");
            }
        } else {
            $loggedin = false;
        }
    } else if ($page['name'] == "register") {
        if (isset($_SESSION['loggedin'])) {
            $loggedin = true;
            if ($_SESSION['verify'] == true) {
                header("Location: verify.php");
            } else if ($_SESSION['disabled'] == true) {
                header("Location: disabled.php");
            } else {
                header("Location: dashboard.php");
            }
        } else {
            $loggedin = false;
        }
    } else if ($page['name'] == "verify") {
        if (isset($_SESSION['loggedin'])) {
            $loggedin = true;
            if ($_SESSION['disabled'] == true) {
                header("Location: disabled.php");
            } else if ($_SESSION['disabled'] == false && $_SESSION['verify'] == false) {
                header("Location: dashboard.php");
            }
        } else {
            header("Location: login.php");
            exit;
        }
    } else if ($page['name'] == "disabled") {
        if (isset($_SESSION['loggedin'])) {
            $loggedin = true;
            if ($_SESSION['verify'] == true) {
                header("Location: verify.php");
            } else if ($_SESSION['disabled'] == false && $_SESSION['verify'] == false) {
                header("Location: dashboard.php");
            }
        } else {
            header("Location: login.php");
            exit;
        }
    } else if ($page['name'] == "forgot_pass") {
        if (isset($_SESSION['loggedin'])) {
            $loggedin = true;
            if ($_SESSION['verify'] == true) {
                header("Location: verify.php");
            } else if ($_SESSION['disabled'] == true) {
                header("Location: disabled.php");
            } else {
                header("Location: dashboard.php");
            }
        } else {
            $loggedin = false;
        }
    }

?>