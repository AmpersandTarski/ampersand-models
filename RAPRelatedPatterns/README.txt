{-Deze README legt de bedoeling uit van deze directory.

RAP is a shared repository for Ampersand artifacts.
It is currently under development.
RAP is being developed in this directory, because it will be part of the Ampersand system.

RAP is defined in Ampersand.

One purpose of RAP is to have a formal specification of Ampersand. This specification is correct when:
 - the formal specification of Ampersand is part of the definition of RAP and
 - RAP is defined correctly in Ampersand and
 - RAP is generated directly from the Ampersand script RAP.adl and
 - the generator that translates an Ampersand script into working software works correctly.
The current state is:
 - the formal specification of Ampersand is under construction. Currently it consists of a number of .pat files
   that reside on the Sourceforge SVN-server under AmpersandData/FormalAmpersand.
 - The RAP specification is not yet correct.
 - RAP has not yet been generated.
 - The generator that translates an Ampersand script into working software does not yet work correctly.

But.... we are closing in on this target.

A second purpose of RAP is to provide the Ampersand team with a shared language in which Ampersand can be discussed (some call this a meta-language).


2) Later zal er ook behoefte komen aan proces-patterns voor eenvoudige beheertools, gebaseerd op services. Service definities (tryouts) staan in .SVC bestanden.

3) Er is ook behoefte aan andere artefacten dan pattern(file)s die het begrip rondom RAP kunnen helpen verduidelijken. Een voorbeeld daarvan is een overzichtsplaatje van RAP Concepten in bijv. een VSD bestand, of voorbeeld populaties (.POP bestanden).

4) Eventueel .ADL bestanden zien we als een 'populatie' van de relatie 'uses[Context*Pattern]'. Consequentie hiervan is dat ADL bestanden GEEN autoriteit hebben (die is voorbehouden aan de .PAT bestanden).
-}
-----------------------------------------------------------