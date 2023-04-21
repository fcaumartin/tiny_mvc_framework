<?php
// very tiny poor framework

require "config.php";

/****************************************************
 * cutting of url
 ****************************************************/
$url = array();

if (preg_match("/\/index.php\/([^\/]+)\/([^\/]+)(.*)/", $_SERVER["PHP_SELF"], $url)) {
    $controller = ucwords($url[1]);
    $method = strtolower($url[2]);
    $param =  strtolower($url[3]);
    $params =  array_filter(explode("/", $param));
} else {
    $controller = ucwords($config["default_controller"]);
    $method = "index";
    $params = array();
}

/****************************************************
 * call the controler
 ****************************************************/
require "controllers/" . $controller . ".php";
$c = new $controller;
call_user_func_array(array($c, $method), $params);


/****************************************************
 * Helpers Library
 ****************************************************/

function url($u)
{
    global $config;
    return $config["url"] . "index.php/" . $u;
}

function asset($u)
{
    global $config;
    return $config["url"] . $u;
}


/****************************************************
 * Base class Controller
 ****************************************************/


abstract class Controller
{
    protected $db;
    protected $session;

    public function __construct()
    {
        global $config;

        $this->db = new DB($config["db_host"], $config["db_name"], $config["db_user"], $config["db_password"]);
        $this->session = new Session();
    }

    public function load($view, $data = array())
    {
        extract($data);
        require "vues/" . $view . ".php";
    }

    public function post($v = null)
    {
        if ($v) {
            return $_POST["$v"];
        } else {
            return $_POST;
        }
    }

    public function is_post()
    {
        return $_SERVER["REQUEST_METHOD"]=="POST";
    }

    public function redirect($u)
    {
        header("Location: " . $u);
        exit;
    }
}

class DB
{
    private $_db;

    public function __construct($h, $n, $u, $p)
    {
        $this->_db = new PDO('mysql:host='.$h.';dbname=' . $n, $u, $p);
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function result()
    {
        $params =  func_get_args();
        $req = array_shift($params);

        $requete = $this->_db->prepare($req);
        $requete->execute($params);
    
        return $requete->fetchALL(PDO::FETCH_OBJ);
    }

    public function row()
    {
        $params =  func_get_args();
        $req = array_shift($params);

        $requete = $this->_db->prepare($req);
        $requete->execute($params);
    
        return $requete->fetch(PDO::FETCH_OBJ);
    }

    public function query()
    {
        $params =  func_get_args();
        $req = array_shift($params);

        $requete = $this->_db->prepare($req);
        $requete->execute($params);
    }

    public function insert($table, $fields)
    {
        $req = "insert into $table (" . join(",", array_keys($fields)) . ") values (" . join(",", array_fill(0, count($fields), "?")) . ");";
        
        $requete = $this->_db->prepare($req);
        $requete->execute(array_values($fields));
    }

    public function update($table, $fields, $key_name, $key_value)
    {
        $req = "update $table set ";
        $fields_value = array();
        foreach ($fields as $k => $v) {
            array_push($fields_value, "$k=?");
        }
        $req .= join(",", $fields_value) . "where $key_name = ?";
        $requete = $this->_db->prepare($req);
        $requete->execute(array_merge(array_values($fields), array($key_value)));
    }

    public function delete($table, $key_name, $key_value)
    {
        $req = "delete from  $table where " . $key_name ."=? ";
        
        $requete = $this->_db->prepare($req);
        $requete->execute(array($key_value));
    }
}

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function __get($property)
    {
        if (isset($_SESSION[$property])) {
            return $_SESSION[$property];
        }
        return null;
    }
    
    public function __set($property, $value)
    {
        $_SESSION[$property] = $value;
    }
}
