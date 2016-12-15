<?
$pasta = '/home/betabit/www/m1';
chdir($pasta);
$x = file_get_contents('wh/flag.txt');
if (trim($x) == '1')
{
    shell_exec("git pull");
    file_put_contents('wh/flag.txt', '0');
}


?>