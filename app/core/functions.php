<?php

function page($name) {
    return "../app/pages/" . $name . ".php";
}

function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}
function db_connect()
{
    $string = DBDRIVER . ":hostname=" . DBHOST . ";dbname=" . DBNAME;
    $con = new PDO($string, DBUSER, DBPASS);

    return $con;
}

function db_query($query, $data = array())
{
    $con = db_connect();

    $stm = $con->prepare($query);
    if($stm)
    {
        $check = $stm->execute($data);
        if($check){
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result) && count($result) > 0)

            {
                return $result;
            }
            
        }
    }
    return false;
}

function db_query_one($query, $data = array())
{
    $con = db_connect();

    $stm = $con->prepare($query);
    if($stm)
    {
        $check = $stm->execute($data);
        if($check){
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            
            if(is_array(result)&& count(result)>0)
            {
                return $result[0];
            }
            
        }
    }
    return false;
}

function message($message = '', $clear = false)
{
    if(!empty($message)){
        $_SESSION['message'] = $message;
    } else {

        if(!empty($_SESSION['message'])){

            $msg = $_SESSION['message'];
            if($clear){
                unset($_SESSION['message']);
            }
            return $msg;
        }
    }
    return false;
}

function redirect($page)
{
    header("Location: ".ROOT."/".$page);
    die;
}

function set_value($key)
{
    if(!empty($_POST[$key]))
    {
        return $_POST[$key];
    }

    return '';
}

function set_select($key, $value)
{
    if(!empty($_POST[$key]))
    {
        if($_POST[$key] == $value){        
            return " selected ";
        }
    }

    return '';
}