PATTERN CSLTransactions -- WIJZIGER: rieks.joosten@tno.nl
--!PATTERN CSLTransactions USES Versioning
PURPOSE PATTERN CSLTransactions IN ENGLISH
{+Transactions are defined to show what data integrity means-}
-----------------------------------------------------------------------
{- Revision history
RJ/20110220 - "Techneutenweekend-changes", just putting the relations here without all that much explanation
-}
-----------------------------------------------------------------------
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`__
--!Inspiratie zit in D:\CC_Demos\ADL_Onderzoek\OU - BOOK\ChpSemantics\ADLspecification.tex

RULE dbContentsDef: I = -(-isPartOf;isPartOf~) /\ -(isPartOf;-isPartOf~) PHRASE "A DBContents is defined as the set of all tuples that are part of it."
--I = isPartOf <> isPartOf
--r <> r~ = -(-r;r~) /\ -(r;-r~)

isPartOf :: Tuple * DBContents PRAGMA "" " is part of ".
GEN DBContents ISA Inhoud -- 'Inhoud' is gedefinineerd in 'Versioning.pat'

--At every point in time, the database contents must be free of any violations
violationFree :: DBContents * DBContents [PROP] PRAGMA "" " does not contain any violations".

RULE "dbIntegrity": violationFree = I /\ -(context; uses; definedIn~; violates~; V)
PHRASE "Contents of a database should be violation-free, which means that the contents of the database does not contain any violations of any rule that is committed to within this context."

context :: DBContents -> Context PRAGMA "" " runs in ".
--Following relations and rules are 'inherited' from RAP:
uses      :: Context * Pattern.
definedIn :: Rule -> Pattern.
violates  :: Violation * Rule.
elem      :: Pair * Relation.
src       :: Pair * Concept.
trg       :: Pair * Concept.
left      :: Pair * Atom.
right     :: Pair * Atom.
type      :: Atom * Concept.

RULE srctype: src = left;type PHRASE "The source concept defines the type of the left atom in a pair."
RULE dsttype: trg = right;type PHRASE "The target concept defines the type of the right atom in a pair."
RULE pairKey: I = elem;elem~ /\ left;left~ /\ right;right~ PHRASE "A pair is uniquely characterized by its relation and its left and right atoms."

--Transactions modfiy the database contents. Because of Rule "dbIntegrity", this modification maintains the property that databases should be violation-free

txaFrom :: Transaction -> DBContents PRAGMA "" "changes the contents of a database " "into another contents".
txaInsert :: Transaction * Tuple PRAGMA "If " " is, or were to be committed to, " " would (have) be(en) inserted".
txaDelete :: Transaction * Tuple PRAGMA "If " " is, or were to be committed to, " " would (have) be(en) deleted". 
txaTo   :: Transaction * DBContents [UNI] PRAGMA "" "changes the contents of a database into ".

RULE preInsert:  txaFrom~; txaInsert |- -isPartOf~ PHRASE "Before the transaction has taken place, tuples that are to be inserted do not yet exist in the database."
RULE preDelete:  txaFrom~; txaDelete |-  isPartOf~ PHRASE "Before the transaction has taken place, tuples that are to be deleted must exist in the database."

RULE postInsert: txaTo~;   txaInsert |-  isPartOf~ PHRASE "After the transaction has taken place, tuples that are inserted do exist in the database."
RULE postDelete: txaTo~;   txaDelete |- -isPartOf~ PHRASE "After the transaction has taken place, tuples that have been deleted no longer exist in the database."

--Transactions are associated with at most 3 possible events
--Later zou dit ding 
txaStarted   :: Transaction -> Event PRAGMA "The start of " " is marked by ".
txaCommitted :: Transaction * Event [UNI] PRAGMA "Commitment of " " is marked by ".
txaCancelled :: Transaction * Event [UNI] PRAGMA "The start of " " is marked by ".


ENDPATTERN
{-----------------------------------------
PATTERN OLDRAP --!The following text is copied from BOOK\ChpSemantics\ADLspecification.tex
  uses      :: Rule*Relation.

	violates  :: Violation * Rule.
  definedIn :: Rule -> Pattern.
  source    :: Type->Concept.
  target    :: Type->Concept.
  signat    :: Relation*Type.
  uses      :: Rule*Relation.

	violates  :: Violation * Rule.
	contains  :: Relation * Tuple.
	left      :: Tuple -> Atom.
	right     :: Tuple -> Atom.
	contains  :: Concept * Atom.

  uses :: Context * Pattern.

RULE typechecing: (source~ \/ target~);signat~;uses~
RULE chksource: contains;left |- signat;source;contains
RULE chktarget: contains;right |- signat;target;contains

ENDPATTERN
-}