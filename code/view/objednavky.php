<?php
global $tplData;

require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("Styles/signin.css",$tplData['title']);
?>
<script src="view/objednavky.js" async></script>
<body>
<?php
if (!$tplData['userLogged']) {
    $tplHeaders->createNav($tplData['pravo']);
} else {
    $tplHeaders->createNav($tplData['pravo'],"odhlaseni");
}
?>
<form method="post">
<table class="table table-hover">
    <thead>
    <tr>
        <th></th>
        <th>ID objednávky</th>
        <th>Username</th>
        <th>Služba objednána</th>
        <th>Schváleno</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $objednavky = $tplData['objednavky'];
    foreach ($objednavky as $objednavka){?>
        <tr>
            <td><b>+</b></td>
            <td><?php echo $objednavka["id_objednavky"];?></td>
            <td><?php echo $objednavka["USER_id_user"];?></td>
            <td><?php echo $objednavka["datum_vytvoreni"];?></td>
            <td><?php echo $objednavka["schvalena"];?></td>
            <td><button class="btn btn-primary" type="submit" value="<?php echo $objednavka["id_objednavky"];?>" name="Schvalit"
                        id="<?php echo $objednavka["id_objednavky"];?>">Schval</button></td>
        </tr>

        <tr class="hide-n-seek">
            <td colspan="8">
                <table>
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
</form>

</body>
