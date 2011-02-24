PATTERN CSLTransactions -- Author(s) rieks.joosten@tno.nl
--!PATTERN CSLTransactions USES Versioning, Concepts, Rules, Relations, Patterns
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
isPartOf :: Pair * VersionedContext PRAGMA "" " is part of ".
GEN VersionedContext ISA Contents -- 'Contents' is defined in 'Versioning.pat'
GEN          Context ISA Object   -- 'Object' is defined in 'Versioning.pat'

--At every point in time, the database contents must be free of any violations
violationFree :: VersionedContext * VersionedContext [PROP] PRAGMA "" " does not contain any violations".

RULE "contextIntegrity": violationFree = I /\ -(uses[VersionedContext*Pattern]; definedIn~; violates~; V)
PHRASE "Contents of a database should be violation-free, which means that the contents of the database does not contain any violations of any rule that is committed to within this context."

--Transactions modfiy the database contents. Because of Rule "dbIntegrity", this modification maintains the property that databases should be violation-free

transactionContext :: Transaction -> VersionedContext PRAGMA "" " has started on ".
transactionPreContents :: Transaction * Contents PRAGMA "Before " " started, " " was part of the database contents"

RULE oldContents: (I /\ -transactionCommitted /\ -transactionCancelled); transactionContext;object;contents |- transactionPreContents -- dit betekent dat als een andere transactie wordt gecommit terwijl een transactie nog niet is afgesloten, de transactionPreContents van deze transactie onmiddellijk wijzigt!

transactionInserts :: Transaction * Pair PRAGMA "If " " is, or were to be committed to, " " would (have) be(en) inserted".
RULE preInsert:  transactionPreContents~; transactionInserts |- -isPartOf~ PHRASE "Before the transaction is committed to, tuples that are to be inserted do not yet exist in the database."
RULE postInsert: postCommitEventContents~; transactionCommit~; transactionInserts |-  isPartOf~ PHRASE "After the transaction is committed to, tuples that are inserted do exist in the database."

transactionDeletes :: Transaction * Pair PRAGMA "If " " is, or were to be committed to, " " would (have) be(en) deleted". 
RULE preDelete:  transactionPreContents~; transactionDeletes |-  isPartOf~ PHRASE "Before the transaction is committed to, tuples that are to be deleted must exist in the database."
RULE postDelete: postCommitEventContents~; transactionCommit~; transactionDeletes |- -isPartOf~ PHRASE "After the transaction is committed to, tuples that have been deleted no longer exist in the database."

RULE newContents: transactionCommitted;(transactionInserts \/ (transactionCommit; preCommitEventContents; isPartOf~ /\ -transactionDeletes)) |- transactionCommit; postCommitEventContents; isPartOf~ PHRASE "After a trasaction is committed, the database contents consists of the old database contents with appropriate insertions and deletions."

--Transactions are associated with at most 3 possible events
transactionStart   :: Transaction -> Event PRAGMA "The start of " " is marked by ".
PURPOSE RELATION transactionStart IN ENGLISH
{+Starting a transaction means that ... -}
transactionCancel :: Transaction * Event [UNI] PRAGMA "" " has been cancelled by ".
PURPOSE RELATION transactionCancel IN ENGLISH
{+Cancelling a transaction means that ... -}
transactionCommit :: Transaction * CommitEvent [UNI] PRAGMA "Commitment of " " is marked by ".
PURPOSE RELATION transactionCommit IN ENGLISH
{+Committing to a transaction, i.e. committing to the changes that the transaction brings about, is an event that changes the context. If the context is versioned, a new version of the context is created.-}

transactionCancelled :: Transaction * Transaction [PROP] PRAGMA "" " has been cancelled".
RULE "transaction is cancelled": I /\ transactionCancel;transactionCancel~ |- transactionCancelled

transactionCommitted :: Transaction * Transaction [PROP] PRAGMA "Commitment of " " is marked by ".
RULE "transaction is committed": I /\ transactionCommit;transactionCommit~ |- transactionCommitted


--Following relations and rules are adaptations w.r.t. Concepts, Rules, Relations etc.
uses      :: VersionedContext * Pattern.
violates  :: Violation * Rule.

ENDPATTERN