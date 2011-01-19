PATTERN Services -- WIJZIGER: rieks.joosten@tno.nl
-----------------------------------------------------------------------
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`__
-----------------------------------------------------------------------
{- Revision history
RJ/20110119 - Ingetypt n.a.v. plaatje van Stef, met wat gedachten erbij
-}
-----------------------------------------------------------------------

roleSvc :: Role * Service PRAGMA "Every actor that has been assigned "  " is allowed to access ".

edits :: Service * Relation PRAGMA "Every invocation of " " may affect/change the population of".

mayEdit :: Role * Relation PRAGMA "Every actor that has been assigned " " is allowed to affect/change the population of".

RULE "editCompletion" SIGNALS roleSvc~; mayEdit |- edits
I |- edits~; edits
EXPLANATION "Voor elke rol ligt vast in wekle relaties ge-edit mag worden. Ook ligt vast welke services deze rol mag gebruiken."

RULE editPermission MAINTAINS roleSvc; edits = mayEdit
EXPLANATION "Als een rol een service mag aanroepen waarin een relatie wordt ge-edit, dient deze rol daarvoor gemachtigd te zijn. Omgekeerd geldt ook dat als een rol gemachtigd is om een relatie te editen, dan moet er een service bestaan waarin hij dat kan doen."

roleSig :: Role * Signal PRAGMA "One purpose the existence of " " is to restore compliance with ".

restores :: Service * Signal PRAGMA "One purpose of the existence of " " is to restore compliance with".

RULE restoreSignal SIGNALS roleSvc~; roleSig |- restores
I |- restores~; restores
EXPLANATION "Als een rol een service mag aanroepen die ertoe dient om een regelovertreding op te heffen, dan moet ook de rol dat als doel toegekend hebben gekregen. Omgekeerd geldt ook dat als een rol ertoe dient om een signaal te beheren, er ook een service moet bestaan die dit tot doel heeft."

ENDPATTERN