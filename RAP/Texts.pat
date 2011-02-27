PATTERN Texts -- Author(s) rieks.joosten@tno.nl
--!RJ: This pattern is ready for review
PURPOSE PATTERN Texts IN ENGLISH
{+This pattern provides the relations (and in future perhaps also operators, such as the concatenation operator) for using Texts. For the moment, this pattern is also necessary because the following syntax is not yet supported:
  POPULATION I[Text] CONTAINS [ ("U bent ingelogd", "U bent ingelogd") ]-}

text :: Text * Text.  
PURPOSE RELATION text IN ENGLISH
{+For the moment, this pattern is also necessary because the following syntax is not yet supported:
  POPULATION I[Text] CONTAINS [ ("U bent ingelogd", "U bent ingelogd") ]
An example of how this is used is given in the SERVICE 'Login' in file 'SessionAccounts.pat'
-}
RULE "textstub": text |- I[Text]
PURPOSE RULE "textstub" IN ENGLISH
{+For the moment, this pattern is also necessary because the following syntax is not yet supported:
  POPULATION I[Text] CONTAINS [ ("U bent ingelogd", "U bent ingelogd") ]
An example of how this is used is given in the SERVICE 'Login' in file 'SessionAccounts.pat'
-}

CONCEPT Text "a sequence of characters that humans are considered capable of reading." "RJ"

--!Concatenation requires a (set of) PLUG(s) for the actual computations.
CONCEPT Concat "a computation that associates two Texts, called the left and right teksts, with a third (result) tekst, such that the result tekst is the concatenation of the left and the right teksts." "RJ"

cleft  :: Concat -> Text PRAGMA "The first argument (left part) of " " is ".
cright :: Concat -> Text PRAGMA "The second argument (right part) of " " is ".
concat :: Concat -> Text PRAGMA "The result of concatenating the first argument with the second argument of " " is ".

RULE "concatentations": I[Concat] = cleft;cleft~ /\ cright;cright~
PHRASE "The result of every concatenation is uniquely characterized by its left and right Texts."

ENDPATTERN