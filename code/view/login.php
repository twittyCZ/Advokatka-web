<?php
global $tplData;

require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("Styles/signin.css",$tplData['title']);
?>

<body>
<?php
if (!$tplData['userLogged']) {
    $tplHeaders->createNav($tplData['pravo']);
} else {
    $tplHeaders->createNav($tplData['pravo'],"odhlaseni");
}
?>
    <form class="form-signin text-center d-flex" method="post">
        <div class="row justify-content-center align-self-center">

            <?php
            if(isset($_POST['prihlasit'])){

                if($tplData['povedloSe']){
                    ?>
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'success',
                            title: '<?php echo $tplData['login'] ?>',
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            confirmButtonText: `OK`,
                            customClass: {
                                confirmButton: 'order-1',
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.replace("index.php?page=profil");
                            }
                        });
                    </script>
                <?php
                } else {
                ?>
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'error',
                            title: '<?php echo $tplData['login'] ?>',
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            confirmButtonText: `OK`,
                            customClass: {
                                confirmButton: 'order-1',
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.replace("index.php?page=login");
                            }
                        });
                    </script>
                    <?php
                }
            }
            ?>

        <!-- Vloží obrázek -->
        <a href="index.php?page=uvod"> <img class="mb-4 obrazekLogo container" src="https://www.acerislaw.com/wp-content/uploads/2018/11/International-Investment-Law.png"
                                    alt="logo webu"></a>
        <h1 class="h3 mb-4 font-weight-normal">Přihlašte se prosím</h1>

         <label for="inputEmail" class=""></label>
         <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Zadejte emailovou adresu" required autofocus>

         <label for="inputPassword" class=""></label>
         <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Heslo" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit" name="prihlasit" value="prihlasit"><i class="fas fa-sign-in-alt 9"></i> Přihlaš se</button>
        </div>
    </form>

</body>

