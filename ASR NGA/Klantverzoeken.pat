CONTEXT Klantverzoek 

PURPOSE PATTERN Klantverzoek
	{+
		Eén van de wensen is om inzicht te krijgen in de klantverzoeken die binnenkomen. Het inzicht is onderverdeeld in verschillende soorten klantverzoeken ((offerte, contractaanvraag, etc)) die binnenkomen. Of een klantverzoek automatisch verwerkt wordt of dat een behandelaar naar het klantverzoek moet kijken. Tevens is inzicht gewenst in de producten die afgesloten worden.	
		In deze paragraaf worden de definities en afspraken beschreven die aan de wens tot uiting moet laten komen. 
	
	-}

PATTERN Klantverzoek

	PURPOSE CONCEPT Klantverzoek REF "Requirements overzicht.ppt"
    {+
     Alle verzoeken die de aanvrager indient (bijvoorbeeld premieberekening, offerteaanvraag, contractaanvraag en administratieve wijziging) komen digitaal binnen.
    -}
    CONCEPT Klantverzoek "Een klantverzoek is een digitaal verzoek dat vanuit de aanvrager wordt ingediend en wordt verwerkt door de NGA Applicatie." "Requirements overzicht.ppt"
	
	PURPOSE CONCEPT Aanvragen REF ""
	{+
	
	-}	
	CONCEPT Aanvrager "Een aanvrager is degene die het klantverzoek heeft ingediend."
	
	PURPOSE CONCEPT Producttype REF "Marketoffering"
    {+
     Er worden verschillende soorten producten aangeboden, deze soorten worden onderscheiden op basis van het producttype.
     De producttypes die momenteel aangeboden worden zijn: ziektekosten, verzuim, inkomens aanvulling en arbeidsongeschiktheid.
    -}
    CONCEPT Producttype "Het producttype is de aanduiding van een specifiek NGA product." "Marketoffering"

	PURPOSE CONCEPT Beoordelingsresultaat REF "Ergens"
    {+
        Om te bepalen of een klantverzoek geautomatiseerd kan worden afgehandeld dan wel door een behandelaar wordt opgepakt, wordt een beoordeling uitgevoerd. 
     De uitkomst van de beoordeling, het beoordelingsresultaat, wordt bepaald door meta-informatie (extern aangevraagd, commerciele korting) van het klantverzoek of door de accepatiemodule die het risico beoordeeld.
    -}
    CONCEPT Beoordelingsresultaat "Een beoordelingsresultaat van een klantverzoek geeft aan of het klantverzoek automatisch afgehandeld wordt of door een behandelaar wordt opgepakt." "Requirements overzicht.ppt"
	
	-----------------------------------------------------------
    --        ISA relaties
    -----------------------------------------------------------
    
	-----------------------------------------------------------
    --        Relaties
    -----------------------------------------------------------
     

    -----------------------------------------------------------
    --        De relatie resulteertIn
    -----------------------------------------------------------
    PURPOSE RELATION resulteertIn[Klantverzoek*Beoordelingsresultaat] REF ""
    {+
        Na deze opsomming van definities volgt een uiteenzetting over de afspraken, die betekenis geven aan de taal van managementmentinformatie.
        Waar mogelijk geven we bij elke zin of deel daarvan een aantal voorbeelden (frasen genaamd) van het gebruik van deze zin.

    -}
    RELATION resulteertIn[Klantverzoek*Beoordelingsresultaat]  [UNI]
    PRAGMA "" " is beoordeeld als "
    MEANING "De uitspraak ``Klantverzoek $a$ is beoordeeld als $b$.'' behoort tot de gemeenschappelijke taal."

    -----------------------------------------------------------
    --        De relatie heeftBetrekkingOp
    -----------------------------------------------------------
    PURPOSE RELATION heeftBetrekkingOp[Klantverzoek*Producttype] REF ""
    {+


    -}
    RELATION heeftBetrekkingOp[Klantverzoek*Producttype]  [SUR]
    PRAGMA "" " heeft betrekking op het producttype "
    MEANING "De uitspraak ``Klantverzoek $a$ heeft betrekking op producttype $p$.'' behoort tot de gemeenschappelijke taal."

      -----------------------------------------------------------
    --        De relatie aangevraagdDoor
    -----------------------------------------------------------
    PURPOSE RELATION aangevraagdDoor[Klantverzoek*Aanvrager] REF ""
    {+


    -}
    RELATION aangevraagdDoor[Klantverzoek*Aanvrager]  [SUR]
    PRAGMA "" " is aangevraagd door "
    MEANING "De uitspraak ``Klantverzoek $a$ is aangevraagd door aanvrager $b$.'' behoort tot de gemeenschappelijke taal."

	-----------------------------------------------------------
    --        De relatie klantverzoekHeeftEenStatus
    -----------------------------------------------------------
    PURPOSE RELATION klantverzoekHeeftEenStatus[Klantverzoek*Status] REF ""
    {+

    -}
    RELATION klantverzoekHeeftEenStatus[Klantverzoek*Status] [UNI,TOT]
    PRAGMA "" " heeft status "
    MEANING "De uitspraak ``Klantverzoek $k$ heeft status $s$.'' behoort tot de gemeenschappelijke taal."

    -----------------------------------------------------------
    --        De relatie klantverzoekRelevant
    -- FIXME  Nog nodig?
    -----------------------------------------------------------
    --PURPOSE RELATION klantverzoekRelevant[Klantverzoek*Statusovergang] REF ""
    --{+

    ---}
    --RELATION klantverzoekRelevant[Klantverzoek*Statusovergang] [UNI]
    --PRAGMA "" " heeft statusovergang "
    --MEANING "De uitspraak ``Klantverzoek $t$ heeft statsovergang $t$.'' behoort tot de gemeenschappelijke taal."

	-----------------------------------------------------------
    --        Regels
    -----------------------------------------------------------

	-----------------------------------------------------------
    --        De regel klantverzoek dient beoordeelt te worden
    -----------------------------------------------------------
    PURPOSE RULE "Klantverzoek dient beoordeeld te worden" REF ""
    {+
        Naast afspraken, zijn er ook regels beschreven die als afspraak uitgedrukt worden. Deze worden hieronder beschreven.
    -}
    RULE "Klantverzoek dient beoordeeld te worden" : I |- resulteertIn;resulteertIn~
    MEANING "Als een klantverzoek wordt ingediend, dan mag dit klantverzoek niet onbeoordeeld blijven."
    MESSAGE "Het klantverzoek heeft nog geen beoordelingsresultaat."
    VIOLATION (TXT "Klantverzoek ", SRC I, TXT " dient beoordeelt te worden")

	
ENDPATTERN

ENDCONTEXT