<?php   

if($_SERVER['SERVER_NAME'] == "localhost")
{

//for local server
define("ROOT", "http://localhost/melodify/public");

define("DBDRIVER", "mysql");
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "music_website_db");

}else{

//for online server
define("ROOT", "http://www.mywebsite.com");

define("DBDRIVER", "mysql");
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "music_website_db");
}
?>