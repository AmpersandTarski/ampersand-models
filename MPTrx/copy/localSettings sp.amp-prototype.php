<?php
// default settings are listed at "C:\Ampersand\Git\ampersand\static\zwolle\src\defaultSettings.php"
use Ampersand\Log\Logger;
use Ampersand\Log\NotificationHandler;
use Ampersand\Config;

define ('LOCALSETTINGS_VERSION', 1.5);
// set_time_limit ( 180 );

date_default_timezone_set('Europe/Amsterdam');

/**************************************************************************************************
 * LOGGING functionality
 *************************************************************************************************/
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", true);
Config::set('debugMode', 'global', true); // default = false

// Log file handler
$fileHandler = new \Monolog\Handler\RotatingFileHandler(__DIR__ . '/log/error.log', 0, \Monolog\Logger::WARNING);
//$fileHandler->pushProcessor(new \Monolog\Processor\WebProcessor()); // Adds IP adres and url info to log records
Logger::registerGenericHandler($fileHandler);

if(Config::get('debugMode')){
    $fileHandler = new \Monolog\Handler\RotatingFileHandler(__DIR__ . '/log/debug.log', 0, \Monolog\Logger::DEBUG);
    Logger::registerGenericHandler($fileHandler);
    
    // Browsers debuggers
    //$browserHandler = new \Monolog\Handler\ChromePHPHandler(\Monolog\Logger::DEBUG); // Log handler for Google Chrome
    //$browserHandler = new \Monolog\Handler\FirePHPHandler(\Monolog\Logger::DEBUG); // Log handler for Firebug in Mozilla Firefox
    //Logger::registerGenericHandler($browserHandler);
}

$execEngineHandler = new \Monolog\Handler\RotatingFileHandler(__DIR__ . '/log/execengine.log', 0, \Monolog\Logger::INFO);
Logger::registerHandlerForChannel('EXECENGINE', $execEngineHandler);

// User log handler
Logger::registerHandlerForChannel('USERLOG', new NotificationHandler(\Monolog\Logger::INFO));

/**************************************************************************************************
 * SERVER settings
 *************************************************************************************************/
Config::set('serverURL', 'global', 'http://sp.amp-prototype.nl'); // defaults to http://localhost/<ampersand context name>
// Config::set('apiPath', 'global', '/api/v1'); // relative path to apiConfig::set('productionEnv', 'global', false); // Set to 'true' to disable the database-reinstall.

/**************************************************************************************************
 * Manually added API functionality
 *************************************************************************************************/
//$GLOBALS['api']['files'][] = __DIR__ . '/extensions/SPRegAPI/SPRegAPI.php';

/**************************************************************************************************
 * DATABASE settings
 *************************************************************************************************/
Config::set('dbName', 'mysqlDatabase', 'ampprototypesp');
Config::set('dbUser', 'mysqlDatabase', 'spsp');
Config::set('dbPassword', 'mysqlDatabase', 'Ly35L1kNArcPPkFz');

/**************************************************************************************************
 * LOGIN FUNCTIONALITY
 * 
 * The login functionality requires the ampersand SIAM module
 * The module can be downloaded at: https://github.com/AmpersandTarski/ampersand-models/tree/master/SIAM
 * Copy and rename the SIAM_Module-example.adl into SIAM_Module.adl
 * Include this file into your project
 * Uncomment the config setting below
 *************************************************************************************************/
Config::set('loginEnabled', 'global', true);

/**************************************************************************************************
 * EXTENSIONS
 *************************************************************************************************/
require_once(__DIR__ . '/extensions/ExecEngine/ExecEngine.php'); // Enable ExecEngine
	Config::set('autoRerun', 'execEngine', true);
	Config::set('maxRunCount', 'execEngine', 10);
	Config::set('allowedRolesForRunFunction','execEngine', []); // Role(s) for accounts that are allowed to run the ExecEngine from the menu

require_once(__DIR__ . '/extensions/ExcelImport/ExcelImport.php'); // Enable ExcelImport
	Config::set('allowedRolesForExcelImport','excelImport', ['ExcelImporter']); // Role(s) for accounts that are allowed to import excel files.
?>