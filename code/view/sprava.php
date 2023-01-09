<?php
global $tplData;

require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("",$tplData['title']);
?>

<body>
<?php
if (!$tplData['userLogged']) {
	$tplHeaders->createNav($tplData['pravo']);
} else {
	$tplHeaders->createNav($tplData['pravo'], "odhlaseni");
}
?>

<div class="row justify-content-center" style="width: 100%">
    <?php
    if(isset($_POST['registruj']) || isset($_POST['smazUzivatele']) || isset($_POST['pridejSluzbu']) || isset($_POST['odeberSluzbu'])){
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
                        window.location.replace("index.php?page=sprava");
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
                        window.location.replace("index.php?page=sprava");
                    }
                });
            </script>
            <?php
        }
    } ?>
	<form class="text-center" method="post">
		<h2>Správa zaměstnanců</h2>
	<label for="inputEmail" class=""></label>
	<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Zadejte email">

	<label for="inputUsername" class=""></label>
	<input type="text" name="username" id="inputUsername" class="form-control" placeholder="Zadejte uživatelské jméno">

	<label for="inputPassword" class=""></label>
	<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Zadejte heslo">
	<br>
	<button class="btn btn-lg btn-primary btn-block" type="submit" name="registruj" value="registruj">Registruj</button>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="smazUzivatele" value="smazUzivatele">Smaž</button>

	<br>


	<h2>Správa služeb</h2>
	<label for="inputNazevSluzby" class=""></label>
	<input type="text" name="nazevSluzby" id="inputNazevSluzby" class="form-control" placeholder="Zadejte název služby">

	<label for="inputCenaSluzby" class=""></label>
	<input type="number" name="cenaSluzby" id="inputCenaSluzby" class="form-control" placeholder="Zadejte cenu služby">

	<br>
	<button class=" btn btn-lg btn-primary btn-block" type="submit" name="pridejSluzbu" value="pridejSluzbu">Přidej službu </button>
    <button class=" btn btn-lg btn-primary btn-block"  type="submit" name="odeberSluzbu" value="odeberSluzbu">Odeber službu</button>

	<br>

</div>
</body>
