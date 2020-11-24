//X
function KampfStarten(Spieler,Gegner)
{ 

    SpielerSperren();
    let kampfstartenbutton = document.getElementById("kampfstartenbutton");
    kampfstartenbutton.setAttribute("disabled",true);
    let Kampfbeginner = Beginner(Spieler,Gegner);
    let Kampfnichtbeginner = null;
    if(Kampfbeginner === Spieler){Kampfnichtbeginner = Gegner}
    else {Kampfnichtbeginner = Spieler;}

    KampfRunde(Kampfbeginner,Kampfnichtbeginner); 
}
//X
function KampfRunde(Kampfbeginner,Kampfnichtbeginner) 
{ 
  (async function () {
   async function sleep(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
  }
   //Beginner
    if(Kampfnichtbeginner.leben>0)
    { 
    await sleep(1000);
    SkalierenGroß(AngriffsID(Kampfbeginner));
    await sleep(1000);
    SkalierenKlein(AngriffsID(Kampfbeginner));
    SkalierenGroß(LebenID(Kampfnichtbeginner));
    Kampfbeginner.Angreifen(Kampfnichtbeginner);//Angriff
    await sleep(1000);
    SkalierenKlein(LebenID(Kampfnichtbeginner));
    }

    if(Kampfbeginner.leben>0)
    { 
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

    if(Kampfbeginner.leben >0 && Kampfnichtbeginner.leben >0)
    {          
      KampfRunde(Kampfbeginner,Kampfnichtbeginner);        
    } 
  }
)()
}
//X
function Kampfende(Angreifer,Gegner)
{
  if(Angreifer.seite === "links")
  {
  SpielerLinks = Angreifer;
  GegnerRechts = Gegner;
  }
  else {SpielerLinks = Gegner; GegnerRechts = Angreifer;}

  Gewinner = null;
  Verlierer = null;
  verdienst = null;
  erfahrung = null;
  verlust = null;
  lvlupbool = false;
  if(SpielerLinks.leben >0 && GegnerRechts.leben <= 0)
  {
  Gewinner = SpielerLinks;
  Verlierer = GegnerRechts;
  Gewinner.geld += Verlierer.geld; 
  erfahrungvorher = Gewinner.erfahrung;                           
  Gewinner.erfahrung += GegnerRechts.erfahrung;     
  if(Gewinner.erfahrung > Gewinner.lvl*100)
  { 
  Gewinner.erfahrung = erfahrungvorher + GegnerRechts.erfahrung-(Gewinner.lvl*100);
  Gewinner.lvl ++;
  Gewinner.maxleben +=3;
  Gewinner.angriffswert +=1;
  lvlupbool = true;
  } 
  verdienst = Verlierer.geld;
  verlust = Verlierer.geld;
  erfahrung = Verlierer.erfahrung;
  Verlierer.geld = 0;
  }
  else
  { 
  Gewinner = GegnerRechts;
  Verlierer = SpielerLinks;
  differenz = 0;

  if(Verlierer.geld >0 && Gewinner.geld > Verlierer.geld)
  {
  differenz = Math.round(Verlierer.geld/2);
  verdienst = differenz;
  Gewinner.geld += differenz;
  verlust = Verlierer.geld-differenz;
  Verlierer.geld = differenz;
  } 
  else
  {
   verlust = Gewinner.geld;
   Verlierer.geld -= Gewinner.geld; 
   Gewinner.geld = Gewinner.geld*2;
   verdienst = Gewinner.geld;
  }

  erfahrung = 0;
  }

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
  if(lvlupbool === true)
  {
  let lvlup = document.getElementById("lvlup");
  lvlup.innerHTML = `${Gewinner.name} ist jetzt Level ${Gewinner.lvl}!`;
  }
  // Zurück in die Datenbank
  VersendenVorbereiten(SpielerLinks,GegnerRechts);
}
//X
class Avatar
{
  constructor(name,lvl,angriff,ruestungswert,leben,uiruestung,uileben,seite,geld,erfahrung,angriffswert,maxleben) 
  {
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
     this.angriffswert = angriffswert;
     this.maxleben = maxleben;
  }
  Angreifen(Gegner)                                  
  {    
    if(this.leben >0 && Gegner.leben >0)
    {                         
    if(this.angriff > Gegner.ruestungswert)
    {Gegner.leben = (Gegner.leben + Gegner.ruestungswert) - this.angriff;
    Gegner.ruestungswert = 0;} 
    else if (Gegner.ruestungswert > 0)
    { Gegner.ruestungswert = Gegner.ruestungswert - this.angriff;}
    if(Gegner.leben <0)
    Gegner.leben = 0;
    Gegner.uiruestung.innerText = Gegner.ruestungswert;
    Gegner.uileben.innerText = Gegner.leben;

    if(Gegner.leben <=0)
    Kampfende(this,Gegner);
    }

  } 
}

function GegnerErfahrungBerechnen(lvl,leben,angriff)
{
   value = lvl+leben+angriff;
   erfahrung = Math.round(value);
   return erfahrung;
}
//X
function SpielerErfahrungBerechnen(lvl,maxleben,angriff,ruestung)
{
  value = lvl*10+maxleben+angriff,ruestung;
  erfahrung = Math.round(value);
  return erfahrung;
}
//X
function AngriffsID(Avatar)
{
    if(Avatar.seite === "links")
    {return "AngriffRahmenLinks";}
    else{return "AngriffRahmenGegnerLinks"; }
}
//X
function LebenID(Avatar)
{
    if(Avatar.seite === "links")
    {return "RuestungRahmenLinks";}
    else{return "LebenRahmenRechts"; }
}
//X
function Beginner(Spieler,Gegner)
{
     let value= Math.floor(Math.random() * Math.floor(2));
     if(value === 1)
     {return Spieler;}
     else{return Gegner};  
}


function SkalierenGroß(id)
{
  let element = document.getElementById(id)
  let test= document.getElementById("test");
  element.style.width = element.offsetWidth*1.03;
  element.style.height = element.offsetHeight*1.03;
  test.src = "/Bilder/Rot.png";
}
function SkalierenKlein(id)
{
  let element= document.getElementById(id);
  let test= document.getElementById("test");
  element.style.width = element.offsetWidth*0.95;
  element.style.height = element.offsetHeight*0.95;
  test.src = "/Bilder/Kampf.png";
}
