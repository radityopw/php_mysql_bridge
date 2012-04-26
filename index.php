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
            
    $con = mysql_connect($CON[$type]['host'], $CON[$type]['user'], $CON[$type]['pass']);
    
    mysql_select_db($CON[$type]['db'],$con);
    
    if($debug){
    
        file_put_contents("conect.log", print_r($CON,true),FILE_APPEND);
    
        file_put_contents("conect1.log", print_r($con,true),FILE_APPEND);
        
    }
    
    $sql = base64_decode($q);
    
    if($debug){
    
        file_put_contents("sql.log", $sql,FILE_APPEND);
        
    }
    
    $res = mysql_query($sql,$con);
    
    $data = array();
    
    while($row = mysql_fetch_assoc($res)){
        $data[] = $row;
    }
    
    if($debug){
        
        file_put_contents("result.log",print_r($data,true),FILE_APPEND);
    
        file_put_contents("error.log",  mysql_error($con),FILE_APPEND);
        
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