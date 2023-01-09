<?php
global $tplData;

require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("Styles/cenik.css", $tplData['title']);
?>

<body>
<?php
if (!$tplData['userLogged']) {
	$tplHeaders->createNav($tplData['pravo']);
} else {
	$tplHeaders->createNav($tplData['pravo'], "odhlaseni");
}
?>
<div class="background">
	<div class="container">
		<br>
		<h1 class="text-center">Nabízené služby</h1>
		<br>
        <h3 class="text-center">Pro objednání služby je třeba se registrovat!</h3>
        <br>
		<table class="table  table-hover">
			<thead>
			<tr>
				<th>Úkon</th>
				<th class="text-right">Cena</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$sluzby = $tplData['sluzby'];
			foreach ($sluzby as $sluzba) {
				?>
				<tr>
					<td><?php echo $sluzba["typ_sluzby"]; ?></td>
                    <td class="text-right"><?php

                        if($sluzba["cena"] == 0) {
                            echo "Zdarma";
                            continue;
                        }
                        else echo $sluzba["cena"]; ?> Kč</td>
				</tr>
			<?php } ?>

			</tbody>
		</table>

		<br>
		<br>
	</div>
</div>
</body>
