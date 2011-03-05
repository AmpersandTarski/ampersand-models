PATTERN Sets --!EXTENDS
-- Author(s) stef.joosten@ou.nl, rieks.joosten@tno.nl
--!RJ: This pattern is ready for review
--!RJ: Misschien vindt Jaap het wat om dit pattern wat uit te breiden met andere set operatoren?
PURPOSE PATTERN Sets IN ENGLISH
{+This pattern provides the relations (and in future perhaps also operators) for using sets. This is all standard high-school math. Readers that want to know more about this are referred to books on set theory.-}

isElementOf :: Element * Set PRAGMA "" " is an element of ".

isSubsetOf :: Set * Set [RFX,ASY] PRAGMA "" " is a subset of ".

RULE "set elements": isElementOf;isSubsetOf* |- isElementOf
PHRASE "Every element that belongs to a given set also belongs to every other set of which the first set is a subset."

ENDPATTERN