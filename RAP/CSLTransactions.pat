PATTERN CSLTransactions -- Author(s) rieks.joosten@tno.nl
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

RULE contextDef: I = -(-isPartOf;isPartOf~) /\ -(isPartOf;-isPartOf~) PHRASE "A VersionedContext is defined as the set of all tuples that are part of it."
--I = isPartOf <> isPartOf
--r <> r~ = -(-r;r~) /\ -(r;-r~)
isPartOf :: Tuple * VersionedContext PRAGMA "" " is part of ".
GEN VersionedContext ISA Contents -- 'Contents' is defined in 'Versioning.pat'
GEN          Context ISA Object   -- 'Object' is defined in 'Versioning.pat'

--At every point in time, the database contents must be free of any violations
violationFree :: VersionedContext * VersionedContext [PROP] PRAGMA "" " does not contain any violations".

RULE "contextIntegrity": violationFree = I /\ -(uses; definedIn~; violates~; V)
PHRASE "Contents of a database should be violation-free, which means that the contents of the database does not contain any violations of any rule that is committed to within this context."

--Following relations and rules are 'inherited' from RAP:
uses      :: VersionedContext * Pattern.
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

transactionContext :: Transaction -> Context PRAGMA "" " has started on ".
transactionPreContents :: Transaction * Tuple PRAGMA "Before " " started, " " was part of the database contents"

RULE oldContent: I /\ -(transactionCommitted;transactionCommitted \/ transactionCancelled;transactionCancelled~); transactionContext;contents |- transactionPreContents -- dit betekent dat als een andere transactie wordt gecommit terwijl een transactie nog niet is afgesloten, de transactionPreContents van deze transactie onmiddellijk wijzigt!

transactionInserts :: Transaction * Tuple PRAGMA "If " " is, or were to be committed to, " " would (have) be(en) inserted".
RULE preInsert:  preTransactionContents~; transactionInserts |- -isPartOf~ PHRASE "Before the transaction is committed to, tuples that are to be inserted do not yet exist in the database."
RULE postInsert: postCommitEventContent~;   transactionInserts |-  isPartOf~ PHRASE "After the transaction is committed to, tuples that are inserted do exist in the database."

transactionDeletes :: Transaction * Tuple PRAGMA "If " " is, or were to be committed to, " " would (have) be(en) deleted". 
RULE preDelete:  preTransactionContents~; transactionDeletes |-  isPartOf~ PHRASE "Before the transaction is committed to, tuples that are to be deleted must exist in the database."
RULE postDelete: postCommitEventContent~;   transactionDeletes |- -isPartOf~ PHRASE "After the transaction is committed to, tuples that have been deleted no longer exist in the database."

RULE newContent: postCommitEventContent = transactionCommitted;((preCommitEventContent \/ transactionInserts) /\ -transactionDeletes) PHRASE "After a trasaction is committed, the database contents consists of the old database contents with appropriate insertions and deletions."

--Transactions are associated with at most 3 possible events
transactionStarted   :: Transaction -> Event PRAGMA "The start of " " is marked by ".
PURPOSE RELATION transactionStarted IN ENGLISH
{+Starting a transaction means that ... -}
transactionCancelled :: Transaction * Event [UNI] PRAGMA "" " has been cancelled by ".
PURPOSE RELATION transactionCancelled IN ENGLISH
{+Cancelling a transaction means that ... -}
transactionCommitted :: Transaction * CommitEvent [UNI] PRAGMA "Commitment of " " is marked by ".
PURPOSE RELATION transactionCommitted IN ENGLISH
{+Committing to a transaction, i.e. committing to the changes that the transaction brings about, is an event that changes the context. If the context is versioned, a new version of the context is created.-}

ENDPATTERN