PATTERN ContextContents --!EXTENDS Versioning, Concepts, Rules, Relations, Patterns
-- Author(s) rieks.joosten@tno.nl
PURPOSE PATTERN ContextContents IN ENGLISH
{+One of the very basic concepts of Ampersand is the existence of Contexts that This pattern defines Transactions on Contexts (i.e. a Set of Pairs associated with a Set of Rules with the property that the Set of Pairs complies with all Rules in the Set of Rules). -}
-----------------------------------------------------------------------
{- Revision history
RJ/20110220 - "Techneutenweekend-changes", just putting the relations here without all that much explanation
-}
-----------------------------------------------------------------------
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`__
--!Inspiratie zit in D:\CC_Demos\ADL_Onderzoek\OU - BOOK\ChpSemantics\ADLspecification.tex

CONCEPT VersionedContext "the set of Pairs (of Atoms in a Relation) that at some point in time constitute a violation-free database" "RJ"
PURPOSE CONCEPT VersionedContext IN ENGLISH
{+In order to discuss about the status of database contents, we need terminology that allows us to refer to the set of all Pairs (of Atoms in a Relation) that at some point in time constitute a violation-free database.-}
GEN VersionedContext ISA Set      -- by definition, see above; also, see Sets.pat.
GEN Fact             ISA Element  -- as per the definition of VersionedContexts
GEN VersionedContext ISA Contents -- 'Contents' is defined in 'Versioning.pat'
GEN Context          ISA Object   -- 'Object' is defined in 'Versioning.pat'

--At every point in time, the database contents must be free of any violations
violationFree :: VersionedContext * VersionedContext [PROP] PRAGMA "" " does not contain any violations".

RULE "contextIntegrity": violationFree = I /\ -(uses[VersionedContext*Pattern]; definedIn~; violates~; V)
PHRASE "Any VersionedContext should be violation-free, which means that it does not contain any violations of any rule that is committed to within that context."

CONCEPT Transaction "the accumulation of sets of Pairs that, upon a CommitEvent, change the Context into its successor."
PURPOSE CONCEPT Transaction IN ENGLISH
{+Transactions modify the Context (i.e. the current VersionedContext), which means that Pairs (where each Fact refers to one so-called left-Atom, one right-Atom and one Relation) are added to or removed (deleted) from the Contents of the current Context. While a Transaction is alive (i.e. it exists, and is neither committed to nor cancelled), Pairs to be inserted into the Context are accumulated and Pairs to be removed from the Context are accumulated as well. A subsequent cancel-event will discard the changes and leave the Context unaltered. A subsequent CommitEvent however will modify the Context based on these changes, resulting in a new version of the Context. Note however that since the contents of a Context must be violation-free, a CommitEvent that cannot result in a violation-free Context will act as if it were a cancel-event.-}

transactionContext :: Transaction -> VersionedContext PRAGMA "" " has started on ".
transactionPreContents :: Transaction * Contents PRAGMA "Before " " started, " " was part of the database contents"

RULE oldContents: (I /\ -transactionCommitted /\ -transactionCancelled); transactionContext;object;contents |- transactionPreContents -- dit betekent dat als een andere transactie wordt gecommit terwijl een transactie nog niet is afgesloten, de transactionPreContents van deze transactie onmiddellijk wijzigt!

transactionInserts :: Transaction * Fact PRAGMA "If " " is, or were to be committed to, " " would (have) be(en) inserted".
RULE preInsert:  transactionPreContents~; transactionInserts |- -isElementOf[Fact*VersionedContext]~ PHRASE "Before the transaction is committed to, tuples that are to be inserted do not yet exist in the database."
RULE postInsert: post[CommitEvent*Contents]~; transactionCommit~; transactionInserts |-  isElementOf[Fact*VersionedContext]~ PHRASE "After the transaction is committed to, tuples that are inserted do exist in the database."

transactionDeletes :: Transaction * Fact PRAGMA "If " " is, or were to be committed to, " " would (have) be(en) deleted". 
RULE preDelete:  transactionPreContents~; transactionDeletes |-  isElementOf[Fact*VersionedContext]~ PHRASE "Before the transaction is committed to, tuples that are to be deleted must exist in the database."
RULE postDelete: post[CommitEvent*Contents]~; transactionCommit~; transactionDeletes |- -isElementOf[Fact*VersionedContext]~ PHRASE "After the transaction is committed to, tuples that have been deleted no longer exist in the database."

RULE newContents: transactionCommitted;(transactionInserts \/ (transactionCommit; pre[CommitEvent*Contents]; isElementOf[Fact*VersionedContext]~ /\ -transactionDeletes)) |- transactionCommit; post[CommitEvent*Contents]; isElementOf[Fact*VersionedContext]~ PHRASE "After a trasaction is committed, the database contents consists of the old database contents with appropriate insertions and deletions."

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