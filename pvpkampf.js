function KampfStarten(Spieler, Gegner) {

  SpielerSperren();
  let kampfstartenbutton = document.getElementById("kampfstartenbutton");
  kampfstartenbutton.style.display = "none";
  let Kampfbeginner = Beginner(Spieler, Gegner);
  let Kampfnichtbeginner = null;
  if (Kampfbeginner === Spieler) { Kampfnichtbeginner = Gegner }
  else { Kampfnichtbeginner = Spieler; }

  KampfRunde(Kampfbeginner, Kampfnichtbeginner);
}

function KampfRunde(Kampfbeginner, Kampfnichtbeginner) {
  (async function () {
    async function sleep(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    }
    //Beginner
    if (Kampfnichtbeginner.leben > 0) {
      await sleep(1000);
      SkalierenGroß(AngriffsID(Kampfbeginner));
      await sleep(1000);
      SkalierenKlein(AngriffsID(Kampfbeginner));
      SkalierenGroß(LebenID(Kampfnichtbeginner));
      Kampfbeginner.Angreifen(Kampfnichtbeginner);//Angriff
      await sleep(1000);
      SkalierenKlein(LebenID(Kampfnichtbeginner));
    }

    if (Kampfbeginner.leben > 0) {
      //Nicht Beginner
      await sleep(1000);
      SkalierenGroß(AngriffsID(Kampfnichtbeginner));
      await sleep(1000);
      SkalierenKlein(AngriffsID(Kampfnichtbeginner));
      SkalierenGroß(LebenID(Kampfbeginner));
      Kampfnichtbeginner.Angreifen(Kampfbeginner); //Angriff
      await sleep(1000);
      SkalierenKlein(LebenID(Kampfbeginner));
    }

    if (Kampfbeginner.leben > 0 && Kampfnichtbeginner.leben > 0) {
      KampfRunde(Kampfbeginner, Kampfnichtbeginner);
    }
  }
  )()
}

function Kampfende(Angreifer, Gegner) {
  if (Angreifer.seite === "links") {
    SpielerLinks = Angreifer;
    GegnerRechts = Gegner;
  }
  else { SpielerLinks = Gegner; GegnerRechts = Angreifer; }

  Gewinner = null;
  Verlierer = null;
  verdienst = null;
  erfahrung = null;
  verlust = null;
  lvlupbool = false;
  if (SpielerLinks.leben > 0 && GegnerRechts.leben <= 0) {
    Gewinner = SpielerLinks;
    Verlierer = GegnerRechts;
  }
  else {
    Gewinner = GegnerRechts;
    Verlierer = SpielerLinks;
  }
  differenz = Math.round(Verlierer.geld / 2);
  Gewinner.geld += differenz;
  verlust = differenz;
  Verlierer.geld -= differenz;
  erfahrungvorher = Gewinner.erfahrungdb;
  Gewinner.erfahrungdb += Verlierer.erfahrung;

  if (Gewinner.erfahrungdb > Gewinner.lvl * 100) {
    Gewinner.erfahrungdb = erfahrungvorher + Verlierer.erfahrung - (Gewinner.lvl * 100);
    Gewinner.lvl++;
    Gewinner.maxleben += 3;
    Gewinner.angriffswert += 1;
    lvlupbool = true;
  }
  verdienst = differenz;
  erfahrung = Verlierer.erfahrung;

  PopUp();

  let kampfergebnisse = document.getElementById("Kampfergebnisse");
  let kampfgewinner = document.getElementById("kampfgewinner");
  let kampfgeld = document.getElementById("kampfgeld");
  let kampferfahrung = document.getElementById("kampferfahrung");
  let kampfverlierer = document.getElementById("kampfgeldverlust");

  kampfergebnisse.style.display = "block";
  kampfgewinner.innerHTML = `${Gewinner.name} hat gegen ${Verlierer.name} gewonnen !`;
  kampfgeld.innerHTML = `${Gewinner.name} bekommt ${verdienst} Geld !`;
  kampferfahrung.innerHTML = `${Gewinner.name} bekommt ${erfahrung} Erfahrung !`;
  kampfverlierer.innerHTML = `${Verlierer.name} verliert ${verlust} Geld !`;
  if (lvlupbool === true) {
    let lvlup = document.getElementById("lvlup");
    lvlup.innerHTML = `${Gewinner.name} ist jetzt Level ${Gewinner.lvl}!`;
  }
  // Zurück in die Datenbank
  VersendenVorbereiten(SpielerLinks, GegnerRechts);
}

class Avatar {
  constructor(name, lvl, angriff, ruestungswert, leben, uiruestung, uileben, seite, geld, erfahrung, erfahrungdb, angriffswert, maxleben) {
    this.name = name;
    this.lvl = lvl;
    this.angriff = angriff;
    this.ruestungswert = ruestungswert;
    this.leben = leben;
    this.uiruestung = uiruestung;
    this.uileben = uileben;
    this.seite = seite;
    this.geld = geld;
    this.erfahrung = erfahrung;
    this.erfahrungdb = erfahrungdb;
    this.angriffswert = angriffswert;
    this.maxleben = maxleben;
  }
  Angreifen(Gegner) {
    if (this.leben > 0 && Gegner.leben > 0) {
      if (this.angriff > Gegner.ruestungswert) {
        Gegner.leben = (Gegner.leben + Gegner.ruestungswert) - this.angriff;
        Gegner.ruestungswert = 0;
      }
      else if (Gegner.ruestungswert > 0) { Gegner.ruestungswert = Gegner.ruestungswert - this.angriff; }
      if (Gegner.leben < 0)
        Gegner.leben = 0;
      Gegner.uiruestung.innerText = Gegner.ruestungswert;
      Gegner.uileben.innerText = Gegner.leben;

      if (Gegner.leben <= 0)
        Kampfende(this, Gegner);
    }

  }
}

function SpielerErfahrungBerechnen(lvl, maxleben, angriff, ruestung) {
  value = lvl * 10 + maxleben + angriff, ruestung;
  erfahrung = Math.round(value);
  return erfahrung;
}

function AngriffsID(Avatar) {
  if (Avatar.seite === "links") { return "AngriffRahmenLinks"; }
  else { return "AngriffRahmenRechts"; }
}
function LebenID(Avatar) {
  if (Avatar.seite === "links") { return "RuestungRahmenLinks"; }
  else { return "LebenRahmenMitte"; }
}

function Beginner(Spieler, Gegner) {
  let value = Math.floor(Math.random() * Math.floor(2));
  if (value === 1) { return Spieler; }
  else { return Gegner };
}


function SkalierenGroß(id) {
  let element = document.getElementById(id)
  let test = document.getElementById("spieler2waffenbild");
  element.style.width = element.offsetWidth * 1.03;
  element.style.height = element.offsetHeight * 1.03;
  test.src = "/Bilder/Rot.png";
}
function SkalierenKlein(id) {
  let element = document.getElementById(id);
  let test = document.getElementById("spieler2waffenbild");
  element.style.width = element.offsetWidth * 0.95;
  element.style.height = element.offsetHeight * 0.95;
  test.src = "/Bilder/Kampf.png";
}

function PopUp() {
  let popup
  popup = document.querySelector("#Kampfergebnisse")
  if (popup !== null) {
    popup.style.opacity = 1;
    popup.style.transform = "translate(+0%, +0%) scale(1)";
  }
}