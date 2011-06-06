PATTERN "Agreements" --!EXTENDS BusinessRules, Businessfunctions, Expectations, Obligations
-- Author(s) rieks.joosten@tno.nl; stef.joosten@ou.nl
--!RJ: This pattern is ready for review/publication
PURPOSE PATTERN "Agreements" IN ENGLISH
{+Agreements that (parts of) organizations or individuals may have with others are what makes our economy tick. This pattern shows the relation between the term 'agreement' as we have seen it being used in practice, and the lists of Obligations, Expectations and Conscience what each party has to do.-}

CONCEPT Agreement "a set of obligations and expectations by and between multiple parties."
PURPOSE CONCEPT Agreement IN ENGLISH
{+Parties draw up agreements for several reasons. First, they use it as a 'memory' for what it is that they have committed themselves to with respect to others. Secondly, they need it as a reference in case another party in that agreement does not comply with its commitments. Finally, they use it as part of the evidence before a judge in case of a dispute between parties.-}

basedOn :: Agreement * Reference PRAGMA "" " is based on (content referred to by) ".
PURPOSE RELATION basedOn IN ENGLISH
{+It may be benificial for Agreement parties to be able to refer to laws, documents or other substance that provides purpose, motivations or other underpinnings for the agreement.-}

deReferencer :: Reference -> BusinessFunction PRAGMA "The authoratative substance that " " refers to can be provided by ".
PURPOSE RELATION deReferencer IN ENGLISH
{+Every reference should be linked to at least one party - regardless of whether this is a party in the agreement or not - that is the authority when it comes to the substance that is being referred to. For example, for a law this party would be the government that made and upholds that law.-}

party :: Agreement * BusinessFunction [SUR] PRAGMA "" " has " " as one of the parties committing to the agreement".
PURPOSE RELATION party IN ENGLISH
{+Knowing the parties of an Agreement is necessary in order for them to be held accountable with respect to their commitments.-}

contains :: Agreement * Obligation  PRAGMA "" " contains " 
PURPOSE RELATION contains[Agreement*Obligation] IN ENGLISH
{+Knowing the obligations in that are contained in an Agreement is necessary for the parties to know who is accountable for what.-}

contains :: Agreement * Expectation PRAGMA "" " contains " 
PURPOSE RELATION contains[Agreement*Expectation] IN ENGLISH
{+Knowing the expectations that are contained in an Agreement is necessary in order to establish which parties depend on the commitments of other parties.-}

RULE "agreement parties": contains[Agreement*Obligation];obligationOf \/ contains[Agreement*Expectation];expectationOf |- party
PHRASE "Parties in an agreement are committed to at least one Obligation or Expectation."
PURPOSE RULE "agreement parties" IN ENGLISH
{+Any and all parties that are stakeholders to Rules in an Agreement can be parties to the Agreement. One possibility for being a party is a commitment to fulfill Rules, which then are Obligations for such a party. Another possibility is to express dependency of other parties to make a Rule come true, in which case the Rule is an Expectation for that party. Every party to an agreement thus must have at least one Obligation or one Expectation contained in the agreement.-}

{- **in het techneutenweekend hadden we ook nog:**
geldt :: Agreement -> Context
maar ik weet niet goed wat ik daarmee aan moet. De intensie hiervan kan zijn dat (alle regels die onderdeel uitmaken van) de Afspraak in de betreffende Context zouden moeten worden nageleefd, maar dat zou dan inhouden (gezien de functionaliteit van 'geldt') dat de Afspraak alleen maar Obligations van 1 enkele bedrijfsfunctie zou kunnen bevatten, of dat alle bedrijfsfuncties die partij zijn bij een Afspraak allemaal in 1 enkele Context zouden moeten zitten; als dat laatste het geval is, vindt ik dat we ook nog moeten modelleren welke Contexten van deze meerdere bedrijfsfuncties dan allemaal onder de Afspraak zouden moeten vallen. Dat zou er in ieder geval voor zorgen dat de univalentie van de relatie 'geldt' zou moeten worden opgegeven.
-}

CONCEPT ProofOfAgreement "an Object, e.g. a document, whose Contents is considered to prove the existence and validity of an Agreement."
PURPOSE CONCEPT ProofOfAgreement IN ENGLISH
{+In order to hold a party accountable for the Obligations it has committed to in an Agreement, it must be possible to prove the existence and validity of Agreements and the Obligations contained therein. Such proofs are collectively referred to as 'ProofOfAgreement's.-}
--? GEN ProofOfAgreement ISA Object

provesTheExistenceOf :: ProofOfAgreement * Agreement PRAGMA "" " proves the existence of "
PURPOSE RELATION provesTheExistenceOf IN ENGLISH
{+In order to hold a party accountable for the Obligations it has committed to in an Agreement, it is important to be able to prove the existence and validity of this Agreement and the Obligations contained therein.-}

isIssuedBy :: ProofOfAgreement * BusinessFunction PRAGMA "" " is committed to by ".
PURPOSE RELATION isIssuedBy IN ENGLISH
{+Since proofs can be forged, it is important to know which party can vouch for the authenticity of the proof.-}

ENDPATTERN
---------------------------------------------------------------------
