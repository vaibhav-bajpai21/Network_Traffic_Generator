<html>
<head>
<script type="text/javascript">
function back()
{
window.location="home.html"
}

</script>
</head>
<?php
exec("killall KILL httpd > /dev/null &");
echo"Packet sending interrupted by user!!!!";
?>

<br>
<br>
<input type="button" value="Back" onclick="back()" />


</body>
</html>

