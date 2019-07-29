CONTEXT Klantverzoek 

PURPOSE PATTERN Klantverzoek
	{+
		EÃ©n van de wensen is om inzicht te krijgen in de klantverzoeken die binnenkomen bij NGA.
		Bij deze klantverzoeken moet onder andere de volgende informatie beschikbaar zijn.
		Het type van het klantverzoek (Bijvoorbeeld offerte, contractaanvraag).
		Het beoordelingsresultaat van het klantverzoek (Bijvoorbeeld automatische verwerking of oppakken door een behandelaar).
		het type product dat middels het klantverzoek wordt aangevraagd (Bijvoorbeeld verzuim, ziektekosten)			
	
	-}

PATTERN Klantverzoek

	PURPOSE CONCEPT Klantverzoek REF "Requirements overzicht.ppt"
    {+
     Een klantverzoek wordt gezien als een digitaal ingevuld formulier waarmee een aanvrager bijvoorbeeld een offerteaanvraag of contractaanvraag indient. 
    -}
    CONCEPT Klantverzoek "Een klantverzoek is een digitaal verzoek dat vanuit de aanvrager wordt ingediend en wordt verwerkt door de NGA Applicatie." "Requirements overzicht.ppt"
	
	PURPOSE CONCEPT Aanvrager REF ""
	{+
		De aanvrager is de persoon die het klantverzoek samenstelt en indient.
		In veel gevallen is dat de tussenpersoon die voor een werkgever een klantverzoek doorgeeft.
		Het kan echter ook de werkgever zelf zijn of een medewerker van ASR.
	-}	
	CONCEPT Aanvrager "Een aanvrager is degene die het klantverzoek heeft ingediend."
	
	
	
	PURPOSE CONCEPT Producttype REF "Marketoffering"
    {+
	 Er worden verschillende soorten producten aangeboden, deze soorten worden onderscheiden op basis van het producttype.
     Met het producttype wordt onderscheid gemaakt tussen bijvoorbeeld de verzuimverzekering, inkomensaanvulverzekering en arbeidsongeschiktheidsverzekering.
    -}
    CONCEPT Producttype "Het producttype is de aanduiding van een specifiek NGA product." "Marketoffering"

	PURPOSE CONCEPT Beoordelingsresultaat REF "Ergens"
    {+
      Om te bepalen of een klantverzoek geautomatiseerd kan worden afgehandeld dan wel door een behandelaar moet worden opgepakt, wordt een beoordeling uitgevoerd. 
     De uitkomst van de beoordeling, het beoordelingsresultaat, wordt bepaald door meta-informatie (extern aangevraagd, commerciele korting) van het klantverzoek of 
	 door de accepatiemodule die het risico beoordeeld.
    -}
    CONCEPT Beoordelingsresultaat "Het beoordelingsresultaat van een klantverzoek geeft aan of deze automatisch afgehandeld kan worden of door een behandelaar moet worden opgepakt." "Requirements overzicht.ppt"
	
	-----------------------------------------------------------
    --        ISA relaties
    -----------------------------------------------------------
    --CLASSIFY ContractAanvraag ISA Klantverzoek
    --CLASSIFY Offerte ISA Klantverzoek
    --CLASSIFY EersteZiektemelding ISA Klantverzoek
    --CLASSIFY AdministratieveWijziging ISA Klantverzoek
	-----------------------------------------------------------
    --        Relaties
    -----------------------------------------------------------
     
	
	-----------------------------------------------------------
    --        De relatie resulteertIn
    -----------------------------------------------------------
    PURPOSE RELATION resulteertIn[Klantverzoek*Beoordelingsresultaat] REF "Requirements overzicht.ppt"
    {+
        Na deze opsomming van definities volgt een uiteenzetting over de afspraken, die betekenis geven aan de taal van 'Managementinformatie over klantverzoeken en taken'.
        Waar mogelijk geven we bij elke zin of deel daarvan een aantal voorbeelden (frasen genaamd) van het gebruik van deze zin.

    -}
    RELATION resulteertIn[Klantverzoek*Beoordelingsresultaat]  
    PRAGMA "" " heeft als beoordelingsresultaat "
    MEANING "De uitspraak ``Klantverzoek $a$ heeft als beoordelingsresultaat $b$.'' behoort tot de gemeenschappelijke taal."

    -----------------------------------------------------------
    --        De relatie heeftBetrekkingOp
    -----------------------------------------------------------
    PURPOSE RELATION heeftBetrekkingOp[Klantverzoek*Producttype] REF "Marketoffering"
    {+


    -}
    RELATION heeftBetrekkingOp[Klantverzoek*Producttype]  [SUR]
    PRAGMA "" " heeft betrekking op het producttype "
    MEANING "De uitspraak ``Klantverzoek $a$ heeft betrekking op producttype $p$.'' behoort tot de gemeenschappelijke taal."

      -----------------------------------------------------------
    --        De relatie aangevraagdDoor
    -----------------------------------------------------------
    PURPOSE RELATION aangevraagdDoor[Klantverzoek*Aanvrager] REF "Requirements overzicht.ppt"
    {+


    -}
    RELATION aangevraagdDoor[Klantverzoek*Aanvrager]  [SUR]
    PRAGMA "" " is aangevraagd door "
    MEANING "De uitspraak ``Klantverzoek $a$ is aangevraagd door aanvrager $b$.'' behoort tot de gemeenschappelijke taal."

	-----------------------------------------------------------
    --        De relatie klantverzoekHeeftEenStatus
    -----------------------------------------------------------
    PURPOSE RELATION klantverzoekHeeftEenStatus[Klantverzoek*Status] REF "Requirements overzicht.ppt"
    {+

    -}
    RELATION klantverzoekHeeftEenStatus[Klantverzoek*Status] [UNI,TOT]
    PRAGMA "" " heeft status "
    MEANING "De uitspraak ``Klantverzoek $k$ heeft status $s$.'' behoort tot de gemeenschappelijke taal."

   	-----------------------------------------------------------
    --        Regels
    -----------------------------------------------------------

	-----------------------------------------------------------
    --        De regel klantverzoek dient beoordeelt te worden
    -----------------------------------------------------------
    PURPOSE RULE "Klantverzoek dient beoordeeld te worden" REF "Requirements overzicht.ppt"
    {+
        Naast afspraken, zijn er ook regels beschreven die als afspraak uitgedrukt worden. Deze worden hieronder beschreven.
    -}
    RULE "Klantverzoek dient beoordeeld te worden" : I |- resulteertIn;resulteertIn~
    MEANING "Als een klantverzoek wordt ingediend, dan mag dit klantverzoek niet onbeoordeeld blijven."
    MESSAGE "Het klantverzoek heeft nog geen beoordelingsresultaat."
    VIOLATION (TXT "Klantverzoek ", SRC I, TXT " dient beoordeelt te worden")

	
ENDPATTERN

ENDCONTEXT