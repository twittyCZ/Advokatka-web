<?php
global $tplData;

require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("",$tplData['title']);
?>
<script src="view/objednavky.js" async></script>
<body>
<?php
if (!$tplData['userLogged']) {
	$tplHeaders->createNav($tplData['pravo']);
} else {
	$tplHeaders->createNav($tplData['pravo'], "odhlaseni");
} ?>

<div class="container">
	<h1>Moje údaje</h1>
	<div class="row pl-3">
		<h3>Email: </h3> <p class="pt-2 pl-5"><b><?php echo $tplData['email']?> </b></p>
	</div>
	<div class="row pl-3">
		<h3>Jméno: </h3> <p class="pt-2 pl-4">&nbsp;&nbsp;<b><?php echo $tplData['username']?> </b></p>
	</div>
	<br>
	<br>
</div>



<h2 class="pl-2">Vaše dosavadní objednávky</h2>
<table class="table table-hover ml-2" style="width: 98%">
	<thead>
	<tr>
		<th></th>
		<th>ID objednávky</th>
		<th>Username</th>
		<th>Objednávka zadána</th>
		<th>Schváleno</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$objednavky = $tplData['exactUserObj'];
	foreach ($objednavky as $objednavka){?>
		<tr>
			<td><b>+</b></td>
			<td><?php echo $objednavka["id_objednavky"];?></td>
			<td><?php echo $objednavka["USER_id_user"];?></td>
			<td><?php echo $objednavka["datum_vytvoreni"];?></td>
			<td><?php echo $objednavka["schvalena"];?></td>
		</tr>

		<tr class="hide-n-seek">
			<td colspan="8">
				<table class="ml-5">
					<tr>
						<th>Název</th>
						<th>Počet</th>
					</tr>

					<?php
					foreach ($tplData["sluzby".$objednavka["id_objednavky"]] as $exactObjednavkaSluzby){ ?>
						<tr>
							<td><?php echo $exactObjednavkaSluzby['SLUZBY_id_sluzba'];?> </td> <td> <?php echo $exactObjednavkaSluzby['pocet'];?></td>
						</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	<?php } ?>

	</tbody>
</table>

</body>
