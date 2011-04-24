@echo off
rem Syntax: MAKE FSPEC or MAKE PROTO(TYPE) or MAKE GMI
if "%AMPexecmd%"=="" set AMPexecmd=ampersand
if "%1"=="fspec" set AMPexecmd=ampersand
if "%1"=="prototype" set AMPexecmd=prototype
if "%1"=="proto" set AMPexecmd=prototype
if "%1"=="gmi" set AMPexecmd=gmi

call :makeheader

call :addfile Delivery.pat

rem call :addfile  "%OUPathRepository%\Basics.pat"
rem call :addfile  "Basics.pop"

:finishup
call :maketrailer
set AMPFspecFormat=Latex
set AMPFspecLanguage=EN
call generate.bat
goto :EOF

REM -------------------------------------------------------

:makeheader
@echo off
if not "%AMPContext%"=="" echo Creating backup copies
if not "%AMPContext%"=="" xcopy *.* "%AMPathADL%\%AMPContext% (backup)\" /s/e/v/q/y
echo.
if exist "%AMPFile%.adl" del "%AMPFile%.adl"
echo CONTEXT %AMPContext% -- DATE: %DATE%  %TIME%>>"%AMPFile%.adl"
if exist "2DO.txt" call :addfile "2DO.txt"
goto :EOF

:maketrailer
@echo off
echo ENDCONTEXT>>"%AMPFile%.adl"
REM Copy the file to the repository so that we can start compilations
echo.
echo Copying "%AMPFile%.adl" to "%AMPathADL%\"
xcopy "%AMPFile%.adl" "%AMPathADL%\" /y/q
goto :EOF

:addfile
@echo off
if not exist %1 echo.
if not exist %1 echo %1 does not exist
if not exist %1 pause
echo #INCLUDING %1
echo -- (file:  %1 ) -- >>"%AMPFile%.adl"
copy "%AMPFile%.adl"+%1 "%AMPFile%.adl" >nul
:echoline
echo.>>"%AMPFile%.adl"
echo {-===================================================================-}>>"%AMPFile%.adl"
goto :EOF