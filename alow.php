<?php

$ips = array(

    '127.0.0.1'
    
);

function allow_this(){
    
    global $ips;
    
    if(in_array($_SERVER['REMOTE_ADDR'],$ips)){
        return TRUE;
    }
    
    return FALSE;
}