<?php
include("funktionen.php");
?>

<html>

<head>
    <title>Propania</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="rpgstyle.css" />
    <link rel="stylesheet" type="text/css" href="mobilerpgstyle.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
</head>

<body>
    <div class="Hintergrund"></div>
    <div class="Content">
        <div class="Navigation">
            <div class="SpielerInfoContainer">
                <div class="Avatarbild">
                    <img class="Spielerbildrahmen" src="/Bilder/Rahmen.png" />
                    <img class="Spielerbild" src="<?php echo $newClass->SpielerLesen($connection, "spielerbildpfad", $_SESSION["Spieler"]) ?>">
                    <img id="LvLPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                    <div class="LvL">
                        <p><?php echo $newClass->SpielerLesen($connection, "lvl", $_SESSION["Spieler"]) ?></p>
                    </div>
                    <div class="Bildupload">
                        <form id="inputform" action="./funktionen.php" method="POST" enctype="multipart/form-data">
                            <!-- 3,5 mb maximal dateigröße -->
                            <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                            <label>Bild</label><br>
                            <label for="bild-hochladen" class="Angepasster-Input">Upload</label><br>
                            <input id="bild-hochladen" type="file" name="bildhochladen" onclick="PlaySound();" />
                            <input id="subbtn" class="Avatarbutton" type="image" src="/Bilder/Haken.png" onclick="PlaySound();" />
                            <button type="reset" style="border: 0; background: transparent" onclick="PlaySound();">
                                <img class="Avatarbutton" src="/Bilder/X.png" />
                            </button>
                        </form>
                    </div>
                </div>
                <div class="Ausruestung">
                    <div class="RuestungContainer">
                        <img class="Ruestungsbild" src="<?php $newClass->BildLesen($connection, "ruestungsbildpfad", "ruestung", "ruestungsid", $_SESSION["Spieler"]); ?>" width="40" height="40">
                        <img id="RuestungsPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                        <div class="ruestungswert">
                            <p><?php echo $newClass->SpielerRuestungsStatsLesen($connection, "ruestungswert", $newClass->SpielerLesen($connection, "ruestungsid", $_SESSION["Spieler"])) ?></p>
                        </div>
                        <div class="Ruestungsname"><?php $newClass->BildLesen($connection, "ruestungsname", "ruestung", "ruestungsid", $_SESSION["Spieler"]); ?></div>
                    </div>
                    <div class="WaffenCont">
                        <img class="Waffenbild" src="<?php $newClass->BildLesen($connection, "waffenbildpfad", "waffen", "waffenid", $_SESSION["Spieler"]); ?>" width="40" height="40">
                        <img id="RuestungsPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                        <div class="waffenwert">
                            <p><?php echo $newClass->SpielerWaffenStatsLesen($connection, "waffenwert", $newClass->SpielerLesen($connection, "waffenid", $_SESSION["Spieler"])) + $newClass->SpielerLesen($connection, "angriff", $_SESSION["Spieler"]) ?></p>
                        </div>
                        <div class="Waffenname"><?php $newClass->BildLesen($connection, "waffenname", "waffen", "waffenid", $_SESSION["Spieler"]); ?></div>
                    </div>
                </div>
                <div id="Nachrichten">
                    <img src="/Bilder/Schriftrolle.png">
                    <div id="Schriftrolle" onclick="PopUp();">
                        <p><?php echo $newClass->AnzahlNachrichtenLesen($connection) ?></p>
                    </div>
                </div>
                <div class="Stats">
                    <p id="spielername"><?php echo $_SESSION["Spieler"]; ?></p><br>
                    <img src="Bilder/Leben.png">
                    <label>Leben</label>
                    <p id="leben"><?php echo $newClass->SpielerLesen($connection, "leben", $_SESSION["Spieler"]) ?>&nbspvon&nbsp<?php echo $newClass->SpielerLesen($connection, "maxleben", $_SESSION["Spieler"]) ?> </p><br>
                    <img src="Bilder/XP.png">
                    <label>Erfahrung</label>
                    <p id="erfahrung"><?php echo $newClass->SpielerLesen($connection, "erfahrung", $_SESSION["Spieler"]) ?>&nbspvon&nbsp<?php $newClass->MAXErfahrung($connection, $_SESSION["Spieler"]) ?></p>
                    <div id="geldcontainer">
                        <label>Geld</label>
                        <p id="geld"><?php echo $newClass->SpielerLesen($connection, "geld", $_SESSION["Spieler"]) ?></p>
                        <img src="Bilder/Geld.png">
                    </div>
                    <div class="form">
                        <form action="/login.php" method="POST">
                            <input type="hidden" name="action" value="Ausloggen" />
                            <input type="submit" class="Auslogbutton" value="" onclick="PlaySound();" />
                        </form>
                    </div>
                </div>
                <a class="Einstellungen" href="/einstellungen.php" onclick="PlaySound();"><img src="/Bilder/Einstellungen.png"></a>
            </div>

            <div class="SpielerlisteContainer">
                <p>Spieleruebersicht</p>
                <div class="Spielerliste">
                    <p><?php $newClass->AlleSpielerLesen($connection) ?></p>
                </div>
                <div class="admin"> <?php $newClass->AdminEinblenden($connection); ?> <?php $newClass->LogEinblenden($connection); ?> </div>
            </div>
            <div class="MarktplatzContainer">
                <p class="Beschriftung">Marktplatz</p>
                <div class="Aktionsbilder">
                    <a href="/marktplatz.php" onclick="PlaySound();"><img src="Bilder/Marktplatzbutton.png" /></a>
                </div>
            </div>

            <div class="PVPKampfContainer">
                <p class="Beschriftung">PVP Kampf</p><br>
                <div class="Aktionsbilder">
                    <a href="/spielergegner.php" onclick="PlaySound();"><img src="Bilder/PVP.png" /></a>
                </div>
            </div>
            <div class="PVEKampfContainer">
                <p class="Beschriftung">PVE Kampf</p><br>
                <div class="Aktionsbilder">
                    <a href="/themen.php" onclick="PlaySound();"><img src="Bilder/PVE.png" /></a><br><br>
                </div>
            </div>
        </div>
        <div class="SzenenContainer">
            <img class="Szenenbild" src="Bilder/Szene.png">
        </div>
    </div>
    <div id="Nachrichtenfenster">
        <div class="Zurückbutton">
            <img src="Bilder/Zurückbutton.png" onclick="PopDown();" />
        </div>
        <div id="NachrichtenContainer">
            <div id="Nachricht">
                <?php $newClass->NachrichtenAnzeigen($connection); ?>
            </div>
        </div>
        <div class="NachrichtenSendeContainer">
            <label>Empfaenger : </label>
            <select id="spieler" name="empfaengerid">
                <option value="alle">Alle</option>
                <?php $newClass->SpielerSendenAnLesen($connection); ?>
            </select><br><br>
            <input id="absender" type="hidden" name="absender" value="<?php echo $_SESSION["Spieler"] ?>">
            <textarea id="nachrichtentext" name="text"></textarea>
            <img id="nachrichtsenden" src="/Bilder/HolzTextButtonSenden.png" onclick="NachrichtSenden();">
            <p style="color:red">Alle Nachrichten löschen</p>
            <img id="allenachrichtenloeschen" src="/Bilder/Mülltonne.png" onclick="AlleNachrichtLoeschen();">
        </div>
    </div>
