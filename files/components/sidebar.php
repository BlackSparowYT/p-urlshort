<style>
    .sidebar {
        height: calc(100vh);
        width: fit-content;
        max-width: 500px;

        position: fixed;
        top: 0px;
        left: 0;

        display: flex;
        flex-direction: row;
        z-index: 100;
    }

    .sidebar .sidebar-icons {
        width: 60px;
        height: calc(100% - 100px);
        padding-top: 120px;

        background-color: var(--secondary);
        
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;

        border-top-right-radius: 10px;

    }

    .sidebar .sidebar-bottom {
        width: 60px;
        height: fit-content;
        margin-top: auto;
        margin-bottom: 20px;

        background-color: var(--secondary);
        
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
    }

    .sidebar #SB-text .sidebar-bottom {
        width: 100%;
    }

    .sidebar #SB-text {
        display: none;
        height: calc(100% - 100px);
        padding: 20px 10px 0 0;
        margin-top: 100px;
        background-color: var(--secondary);

        text-align: left;
        flex-direction: column;

        transition: all .3s;
    }

    .sidebar #SB-text a {
        height: 54px;
        width: 100%;
        padding-left: 10px;
        text-align: left;

        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .sidebar #SB-text hr {
        width: 100%;
    }

    .sidebar hr {
        width: 40px;
        color: var(--gray);
        outline: 0;
        border: 1px solid var(--black-trans2);
    }

    .sidebar a {
        cursor: pointer;
    }

    .sidebar a img {
        width: 40px;
        height: 40px;
        margin: 5px;
    }
    
    .modal {
        padding: 10px;
        background-color: white;
        border-radius: 10px;
        z-index: 10;
    }
</style>

<div class="sidebar">
    <div class="sidebar-icons" id="SB-icons">
        <a href="dashboard.php"><img src="../files/icons/dash-home.png"></a>
        <a href="user-orders.php"><img src="../files/icons/dash-orders.png"></a>
        <a href="user-reviews.php"><img src="../files/icons/dash-reviews.png"></a>
        <?php if ($_SESSION['admin'] == true) : ?>
            <hr>
            <a href="admin-orders.php"><img src="../files/icons/dash-orders.png"></a>
            <a href="admin-reviews.php"><img src="../files/icons/dash-reviews.png"></a>
            <a href="admin-reizen.php"><img src="../files/icons/dash-reizen.png"></a>
            <a href="admin-users.php"><img src="../files/icons/dash-users.png"></a>
        <?php endif; ?>

        <div class="sidebar-bottom">
            <hr>
            <a href="logout.php"><img src="../files/icons/dash-logout.png"></a>
            <a data-open-modal><img src="../files/icons/dash-settings.png"></a>
            <a id="menu-btn1" onclick="sidebarOpen()"><img src="../files/icons/dash-menu.png"></a>
        </div>
    </div>
    <div class="sidebar-text" id="SB-text">
        <a href="dashboard.php"><h3>Dashboard</h3></a>
        <a href="user-orders.php"><h3>Jouw Orders</h3></a>
        <a href="user-reviews.php"><h3>Jouw Recensies</h3></a>
        <?php if ($_SESSION['admin'] == true) : ?>
            <hr>
            <a href="admin-orders.php"><h3>Alle Orders</h3></a>
            <a href="admin-reviews.php"><h3>Alle Recensies</h3></a>
            <a href="admin-reizen.php"><h3>Alle Reizen</h3></a>
            <a href="admin-users.php"><h3>Alle Gebruikers</h3></a>
        <?php endif; ?>

        <div class="sidebar-bottom">
            <hr>
            <a href="logout.php"><h3>Log uit</h3></a>
            <a data-open2-modal><h3>Settings</h3></a>
            <a id="menu-btn2" onclick="sidebarOpen()"><h3>Sluit Menu</h3></a>
        </div>
    </div>

    <script>
        function sidebarOpen() {
            document.getElementById("SB-text").style.display = "flex";
            document.getElementById("SB-text").style.minWidth = "fit-content";
            document.getElementById("SB-text").style.borderTopRightRadius = "10px";
            document.getElementById('menu-btn1').setAttribute( "onClick", "sidebarClose()" );
            document.getElementById('menu-btn2').setAttribute( "onClick", "sidebarClose()" );
        }

        function sidebarClose() {
            document.getElementById("SB-text").style.display = "none";
            document.getElementById("SB-text").style.minWidth = "0px";
            document.getElementById("SB-icons").style.borderTopRightRadius = "10px";
            document.getElementById('menu-btn1').setAttribute( "onClick", "sidebarOpen()" );
            document.getElementById('menu-btn2').setAttribute( "onClick", "sidebarOpen()" );
        }
    </script>
    
</div>

<?php include($path . "files/components/account-modal.php"); ?>
