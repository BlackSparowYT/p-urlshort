<style>
    .modal {
        transition: all 1s;

        background-color: var(--secondary);

        margin-top: 10vh;
        margin-left: 10%;
        height: 80vh;
        width: 80%;
        padding: 10px;
        border-radius: 10px;
        z-index: 10;
    }

    .modal-content {
        width: 100%;
        height: 90%;

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .modal .modal-content > div {
        transition: all 1s; 
        height: 150px;
        padding: 10px;
        border-radius: 10px;
        z-index: 10;
    }

    .modal #close-btn {
        font-size: xx-large;
    }

    .modal .info {
        width: fit-content;
        min-width: 350px;
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .modal .info .text {
        text-align: left;
        margin-left: 20px;

        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .modal .info .text h4 {
        margin-top: 5px;
        width: 100%;
        text-align: left;
    }

    .modal .info .text p {
        margin-top: 5px;
        width: 100%;
        text-align: left;
    }

    .modal .info img {
        height: 150px;
        width: 150px;
    }

    

    .modal .actions {
        display: flex;
        justify-content: space-around;
        flex-direction: row;
        flex-wrap: wrap;
        width: 500px;
    }

    .modal .actions a {
        padding: 10px;
        margin: 10px;
        background-color: var(--primary);
        border-radius: 10px;
        height: min-content;
        width: 200px;
        transition: .3s all;
        text-align: center;
        outline: 0;
        border: 0;
    }

    .modal .actions a:hover {
        background-color: var(--primary-hover);
        transition: .3s all;
    }
</style>

<?php

    $username = $_SESSION['name'];
    $email = $_SESSION['email'];
    if ($_SESSION['verify'] == false) {
        $is_verified = "Ja";
    } else {
        $is_verified = "Nee";
    }
    if ($_SESSION['disabled'] == false) {
        $is_blocked = "Nee";
    } else {
        $is_blocked = "Ja";
    }

?>

<dialog data-modal class="modal">
    <a id="close-btn" data-close-modal>&times;</a>
    <div class="modal-content">
        <div class="info">
            <img src="../files/images/default_user.png">
            <div class="text">
                <?php
                    echo '
                        <h4>'.$username.'</h4>
                        <h4>'.$email.'</h4>
                        <p>Geverifieerd: '.$is_verified.'</p>
                        <p>Geblockeerd: '.$is_blocked.'</p>
                    ';
                ?>
            </div>
            
        </div>
        <div class="actions">
            <!--<a href="reset-pfp.php">Verander Profiel Foto</a>-->
            <a href="reset-pass.php">Verander Wachtwoord</a>
            <a href="reset-email.php">Verander Email</a>
            <a href="reset-name.php">Verander Naam</a>
        </div>
    </div>
    
</dialog>

<script>
    const openButton = document.querySelector("[data-open-modal]")
    const openButton2 = document.querySelector("[data-open2-modal]")
    const closeButton = document.querySelector("[data-close-modal]")
    const modal = document.querySelector("[data-modal]")

    openButton.addEventListener("click", () => {
        modal.showModal()
    })

    openButton2.addEventListener("click", () => {
        modal.showModal()
    })


    closeButton.addEventListener("click", () => {
        modal.close()
    })
</script>
