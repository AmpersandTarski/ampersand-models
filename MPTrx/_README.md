# MPTrx README

This application provides an experimentation platform for Multi-Party Transactions (MPTrx's)

Its purpose is to acquaint people with the concepts behind MPTrx's, and provide them with an experience 
that allows them to understand what it takes to perform such transactions at the information/business level.
Also, it may help to integrate SSI-technologies into the business.

## Introduction into Multi-Party Transactions

A Multi-Party Transaction (MPTrx) is an interaction between (Actors representing) different Parties,
for the (1) negotiation, (2) execution and (3) acceptance of exchange of products, services, data, funds, etc.
For details about the structure on transactions, we build on the DEMO theory of Dietz
(https://en.wikipedia.org/wiki/Design_%26_Engineering_Methodology_for_Organizations).
The idea is that Parties, *because* each of which is associated with a unique Knowledge (see SIAMv4 for details),
can do so in a way that is subjectively profitable, while running a risk that is (subjectively) acceptable.

The MPTrx application supports Parties from the point where they start a negotiation up to the point 
where each of them commits to the transaction agreement, which consists of set of Objectives to the realization
of which they express their commitments. The MPTrx application builds on the TText module, using Scopes to
demarcate individual transactions, and TTexts within these scopes for specifying and committing to Objectives. 

An Objective is a TText that is owned by the TTParty that wants it to be satisfied before committing to a transaction
(agreement) or accepting the stated results. The owner specifies its template, using square brackets to indicate 
variables that must be given a value during the negotiations. For example, a TTParty in the role of service provider
may state "The [customer] must pay [subscription fee] that comes with the [subscription]."

The owner may specify 'roles' that other Parties may fulfill. In the above example, "[customer]" would refer to such
a role. Roles can be seen as labeled 'seats' around a virutal negotiation table. They can be added/removed as needed.

Also, the owner specifies the role(s) that must or may provide a value for a specific variable. For example, 
[subscription] must be provided by the customer. The associated [subscription fee] must be provided by the owner
itself (once the customer has decided about the subscription).

Finally, roles, too, act as variables. For example, [customer] is a variable, but also a role. Its value will be 
automatically provided by the subsystem that assings Parties to roles.

To make life easier, a Party may create a template MPTrx, basically specifying 
- the various roles involved;
- TText templates for the objectives that each of them might wish to pursue;
- Further TText templates for detailing such objectives;
- TText templates for the various variables that are mentioned in the (refinements of) these objectives.

Whenever an MPTrx is started for which an appropriate template exists, the template can be copied so that the MPTrx
doesn't start 'clean', but with most of the objectives, roles and variables already in place. The owners of the
various objectives, i.e. the Parties that play the appropriate role, will be able to 'disable' objectives they 
do not pursue, and add others that the template did not provide, so that they can tailor the MPTrx to their needs.