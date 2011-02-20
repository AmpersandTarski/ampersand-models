PATTERN Events

PURPOSE CONCEPT Event IN DUTCH
{+We moeten om verschillende redenen kunnen spreken over gebeurtenissen. Een voorbeeld is om zuiver met historische gegevens om te kunnen gaan: dan moet immers elke verandering die heeft plaatsgevonden herleidbaar zijn tot gebeurtenissen,
die op enig moment in de geschiedenis zijn waargenomen.
-}
CONCEPT Event "something that has happened at one specific point in time." ""

occurredAt  :: Event -> Timestamp PRAGMA "" " took place at a time that was logged as ".
earlierThan :: Timestamp * Timestamp [PROP] PRAGMA "" " represents a point in time earlier than ".

sameTimeAs  :: Event * Event [PROP] PRAGMA "" " took place at the same time as ".
RULE "sameTime": sameTimeAs = I /\ occurredAt;occurredAt~ PHRASE "Events with the same timestamp have occurred at the same time."

earlierThan :: Event * Event [PROP] PRAGMA "" " took place at an earlier time than ".
RULE "earlierEvents": earlierThan; occurredAt = occurredAt; earlierThan PHRASE "An event whose timestamp represents a point in time earlier than the timestamp of another event, took place earlier than the latter."

ENDPATTERN