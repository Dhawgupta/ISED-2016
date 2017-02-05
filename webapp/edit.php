<?php

error_reporting(E_ALL);
ini_set('display_errors', True);


include 'database.php';
if(isset($_POST['cont'])) {

	$conn = new mysqli($host,$user,$pass,$database);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$content = mysqli_real_escape_string($conn,$_POST['content']);
	$cont = mysqli_real_escape_string($conn,$_POST['cont']);
	$remaining = file_get_contents("sensordata/".$cont.".txt");

	$sql = "CREATE TABLE IF NOT EXISTS `$cont` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` varchar(40) NOT NULL,
  `remaining` int(11) NOT NULL,
  `filled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	if ($conn->query($sql) === TRUE) {
	    echo "Record updated successfully";
	} else {
	    echo "Error updating record: " . $conn->error;
	}

	$sql = "ALTER TABLE `$cont` ADD PRIMARY KEY (`timestamp`), ADD UNIQUE KEY `timestamp` (`timestamp`);";
	if ($conn->query($sql) === TRUE) {
	    echo "Record updated successfully";
	} else {
	    echo "Error updating record: " . $conn->error;
	}

	$sql = "DELETE FROM `$cont` WHERE 1;";
	if ($conn->query($sql) === TRUE) {
	    echo "Record updated successfully";
	} else {
	    echo "Error updating record: " . $conn->error;
	}

	$sql = "INSERT INTO `$database`.`$cont` (`timestamp`, `content`, `remaining`, `filled`) VALUES (NULL, '$content', '$remaining', true);";
	if ($conn->query($sql) === TRUE) {
	    echo "Record updated successfully";
		header('Location:index.php');
	} else {
	    echo "Error updating record: " . $conn->error;
	}

	
}
else{
$cont = $_GET['cont'];
if(isset($_GET['content'])){
	$content = $_GET['content'];
	echo "If you perform this action, all the previous data of what was filled in the container would be cleared and the content inside shall be updated.";
}
else
	$content = "";

?>
<form name="edit" action="edit.php" method="post">

<select name="content">
<?php
				$con=mysqli_connect($host,$user,$pass,"smartcontainers_nutrition");
				if (mysqli_connect_errno()){
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}

				$sql="SHOW TABLES FROM `smartcontainers_nutrition`";
				$result=mysqli_query($con,$sql);

				while ($row=mysqli_fetch_array($result,MYSQLI_NUM)) {
?>
<option value="<?php echo $row[0] ?>"><?php echo $row[0] ?></option>
<?php
				}
?>
</select>

<input name="cont" type="hidden" value="<?php echo $cont ?>" /> <input type="submit" name="submit" value="Submit" />
</form>

<?php
}
?>
