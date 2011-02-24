PATTERN Sets
 elem :: Atom * Set PRAGMA "atom " " is an element of set ".
 subset :: Set * Set [RFX,ASY] PRAGMA "set " " is a subset of ".
RULE "set elements": elem;subset* |- elem
  PHRASE "A characteristic property of sets: An element that belongs to a set s belongs to all sets of which s is a subset."
ENDPATTERN
