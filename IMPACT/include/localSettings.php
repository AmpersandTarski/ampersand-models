<?php
define ('LOCALSETTINGS_VERSION', 1.2);

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", true);
set_time_limit ( 120 );

Config::set('loginEnabled', 'global', true);

/************ EXTENSIONS ***************/
require_once(__DIR__ . '/extensions/ExecEngine/ExecEngine.php'); // Enable ExecEngine
require_once(__DIR__ . '/extensions/ExcelImport/ExcelImport.php'); // Enable ExcelImport

require_once(__DIR__ . '/extensions/Mqtt/Mqtt.php');
	/*********** MQTT CONFIG ***************/
	Config::set('address', 'MQTT', 'localhost');
	Config::set('port', 'MQTT', 1883);
	Config::set('clientId', 'MQTT', 'ampersand');
	Config::set('user', 'MQTT', null);
	Config::set('pass', 'MQTT', null);
	
	$arrMqttInterfaces = array(
        array('fullRelationSignature' => array('rel_scopeName_Scope_ScopeName', 'rel_scopeDoc_Scope_Documentation')// fullRelationSignature
            ,'srcOrTgt' => 'src'
            ,'ifProp' => 'rel_scopeIsComponent_Scope_Scope' // fullRelationSignature
            ,'ifc' => 'SDMComponent' // I[Scope]
            ,'topic' => 'IMPACT/Component/Update'
            )
        , array('fullRelationSignature' => array('rel_docShort_Documentation_DocSummary', 'rel_docShort_Documentation_DocDescription') // fullRelationSignature
            ,'srcOrTgt' => 'src'
            ,'ifProp' => 'rel_scopeIsComponent_Scope_Scope' // fullRelationSignature
            ,'ifc' => 'UpdatedDocumentation'
            ,'topic' => 'IMPACT/Component/Update'
            )
        , array('fullRelationSignature' => array( 'rel_portName_Port_PortName'
                                                , 'rel_portComponent_Port_Scope'
                                                , 'rel_portIsConst_Port_Port'
                                                , 'rel_portIsInput_Port_Port'
                                                , 'rel_portIsOutput_Port_Port'
                                                , 'rel_portDefValue_Port_ConfigValue'
                                                , 'rel_portType_Port_ConfigType'
                                                //, 'rel_portConfigQstn_Port_ConfigQuestion' // not needed by Siemens model
                                                , 'rel_portMinWires_Port_Integer'
                                                , 'rel_portMaxWires_Port_Integer'
                                                )
            ,'srcOrTgt' => 'src'
            ,'ifProp' => 'rel_scopeIsComponent_Scope_Scope' // fullRelationSignature
            ,'ifc' => 'UpdatedPort' // I[Port]
            ,'topic' => 'IMPACT/Component/Update'
            )         
      );
	//Config::set('arrMqttInterfaces', 'MQTT', $arrMqttInterfaces);

?>
