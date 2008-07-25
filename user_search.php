<?
# Feeder page for AJAX user/group search for the user selection include file.

include "include/db.php";
include "include/authenticate.php";
include "include/general.php";

$find=getvalescaped("autocomplete_parameter","");

?>
<ul>
<?
$users=get_users(0,$find);
for ($n=0;$n<count($users) && $n<=20;$n++)
	{
	$show=true;
	if (checkperm("E") && ($users[$n]["groupref"]!=$usergroup) && ($users[$n]["groupparent"]!=$usergroup) && ($users[$n]["groupref"]!=$usergroupparent)) {$show=false;}
	if ($show)
		{
		?><li><?=$users[$n]["username"]?></li>
		<?
		}
	}
?>
<?
$groups=get_usergroups(true,$find);
for ($n=0;$n<count($groups) && $n<=20;$n++)
	{
	$show=true;
	if (checkperm("E") && ($groups[$n]["ref"]!=$usergroup) && ($groups[$n]["parent"]!=$usergroup) && ($groups[$n]["ref"]!=$usergroupparent)) {$show=false;}
	if ($show)
		{
		$users=get_users($groups[$n]["ref"]);
		$ulist="";
		
		for ($m=0;$m<count($users);$m++) {if ($ulist!="") {$ulist.=", ";};$ulist.=$users[$m]["username"];}
		if ($ulist!="")
			{
			?><li><?=$lang["group"]?>: <?=$groups[$n]["name"]?></option><?
			}
		}
	}
?>
</ul>
