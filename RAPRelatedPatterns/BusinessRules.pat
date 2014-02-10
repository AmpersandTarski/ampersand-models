PATTERN BusinessRules --!EXTENDS Businessfunctions
-- Author(s) rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication
PURPOSE PATTERN BusinessRules IN ENGLISH
{+Business Rules are meant for communication with stakeholders in the business [ROSS2003]_, i.e. for communication with humans. This pattern specifies the structure of such business rules as they are used in the business.-}
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`_
-----------------------------------------------------------------------
{- Revision history
RJ/20110220 - "Techneutenweekend-changes", including inclusion of revision history. The English comments are complete.
-}
-----------------------------------------------------------------------
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`__

CONCEPT BusinessRule "a verifiable statement that is committed to by a business function (manager), and as such represents an obligation of the BusinessFunction, namely in making the statement become or remain 'true'."
PURPOSE CONCEPT BusinessRule IN ENGLISH 
{+BusinessRules exist within a BusinessFunction to distinguish compliant (wanted) situations from non-compliant (unwanted) situations and consequently have a single meaning (intension). Every BusinessRule is represented by a single natural language statement that we assume adequately expresses the intension (meaning) of the BusinessRule within its BusinessFunction. While statements may be formulated ambiguously, the BusinessRule itself is considered to have a single meaning (intension), which the BFManager is considedered to have decided (implicitly or explicitly). Therefore, it may or may not be possible for third parties to assess the meaning of a BusinessRule, or to evaluate a BusinessRule (i.e. determine wether or not it is complied with). It may or may not be possible to convey the meaning of a BusinessRule outside the scope.-}

intensionAuthority :: BusinessRule -> BusinessFunction PRAGMA "The authority for the intension (meaning) associated with " " is (the manager of) " -- this relation used to be called 'ruleScope'
PURPOSE RELATION intensionAuthority[BusinessRule*BusinessFunction] IN ENGLISH
{+Every rule has a distinct meaning and purpose. This meaning (purpose, intension) is assigned within a specific BusinessFunction (and the BFManager is accountable for this meaning). The consequence of this should be that the rule should only be evaluated using data that is meaningful within this BusinessFunction.-}
PURPOSE RELATION intensionAuthority[BusinessRule*BusinessFunction] IN DUTCH
{+Elke regel heeft een specifiek doel en betekenis. Deze betekenis c.q. dit doel is toegekend binnen een zekere bedrijfsfunctie. Dit houdt in dat evaluatie van deze regel alleen plaats mag vinden met gegevens die binnen dezelfde bedrijfsfunctie betekenisvol zijn.-}

ruleText :: BusinessRule -> Text PRAGMA "" " is expressed in natural language as ".
PURPOSE RELATION ruleText IN ENGLISH 
{+BusinessRules can be expressed in a natural language in an attempt to convey their meaning to stakeholders that may discuss them. The manager of the BusinessFunction for which this statement represents a rule is the ultimate authority with respect to the meaning of the rule. Inother words: if you want to know the meaning (implications) of a rule, ask the BFManager.-}
PURPOSE RELATION ruleText IN DUTCH
{+BusinessRules zijn uitgedrukt in een natuurlijke taal zodat belanghebbenden erover kunnen discussieren. De BFManager is de uiteindelijke autoriteit met betrekking tot de betekenis van elke regel van de betreffende bedrijfsfunctie. In andere woorden: wie de betekenis van een regel wil weten kan dat het best aan de BFManager vragen.-}

RULE "ruleKey": I[BusinessRule] = ruleText;ruleText~ /\ intensionAuthority[BusinessRule*BusinessFunction]; intensionAuthority[BusinessRule*BusinessFunction]~
PURPOSE RULE "ruleKey" IN ENGLISH
{+Every rule is uniquely characterized by its BusinessFunction and its natural language expression.-}
PURPOSE RULE "ruleKey" IN DUTCH
{+Elke regel is uniek gekarakterisserd door diens bedrijfsfunctie en diens natuurlijke taal uitdrukking (tekst).-}

ENDPATTERN
-----------------------------------------------------------------------
PATTERN "Formalized BusinessRules" --!EXTENDS BusinessRules, Expressions
-- Author(s) rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication
PURPOSE PATTERN "Formalized BusinessRules" IN ENGLISH
{+Having a formal representation (e.g. predicate logic or relation algebra) for a BusinessRule allows its meaning to be conveyed to anyone that has mastered this representation. Such people are not only capable of understanding the intension of the BusinessRule, they can also evaluate them to verify whether or not the scope that the BusinessRule is part of, is complied with or not. Also, computers that understand the formalism are capable of evaluating such BusinessRules and use them to decide whether or not to execute actions, or to log any violations of such rules.-}

CONCEPT Rule "a BusinessRule associated with a formal representation that upon evaluation results in either 'TRUE' or 'FALSE'"
PURPOSE CONCEPT Rule IN ENGLISH 
{+Rules are (specializations of) BusinessRules that are associated with a single formal expression, using e.g. relation algebra or predicate logic. This formal expression defines the rule's intension (meaning). Rules allow meaning to be conveyed to third parties that are proficient with the formalism. Hence, such parties may assess the meaning of Rules and evaluate them. Consequently, the meaning of the rule may be conveyed to outside the scope.-}
GEN Rule ISA BusinessRule

formalExpr :: Rule -> Expression PRAGMA "The formal expression of " " is given by ".
PURPOSE RELATION formalExpr IN ENGLISH 
{+BusinessRules can be expressed in a formal langauge such as relation algebra allowing them to be used in automated contexts.-}

RULE "formal rule uniqueness": formalExpr; formalExpr~ |- I \/ intensionAuthority[BusinessRule*BusinessFunction]; -I; intensionAuthority[BusinessRule*BusinessFunction]~
PURPOSE RULE "formal rule uniqueness" IN ENGLISH
{+Since the meaning of Rules is formally defined by its (formal) expression, it is important that this meaning is represented to humans (the business) with a single natural language statement. If this were not the case, then this would allow ambiguities in rules, as different rules (having different natural language representations and being assigned to a single BusinessFunction) could have a single formal representation.-}

ENDPATTERN
-----------------------------------------------------------------------