<?php
/**
 * Created by PhpStorm.
 * User: Long Sheng
 * Date: 12/1/2020
 * Time: 11:09 PM
 */
if(!function_exists('mysql_connect')){
    GLOBAL $connection;

    function mysql_connect($host , $username , $password){
        GLOBAL $connection;
        $connection = mysqli_connect($host , $username , $password);
        return $connection;
    }
    function mysql_close(){
        GLOBAL $connection;
        mysqli_close($connection);
        
    }
    function mysql_select_db($database){
        GLOBAL $connection;
        return mysqli_select_db($connection , $database);
    }

    function mysql_multi_query($query){
        GLOBAL $connection;
        return mysqli_multi_query($connection , $query);
    }
    function mysql_query($query){
        GLOBAL $connection;
        return mysqli_query($connection , $query);
    }
    function mysql_real_escape_string($string){
        GLOBAL $connection;
        return mysqli_real_escape_string($connection , $string);
    }

    function mysql_num_rows($result){
        return mysqli_num_rows($result);
    }

    function mysql_fetch_row($result){
        return mysqli_fetch_row($result);
    }

    function mysql_fetch_assoc($result){
        return mysqli_fetch_assoc($result);
    }

    function mysql_fetch_array($result){
        return mysqli_fetch_array($result);
    }
    function mysql_free_result($result){
        return mysqli_free_result($result);
    }
    function mysql_error(){
        return mysqli_error();
    }
}
