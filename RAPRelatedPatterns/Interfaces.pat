
PATTERN Interfaces --!EXTENDS Relations
 aut      :: Declaration * Interface PRAGMA "declaration " " is computed automatically in interface ".
 to       :: Trigger * Declaration   PRAGMA "trigger " " changes declaration ".
 from     :: Trigger * Declaration   PRAGMA "trigger " " uses declaration ".
 restores :: Trigger * Fragment    PRAGMA "trigger " " resolves violations of fragment ".
 in       :: Fragment * Rule       PRAGMA "fragment " " is a fragment of rule ".
 maintain :: Interface * Rule      PRAGMA "interface " " maintains rule ".
 aut = to~;restores;in;maintain~ --COMPUTING aut
 MEANING "The rules that are maintained by an interface determine which relations can be computed automatically. If there is a trigger to compute that relation, which originates from a maintained rule, it is treated as an automated relation within that interface. (In the interface, this relation cannot be edited by the user)"
 to       :: Interface * Declaration PRAGMA "interface " " changes declaration ".
 from     :: Interface * Declaration PRAGMA "interface " " uses declaration ".
 to = maintain#;in~ --COMPUTING to
 MEANING "If a rule is not maintained by an interface, a violation might occur that survives a session. That violation must be 'caught' and resolved in another session. By the way, this other session has a different interface, because it differs in at least one rule to be maintained."
 from = maintain;in~ /\ aut#~
 MEANING "All non-automated relations involved in maintained rules are triggers for this interface."
ENDPATTERN
