-----------------------------------------
HOE DE 'Generics' APPLICATIE TE GEBRUIKEN
-----------------------------------------
Afkortingen die ik gebruik:
- <OUREP> het pad waar jij jouw kopie van de OU-repository hebt staan.
- <APP> de directory die de web-site van de applicatie bevat (waar 'index.php' in staat). 

--------------------------------------
COMPILEREN EN VOOR HET EERST OPSTARTEN
--------------------------------------
- gebruik de OUDE prototypegenerator en maak daarmee een prototype van "Generics.adl";
  de code komt dus in <APP>
- in <APP> moet daarna nog een aantal dingen worden geregeld:
  1. kopieer het bestand "<OUREP>\trunk\static\pluginsettings.php" naar "<APP>\"
  2. kopieer de directory "<OUREP>\trunk\static\php\", inclusief alle subdirectories, naar "<APP>\php\"
- Edit het bestand 'pluginsettings.php'
  1. zet de waarde van '$execEningeIsVerySilent' op 'false' (voor externe demo's: op 'true')
     zet de waarde van '$execEngineIsSilent' op 'true' (voor debuggen: op 'false')
- Bekijk elk .PHP bestand in de map <APP>\php\plugins
  In het commentaar blok op de eerste regels staan de specifieke zaken die je nog moet regelen om de betreffende plugin aan de gang te krijgen. Dat doen we liever daar dan hier, omdat de kans dat het daar bijgehouden gaat worden groter is dan hier. Zo staat er bij de email-plugin bijvoorbeeld wat er nog nodig is om email vanuit de server te verzenden en hoe je een account moet regelen.
- als je 'Generics' voor het eerst opstart, dan krijg je een hele serie php foutmeldingen
  Deze hebben te maken met dat de database niet bestaat. Maak daarom eerst een schone database
  (klik op 'create a new database' HELEMAAL onderaan de web-pagina)

--------------------------------------
DEMO: VERSTUREN VAN EMAILS OF SMSJES
--------------------------------------
- Start 'Generics' op (maak evt. een nieuwe database)
- Klik op 'Login' in de (zwarte) menu-balk en daarna op 'Edit'
  - Vul de username en password in (gebruik drop-down menu's als je wilt)
    (als je niet inlogt mag je geen berichten versturen)
  - Klik op 'Save'
- Klik op 'Verstuur bericht' in de (zwarte) menu-balk
  je krijgt nu een lijstje van mensen aan wie je een bericht kunt sturen
- Klik op de naam van degene aan wie je een bericht wilt sturen.
  Er verschijnt een interface waar je je bericht kunt intypen. 
- Specificeer een email bericht en/of sms-bericht en klik op 'Save'
  N.B. het versturen werkt alleen als je een geldig account hebt ingevuld.

--------------------------------------
DEMO: SPELEN MET DATUMS/TIJDEN
--------------------------------------
- Start 'Generics' op (maak evt. een nieuwe database)
- Klik op 'Session Dates and Times' in de (zwarte) menu- balk 
  Als we verderop schrijven: DateTime -> "tekst" dan bedoelen we daarmee
  dat je de volgende handelingen uitvoert:
  (1) klik op 'Edit' en verwijder evt. bestaande tekst uit het DateTime veld.
  (2) voer "tekst" (zonder quotes) in het te editen veld in, en klik op 'Save'.
- DateTime -> "12-3-1958"
  Let op de standaardnotatie: deze is precies andersom. 
  De standaardnotatie kun je kiezen in de ADL code (zie aldaar)
- DateTime -> "3-6-1963"
  Merk op dat de boxjes met relaties als 'Equal to', 'Not equal to',
  'Greater than' en 'Less than' automatisch worden bijgewerkt
- DateTime -> "12 march 1958"
  Je ziet dat er meerdere mogelijkheden zijn om dezelfde datum in te voeren
- DateTime -> "Tomorrow"
  en speel gerust verder...

Veel plezier.
Rieks