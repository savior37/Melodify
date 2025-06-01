<?php

function page($name)
{
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
    if ($stm) {
        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($result) && count($result) > 0) {
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
    if ($stm) {
        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($result) && count($result) > 0) {
                return $result[0];
            }

        }
    }
    return false;
}

function message($message = '', $clear = false)
{
    if (!empty($message)) {
        $_SESSION['message'] = $message;
    } else {

        if (!empty($_SESSION['message'])) {

            $msg = $_SESSION['message'];
            if ($clear) {
                unset($_SESSION['message']);
            }
            return $msg;
        }
    }
    return false;
}

function redirect($page)
{
    header("Location: " . ROOT . "/" . $page);
    die;
}

function set_value($key, $default = '')
{
    if (!empty($_POST[$key])) {
        return $_POST[$key];
    } else {
        return $default;
    }

    return '';

}

function set_select($key, $value, $default = '')
{
    if (!empty($_POST[$key])) {
        if ($_POST[$key] == $value) {
            return " selected ";
        }
    } else {
        if ($default == $value)
            return " selected ";
    }
    return '';
}

function get_date($date)
{
    return date("jS M, Y", strtotime($date));
}

function logged_in()
{

    if (!empty($_SESSION['USER']) && is_array($_SESSION['USER'])) {
        return true;
    }

    return false;
}

function is_admin()
{

    if (!empty($_SESSION['USER']['role']) && $_SESSION['USER']['role'] == 'admin') {
        return true;
    }

    return false;
}

function user($column)
{
    if (!empty($_SESSION['USER'][$column])) {
        return $_SESSION['USER'][$column];
    }

    return "Unknown";

}

function authenticate($row)
{
    $_SESSION['USER'] = $row;

}
function str_to_url($url)
{
    $url = str_replace(" ", "", $url);
    $url = preg_replace('~[^\\pL\d]+~u', '-', $url);
    $url = trim($url, " -");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url);

    return $url;
}

function get_category($id)
{
    $query = "select category from categories where id = :id limit 1";
    $row = db_query_one($query, ['id' => $id]);

    if (!empty($row['category'])) {
        return $row['category'];
    }

    return "Unknown";
}

function esc($str)
{
    return htmlspecialchars($str);
}

function get_artist($id)
{
    $query = "select name from artists where id = :id limit 1";
    $row = db_query_one($query, ['id' => $id]);

    if (!empty($row['name'])) {
        return $row['name'];
    }

    return "Unknown";
}
