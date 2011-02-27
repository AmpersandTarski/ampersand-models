PATTERN Events -- Author(s) rieks.joosten@tno.nl
--!RJ: This pattern is ready for review
PURPOSE PATTERN Events IN ENGLISH
{+All sorts of events happen all the time, and since events may trigger actions, it is important to be able to talk about them. This pattern provides the basic, most generic terminology for events. Contrary to what dictionaries such as Merriam-Webster state, this pattern assumes that an event takes place at one single point in time. Thus, events that may take longer, even days or months, are not considered events. The reason for this is that it many situations may arise at which it is difficult to say whether or not an event occurred before another one, as events that take place over a period of time may (partly or wholly) overlap.-}

PURPOSE CONCEPT Event IN DUTCH
{+We moeten om verschillende redenen kunnen spreken over gebeurtenissen. Een voorbeeld is om zuiver met historische gegevens om te kunnen gaan: dan moet immers elke verandering die heeft plaatsgevonden herleidbaar zijn tot gebeurtenissen,
die op enig moment in de geschiedenis zijn waargenomen.-}
PURPOSE CONCEPT Event IN ENGLISH
{+For various reasons, we need to be able to talk about events. One example is to properly handle historic data, where every change that has taken place must be tracable to actual events that have occurred at any point in time.-}
CONCEPT Event "something that has happened at one specific point in time." ""

occurredAt  :: Event -> Timestamp PRAGMA "" " took place at a time that was logged as ".
PURPOSE RELATION occurredAt IN ENGLISH
{+Events need to be assigned a time(stamp) so that they can be ordered historically. If events were to be assigned a time interval rather than a specific time, this would introduce all sorts of ordering difficulties. To prevent this, we define events as having taken place at a single point in time.-}

earlierThan :: Timestamp * Timestamp [PROP] PRAGMA "" " represents a point in time earlier than ".
PURPOSE RELATION earlierThan[Timestamp * Timestamp] IN ENGLISH
{+In order to decide which point in time preceeded another point in time, we introduce the relation 'earlierThan'. This allows us one to create an historic ordering of timestamps (points in time).-}

sameTimeAs  :: Event * Event [PROP] PRAGMA "" " took place at the same time as ".
PURPOSE RELATION sameTimeAs[Event * Event] IN ENGLISH
{+In order to decide whether or not events took place concurrently, we introduce the relation 'sameTimeAs'.-}
RULE "sameTime": sameTimeAs = occurredAt;occurredAt~ PHRASE "Events with the same timestamp have occurred at the same time."

earlierThan :: Event * Event [PROP] PRAGMA "" " took place at an earlier time than ".
RULE "earlierEvents": earlierThan[Event*Event]; occurredAt = occurredAt; earlierThan[Timestamp*Timestamp] PHRASE "An event whose timestamp represents a point in time earlier than the timestamp of another event, took place earlier than the latter."

ENDPATTERN