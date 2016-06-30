<?php
global $connection;
if(isset($connection))
	mysqli_close($connection);
?>