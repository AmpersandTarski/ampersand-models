{- Tickets that apply to EURent:
-- https://sourceforge.net/p/ampersand/tickets/407/ (NULL values are being shown). This is a continuation of ticket [#405]
-- https://sourceforge.net/p/ampersand/tickets/406/ (the SESSION concept should not be populated with the '_SESSION'[SESSION] atom).
**Workaround: in file 'InstallerDefPop.php' (in htdocs), you should remove the section containing
                 VALUES (\'_SESSION\', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)**
-- https://sourceforge.net/p/ampersand/tickets/405/ is fixed, but this might have been a bit premature (see ticket [#407])
-- https://sourceforge.net/p/ampersand/tickets/404/ (Incorrect code generated for [SYM] (and [PROP])). This bug has been fixed, but may be relevant when compiling with older versions of the prototype generator.
-}