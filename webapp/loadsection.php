<?php
$cont = $_GET['cont'];

error_reporting(E_ALL);
ini_set('display_errors', True);

include 'database.php';
include('phpgraphlib/phpgraphlib.php');

global $db;
try{
	$db = new PDO('mysql:host=localhost;dbname='.$database.';charset=utf8', $user, $pass);//use charset=utf8 here
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch ( PDOException $e ) {
	echo "Database error ".$e->getMessage();
}
?>
<?php
			$query = "SELECT * FROM `$cont`";
			$stmt = $db->prepare($query);
			$rc = $stmt->execute();
			$a = "";
			$i = 0;
			$t = 0;
			$content = "";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$timestamp = strtotime($row['timestamp']);
				$a .= "a[".date("d/m",$timestamp)."]=".$row['remaining']."&";
				if($row['filled']){
					$max = $row['remaining'];
					$i = 0;
				}
				else{
					$ave = ($max - $row['remaining'])/$i;
					$t = $row['remaining']/$ave;
				}
				$i++;
				$content = $row['content'];
			}
 ?>
	<span class="edit">
		<a onclick="loadedit('<?php echo $cont; ?>','<?php echo $content; ?>')">Edit</a>
		<div id="<?php echo $cont.'-load-edit'; ?>" style="display:none"></div>
	</span>
	<img src="graph.php?<?php echo $a ?>"><br>
	Quantity left: <span id="<?php echo $cont; ?>-left">..</span><br>
<?php if(isset($ave)){?>
	Average consumption per day: <?php echo $ave ?> g/day (since last refill)<br>
	You may run out of this in <?php echo $t ?> days.
<?php } ?>

		<script type="text/javascript">
			$(document).ready(function() {

				function functionToLoadFile() {
					jQuery.get('sensordata/<?php echo $cont ?>.txt?t='+Date.now(), function(data) {
						var y = data;
						$('#<?php echo $cont ?>-left').html(y);

						setTimeout(functionToLoadFile, 1000);
					});
				}

				setTimeout(functionToLoadFile, 10);
			});
		</script>
		<script>
		function loadedit(cont, content){
			if($("#"+cont+"-load-edit").is(':visible')){
				$("#"+cont+"-load-edit").hide();      
			}
			else{
				$("#"+cont+"-load-edit").hide().load("edit.php?cont="+cont+"&content="+content).fadeIn('500');
			}
		}
		</script>