</body>

<script>
    let nachricht = document.getElementById('Nachricht');

    function PlaySound() {
        //onclick="PlaySound();"

        var audio = new Audio('/Audio/tap.wav');
        audio.play();
    }

    function PopUp() {
        let popup
        popup = document.querySelector("#Nachrichtenfenster")
        if (popup !== null) {
            popup.style.opacity = 1;
            popup.style.transform = "translate(+0%, +0%) scale(1)";
        }
        var audio = new Audio('/Audio/tap.wav');
        audio.play();
    }

    function PopDown() {
        let popup
        popup = document.querySelector("#Nachrichtenfenster")
        if (popup !== null) {
            popup.style.opacity = 0;
            popup.style.transform = "translate(+0%, +0%) scale(0)";
        }
        var audio = new Audio('/Audio/tap.wav');
        audio.play();
        $("#Nachricht").load(location.href + "/einstellungen.php #Nachricht");
        $("#Schriftrolle").load(location.href + "/einstellungen.php #Schriftrolle");
    }

    // Nachrichten Senden
    function NachrichtSenden() {
        var audio = new Audio('/Audio/tap.wav');
        audio.play();

        let empfaengerid = document.getElementById('spieler');
        let nachrichtentext = document.getElementById('nachrichtentext');
        let absender = document.getElementById('absender');

        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + empfaengerid.value + "&nachrichtentext=" + nachrichtentext.value + "&absender=" + absender.value + "");
        nachrichtentext.value = "";
        $("#Nachricht").load(location.href + "/einstellungen.php #Nachricht");
    }

    // Nachrichtloeschen

    function NachrichtLoeschen(id) {
        var audio = new Audio('/Audio/tap.wav');
        audio.play();
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("nachrichtloeschen=true&id=" + id);
        $("#Nachricht").load(location.href + "/einstellungen.php #Nachricht");
    }

    function AlleNachrichtLoeschen() {
        var audio = new Audio('/Audio/tap.wav');
        audio.play();
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("allenachrichtenloeschen=true");
        $("#Nachricht").load(location.href + "/einstellungen.php #Nachricht");
    }
</script>

</html>