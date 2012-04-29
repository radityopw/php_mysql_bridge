<?php 

$debug = false;

include 'alow.php';

include 'conn/conn.php';

if(!allow_this()){
    
    if($debug){
            
        $log = getdate();
        $log['message'] = "not authorized ip access ".$_SERVER['REMOTE_ADDR'];

        file_put_contents("error.log", print_r($log,true),FILE_APPEND);

    }
    
    throw new SoapFault("RQ-0","not allowed");
}

function run_query($type,$q){
    
    global $CON;
    global $debug;
    
    if(!isset($CON[$type])){
        
        if($debug){
            
            $log = getdate();
            $log['message'] = "There is No Connection For ".$type;
            
            file_put_contents("error.log", print_r($log,true),FILE_APPEND);
            
        }
        
        throw new SoapFault("RQ-1","There is No Connection For ".$type);
        
        
    }
            
    $con = mysql_connect($CON[$type]['host'], $CON[$type]['user'], $CON[$type]['pass']);
    
    mysql_select_db($CON[$type]['db'],$con);
    
    if($error = mysql_error($con)){
        
        if($debug){
            $log = getdate();
            $log['message'] = $error;
            
            file_put_contents("error.log", print_r($log,true),FILE_APPEND);
        }
        
        throw new SoapFault("RQ-2",$error);
        
    }
    
        
    $sql = base64_decode($q);
    
    if($debug){
        
        $log = getdate();
        $log['message'] = $sql;
    
        file_put_contents("sql.log", print_r($log,true),FILE_APPEND);
        
    }
    
    $res = mysql_query($sql,$con);
    
    if($error = mysql_error($con)){
        
        if($debug){
            $log = getdate();
            $log['message'] = $error;
            
            file_put_contents("error.log", print_r($log,true),FILE_APPEND);
        }
        
        throw new SoapFault("RQ-3",$error);
        
    }
    
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