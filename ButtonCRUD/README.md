# ButtonCRUD

The `ButtonCRUD` application (particularly, file `XXXX_ButtonCRUD.adl`) serves a number of purposes:

- it is suitable to be used for teaching Ampersand, as it includes
  - nice expressions, e.g. to determine whether there is precisely 1, precisely 2, or more than 2 atoms in a concept.
  - [please expand here]
- it serves as a template for creating, editing, selecting and deleting objects, where the control flow is governed by buttons in the user interface and buttons.

## Intended use

The original idea was to create a template - which is the file `XXXX_ButtonCRUD.adl`, that you can copy into your own project. After a bit of renaming (i.e. `XXXX`, `xxx` and `XX` would typically need to be renamed), you are left with a script that can be INCLUDEd in your own project, and that will provide you with UI-facilities that you thus need not program yourselves. The price you pay for this is that you need to create some rules and other stuff, all of which is documented in the comment at the top of the file. The file `XXXX.adl` shows how this can be done for a simple object that only has a name.

## Running the demo

You can test the stuff by

- creating a prototype from the file `ButtonCRUD.adl`;
- installing the database;
- exercising the application.

The application contains two major interfaces: `TestPortal` and `XXXXPortal`.

The interface `XXXXPortal` shows what it is all about:

- it shows nothing if the session has no rights to create and no rights to select XXXX-objects
- if there are objects to be selected (or they can be created), the interface provides functionalities for
  - creating objects, and editing them until they are 'clean';
  - selecting objects on which to focus, e.g. for editing;
  - editing the selected object;
  - deleting the selected object.
  The flow of events is controlled by clicking on buttons.
  These buttons (dis)appear automatically, depending on the rights that are available in the session context.

The context that `XXXXPortal` functions in, would in practice be set by your own application.
We 'emulate' that application using the interface `TestPortal`, which allows you to specify

- whether or not the session has the right to create XXXX-objects
- the session-privileges on existing objects, i.e. for (S)electing, (U)pdating or (D)eleting each of them.

The `TestPortal` interface also shows the sessioncontext itself, e.g. the XXXX object that is selected, and some debugging info, such as the session-id for the session of which the context is being managed, and the last interface to which automated NavTo-functionality was used.
