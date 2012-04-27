<?php 

$debug = false;

include 'alow.php';

include 'conn/conn.php';

if(!allow_this()){
    die();
}

function run_query($type,$q){
    
    global $CON;
    global $debug;
    
    if(!isset($CON[$type])){
        
        throw new SoapFault("RQ-1","There is No Connection For ".$type);
        
        if(!$debug){
            
            $log = getdate();
            $log['message'] = "There is No Connection For ".$type;
            
            file_put_contents("error.log", print_r($log,true),FILE_APPEND);
            
        }
    }
            
    $con = mysql_connect($CON[$type]['host'], $CON[$type]['user'], $CON[$type]['pass']);
    
    mysql_select_db($CON[$type]['db'],$con);
    
        
    $sql = base64_decode($q);
    
    if($debug){
        
        $log = getdate();
        $log['message'] = $sql;
    
        file_put_contents("sql.log", print_r($log,true),FILE_APPEND);
        
    }
    
    $res = mysql_query($sql,$con);
    
    $data = array();
    
    while($row = mysql_fetch_assoc($res)){
        $data[] = $row;
    }
    
    if($debug){
        
        $log = getdate();
        $log['message'] = $data;
        
        file_put_contents("result.log",print_r($log,true),FILE_APPEND);
    
        $log = getdate();
        $log['message'] = mysql_error($con);

        file_put_contents("error.log", print_r($log, true), FILE_APPEND);
        
    }
    
    mysql_close($con);
    
    return $data;
    
}

function test(){
    
    return "halo";
    
}

$server = new SoapServer(null,array('uri' => "http://php_mysql_bridge/"));

$server->addFunction('run_query');

$server->addFunction('test');

$server->handle();