<?php
global $tplData;

require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("", $tplData['title']);
?>
<script src="view/cart.js" async></script>
<body>
<?php
if (!$tplData['userLogged']) {
	$tplHeaders->createNav($tplData['pravo']);
} else {
	$tplHeaders->createNav($tplData['pravo'], "odhlaseni");
}
?>



<div class="container">
	<div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="../image/cash-coin.svg" alt="obrázek peněz"
             width="72" height="57">

		<?php
		if (isset($_POST['rezervace'])) {
			if ($tplData['povedloSe']) {
				?>
				<script type="text/javascript">
                    Swal.fire({
                        icon: 'success',
                        title: '<?php echo $tplData['uspech'] ?>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: `OK`,
                        customClass: {
                            confirmButton: 'order-1',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace("index.php?page=objednavka");
                        }
                    });
				</script>
			<?php
			} else {
			?>
				<script type="text/javascript">
                    Swal.fire({
                        icon: 'error',
                        title: '<?php echo $tplData['uspech'] ?>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: `OK`,
                        customClass: {
                            confirmButton: 'order-1',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace("index.php?page=objednavka");
                        }
                    });
				</script>
				<?php
			}
		}
		?>

		<h2>Objednávka</h2>
		<p class="lead" ><strong>Vložte do košíku vše, co potřebujete a naši zaměstnanci se Vám budou věnovat.</p>
	</div>


	<form class="needs-validation" method="post">
		<div class="row">

			<div class="col-md-4 order-md-2">
				<h4 class="d-flex justify-content-between align-items-center mb-3">
					<span class="text-muted">Váš košík</span>
					<span class="badge badge-secondary badge-pill">0</span>
				</h4>


				<ul class="list-group mb-3">
				</ul>
				<div class="list-group-item d-flex justify-content-between">
					<span>Celková cena:</span>
					<strong class="cart-total">0</strong>
				</div>
                <hr>
                <div class="row justify-content-center">
                    <button class="btn btn-lg btn-primary font-weight-bold" type="submit" name="rezervace"
                            value="rezervace">Rezervuj ihned
                    </button>
                </div>
			</div>


			<div class="col-md-8 order-md-1">
				<br>

				<?php
				$sluzby = $tplData['sluzby'];
				?>
				<script type="text/javascript">

                    var sluzby = <?php echo json_encode($sluzby); ?>;

				</script>
				<?php
				for ($c = 0; $c < count($sluzby); $c++) {
					?>
					<div class="form-group row">
						<label class="col-form-label col-sm-8 col-lg-7" for="<?php echo $sluzby[$c]['typ_sluzby']; ?>">
							<b><span class="cart-item-name-l"><?php echo $sluzby[$c]['typ_sluzby']; ?></span> -> <span
										class="cart-item-price-l"><?php echo $sluzby[$c]['cena'] . " KČ"; ?></span></b></label>
						<input type="button" class="btn btn-primary col-md-2 shop-add-button-l"
						       name="<?php echo $sluzby[$c]['typ_sluzby']; ?>" id="<?php echo $sluzby[$c]['typ_sluzby']; ?>"
						       value="Přidej">
						<span class=""></span>
					</div>
				<?php } ?>
				<br>
				<hr class="mb-4">
				</div>
			</div>
		</div>
	</form>
	<footer class="my-5 pt-5 text-muted text-center text-small">
		<p class="mb-1">&copy; 2022 Můj právník</p>
	</footer>
</div>

</body>