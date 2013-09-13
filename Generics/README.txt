UITVOEREN VAN DE DEMO
---------------------
Afkortingen die ik gebruik:
- <OUREP> het pad waar jij jouw kopie van de OU-repository hebt staan.
- <APP> de directory die de web-site van de applicatie bevat (waar 'index.php' in staat). 

Klaarmaken van de applicatie:
- gebruik de OUDE prototypegenerator en maak daarmee een prototype van "Generics.adl"; de code komt dus in <APP>
- in <APP> moet nog een aantal dingen worden geregeld:
  1. kopieer het bestand "<OUREP>\trunk\static\pluginsettings.php" naar "<APP>\"
  2. kopieer de directory "<OUREP>\trunk\static\php\", inclusief alle subdirectories, naar "<APP>\php\"
- Edit het bestand 'pluginsettings.php'
  1. zet de waarde van '$execEningeIsVerySilent' op 'false' en de waarde van '$execEngineIsSilent' op 'true'
  2. regel een gmail-account en vul je credentials in (als je dit niet doet kun je geen emails sturen)
  3. regel een SMS-account en vul je credentials in (als je dit niet doet kun je geen SMSjes sturen)
- Loop de plugin-files na die je gebruikt (in de map <APP>\php\plugins directory). In het commentaar blok op de eerste regels staan de specifieke zaken die je nog moet regelen om de betreffende plugin aan de gang te krijgen. Dat doen we liever daar dan hier, omdat de kans dat het daar bijgehouden gaat worden groter is dan hier.

Runnen van de applicatie:
- als je Generics voor het eerst opstart, dan krijg je een hele serie php foutmeldingen die te maken hebben met dat de database niet bestaat. Dus maak je eerst een schone database (klik op 'create a new database' onderaan de web-pagina)
- Klik op 'Login' in de (zwarte) menu-balk en daarna op 'Edit'
- Vul de username en password in (gebruik drop-down menu's als je wilt)
  (als je niet inlogt mag je geen berichten versturen)
- Klik op 'Verstuur bericht' in de (zwarte) menu-balk
  je krijgt nu een lijstje van mensen aan wie je een bericht kunt sturen
- Klik op de naam van degene aan wie je een bericht wilt sturen.
  Er verschijnt een interface waar je je bericht kunt intypen. 
- Specificeer een email bericht en/of sms-bericht en klik op 'Save'
  N.B. het versturen werkt alleen als je een geldig account hebt ingevuld.

Veel plezier.
Rieks