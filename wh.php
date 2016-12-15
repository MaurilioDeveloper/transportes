<?
$obj = json_decode(file_get_contents("php://input"));

if (isset($obj->push)) {
    file_put_contents('wh/flag.txt', '1');
    //shell_exec("cd /home/betabit/www/imobs/cibraco2 && git pull");
}
?>