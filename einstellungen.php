<?php
include("funktionen.php");

if (!isset($_SESSION["Erfolg"])) {
    $_SESSION["Erfolg"] = null;
}
if (!isset($_SESSION["Erfolgpw"])) {
    $_SESSION["Erfolgpw"] = null;
}

?>

<html>

<head>
    <title>Einstellungen</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="rpgstyle.css" />
    <link rel="stylesheet" type="text/css" href="mobilerpgstyle.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="Hintergrund"></div>

    <div class="Zurückbutton">
        <a href="/rpg.php" onclick="PlaySound();"><img src="Bilder/Zurückbutton.png" width="100" height="100" /></a>
    </div>

    <div class="WaffenContainer">
        <p class="Überschrift">Einstellungen</p>
        <div class="Waffenliste">
            <div class="PasswortContainer">
                <label>Name aendern</label><br>
                <form action="/login.php" method="POST">
                    <input id="nameaendern" name="neuername" type="text" pattern="[a-zA-Z]{3,16}" title="3 bis 16 Zeichen">
                    <p id="fehlername"><?php echo $_SESSION["Erfolg"]; ?></p>
                    <div class="LoginButtons">
                        <button type="submit" name="action" value="nameaendern" style="border: 0; background: transparent" onclick="PlaySound();"><img src="/Bilder/HolzTextButtonAendern.png"></button>
                        <button type="reset" value="Zurücksetzen" style="border: 0; background: transparent" onclick="PlaySound();"><img src="/Bilder/HolzTextButtonEntfernen.png"></button>
                    </div>
                </form>
                <div class="Platzhalter"></div>

                <form action="/login.php" method="POST">
                    <label>Passwort : </label><br>
                    <input type="password" id="pname" name="pw" pattern="(?=(.*\d){1})(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}" title="min 8 Zeichen,Buchstaben,Zahlen,min 1 Sonderzeichen" required><br>
                    <label>Passwort</label><br>
                    <label>Wiederholen</label><br>
                    <input type="password" id="pname2" name="pw2" pattern="(?=(.*\d){1})(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}" title="min 8 Zeichen,Buchstaben,Zahlen,min 1 Sonderzeichen" required><br>
                    <p id="fehlerpw"><?php echo $_SESSION["Erfolgpw"]; ?></p>
                    <div class="LoginButtons">
                        <button type="submit" name="action" value="pwaendern" style="border: 0; background: transparent" onclick="PlaySound();"><img src="/Bilder/HolzTextButtonAendern.png"></button>
                        <button type="reset" value="Zurücksetzen" style="border: 0; background: transparent" onclick="PlaySound();"><img src="/Bilder/HolzTextButtonEntfernen.png"></button>
                    </div>
                </form>
                <div class="Platzhalter"></div>
                <p style="color:red">Konto Entfernen</p>
                <form action="/login.php" method="POST">
                    <div class="LoginButtons">
                        <button id="Absenden" name="konto" value="loeschen" style="border: 0; background: transparent" onclick="PlaySound();"><img src="/Bilder/HolzTextButtonLöschen.png"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function PlaySound() {
            //onclick="PlaySound();"

            var audio = new Audio('/Audio/tap.wav');
            audio.play();
        }

        let benutzernameaendern = document.getElementById("nameaendern");
        let fehlername = document.getElementById("fehlername");
        benutzernameaendern.addEventListener('input', BenutzerVorhanden);

        function BenutzerVorhanden() {

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 1) {
                        fehlername.innerHTML = "Bereits vorhanden";
                    } else {
                        fehlername.innerHTML = "";
                    }
                }
            }
            xhttp.open("POST", "login.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("Registrieren=test ?benutzername=" + benutzernameaendern.value + "");
        }


        let passwort = document.getElementById("pname");
        let passwort2 = document.getElementById("pname2");
        let fehlerpw = document.getElementById("fehler");
        passwort.addEventListener('input', PasswortGleichheit);
        passwort2.addEventListener('input', PasswortGleichheit);

        function PasswortGleichheit(event) {

            if (passwort.value !== passwort2.value) {
                fehler.innerHTML = "Ungleich";
            }
        }
    </script>


</body>

</html>