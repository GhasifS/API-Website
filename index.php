<?php
	require 'steamauth/steamauth.php';
	if (isset($_SESSION['steamid'])) {
		require 'steamauth/userInfo.php';
		$id = $_SESSION['steamid'];
	} else {
		# NOT LOGGED IN 
	}
?>

<?php
// https://codeshack.io/how-to-sort-table-columns-php-mysql/
// Below is optional, remove if you have already connected to your database.
$mysqli = mysqli_connect('sql5.freesqldatabase.com','sql5472210','9GbrlNNHpF','sql5472210','3306');

// For extra protection these are the columns of which the user can sort by (in your database table).
$columns = array('steam','name','value','rank','kills','deaths','shoots','hits','headshots','assists','round_win','round_lose','playtime','lastconnect');

// Only get the column if it exists in the above columns array, if it doesn't exist the database table will be sorted by the first item in the columns array.
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];

// Get the sort order for the column, ascending or descending, default is ascending.
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

// Get the result...
if ($result = $mysqli->query('SELECT * FROM lvl_base ORDER BY ' .  $column . ' ' . $sort_order)) {
	// Some variables we need for the table.
	$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
	$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
	$add_class = ' class="highlight"';
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<title>PHP & MySQL Table Sorting by CodeShack</title>
			<meta charset="utf-8">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
			<style>
			html {
				font-family: Tahoma, Geneva, sans-serif;
				padding: 10px;
			}
			table {
				border-collapse: collapse;
				width: 500px;
			}
			th {
				background-color: #54585d;
				border: 1px solid #54585d;
			}
			th:hover {
				background-color: #64686e;
			}
			th a {
				display: block;
				text-decoration:none;
				padding: 10px;
				color: #ffffff;
				font-weight: bold;
				font-size: 13px;
			}
			th a i {
				margin-left: 5px;
				color: rgba(255,255,255,0.4);
			}
			td {
				padding: 10px;
				color: #636363;
				border: 1px solid #dddfe1;
			}
			tr {
				background-color: #ffffff;
			}
			tr .highlight {
				background-color: #f9fafb;
			}
			</style>
		</head>
		<body>
			<?php
				function toSteamID($id) {
					if (is_numeric($id) && strlen($id) >= 16) {
						$z = bcdiv(bcsub($id, '76561197960265728'), '2');
					} elseif (is_numeric($id)) {
						$z = bcdiv($id, '2'); // Actually new User ID format
					} else {
						return $id; // We have no idea what this is, so just return it.
					}
					$y = bcmod($id, '2');
					return 'STEAM_1:' . $y . ':' . floor($z);
				}
			?>
			<?php if(isset($_SESSION['steamid'])) {?>
				<?php echo logoutbutton(); ?>
				<img src="<?php echo $steamprofile['avatar'];?>"> <b><?php echo $steamprofile['personaname'];?></b>			
			<?php } else { ?>
				<?php echo loginbutton(); ?>
			<?php } ?>
			<?php function toMinutes($num) {
				return $num/60;
			} ?>
			<table>
				<tr>
					<th><a href="index.php?column=steam&order=<?php echo $asc_or_desc; ?>">Steam ID<i class="fas fa-sort<?php echo $column == 'steam' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=name&order=<?php echo $asc_or_desc; ?>">Username<i class="fas fa-sort<?php echo $column == 'name' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=value&order=<?php echo $asc_or_desc; ?>">Points<i class="fas fa-sort<?php echo $column == 'value' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=rank&order=<?php echo $asc_or_desc; ?>">Rank<i class="fas fa-sort<?php echo $column == 'rank' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=kills&order=<?php echo $asc_or_desc; ?>">Kills<i class="fas fa-sort<?php echo $column == 'kills' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=deaths&order=<?php echo $asc_or_desc; ?>">Deaths<i class="fas fa-sort<?php echo $column == 'deaths' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=shoots&order=<?php echo $asc_or_desc; ?>">Shots<i class="fas fa-sort<?php echo $column == 'shoots' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=hits&order=<?php echo $asc_or_desc; ?>">Hits<i class="fas fa-sort<?php echo $column == 'hits' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=headshots&order=<?php echo $asc_or_desc; ?>">Headshots<i class="fas fa-sort<?php echo $column == 'headshots' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=assists&order=<?php echo $asc_or_desc; ?>">Assists<i class="fas fa-sort<?php echo $column == 'assists' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=round_win&order=<?php echo $asc_or_desc; ?>">Rounds Won<i class="fas fa-sort<?php echo $column == 'round_win' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=round_lose&order=<?php echo $asc_or_desc; ?>">Rounds Lost<i class="fas fa-sort<?php echo $column == 'round_lose' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=playtime&order=<?php echo $asc_or_desc; ?>">Playtime<i class="fas fa-sort<?php echo $column == 'playtime' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=lastconnect&order=<?php echo $asc_or_desc; ?>">Last Connection<i class="fas fa-sort<?php echo $column == 'lastconnect' ? '-' . $up_or_down : ''; ?>"></i></a></th>
				</tr>
				<?php while ($row = $result->fetch_assoc()): ?>
				<tr>
					<?php if(isset($_SESSION['steamid'])) {?>
						<?php if (toSteamID($id) == $row['steam']) { ?>
							<td<?php echo $column == 'steam' ? $add_class : ''; ?>><b><?php echo $row['steam']; ?></b></td>
							<td<?php echo $column == 'name' ? $add_class : ''; ?>><b><?php echo $row['name']; ?></b></td>
							<td<?php echo $column == 'value' ? $add_class : ''; ?>><b><?php echo $row['value']; ?></b></td>
							<td<?php echo $column == 'rank' ? $add_class : ''; ?>><b><?php echo $row['rank']; ?></b></td>
							<td<?php echo $column == 'kills' ? $add_class : ''; ?>><b><?php echo $row['kills']; ?></b></td>
							<td<?php echo $column == 'deaths' ? $add_class : ''; ?>><b><?php echo $row['deaths']; ?></b></td>
							<td<?php echo $column == 'shoots' ? $add_class : ''; ?>><b><?php echo $row['shoots']; ?></b></td>
							<td<?php echo $column == 'hits' ? $add_class : ''; ?>><b><?php echo $row['hits']; ?></b></td>
							<td<?php echo $column == 'headshots' ? $add_class : ''; ?>><b><?php echo $row['headshots']; ?></b></td>
							<td<?php echo $column == 'assists' ? $add_class : ''; ?>><b><?php echo $row['assists']; ?></b></td>
							<td<?php echo $column == 'round_win' ? $add_class : ''; ?>><b><?php echo $row['round_win']; ?></b></td>
							<td<?php echo $column == 'round_lose' ? $add_class : ''; ?>><b><?php echo $row['round_lose']; ?></b></td>
							<td<?php echo $column == 'playtime' ? $add_class : ''; ?>><b><?php echo toMinutes($row['playtime']); ?></b></td>
							<td<?php echo $column == 'lastconnect' ? $add_class : ''; ?>><b><?php echo $row['lastconnect']; ?></b></td>
							<?php continue; ?>
						<?php	}	?>
					<?php }	?>
					<td<?php echo $column == 'steam' ? $add_class : ''; ?>><?php echo $row['steam']; ?></td>
					<td<?php echo $column == 'name' ? $add_class : ''; ?>><?php echo $row['name']; ?></td>
					<td<?php echo $column == 'value' ? $add_class : ''; ?>><?php echo $row['value']; ?></td>
					<td<?php echo $column == 'rank' ? $add_class : ''; ?>><?php echo $row['rank']; ?></td>
					<td<?php echo $column == 'kills' ? $add_class : ''; ?>><?php echo $row['kills']; ?></td>
					<td<?php echo $column == 'deaths' ? $add_class : ''; ?>><?php echo $row['deaths']; ?></td>
					<td<?php echo $column == 'shoots' ? $add_class : ''; ?>><?php echo $row['shoots']; ?></td>
					<td<?php echo $column == 'hits' ? $add_class : ''; ?>><?php echo $row['hits']; ?></td>
					<td<?php echo $column == 'headshots' ? $add_class : ''; ?>><?php echo $row['headshots']; ?></td>
					<td<?php echo $column == 'assists' ? $add_class : ''; ?>><?php echo $row['assists']; ?></td>
					<td<?php echo $column == 'round_win' ? $add_class : ''; ?>><?php echo $row['round_win']; ?></td>
					<td<?php echo $column == 'round_lose' ? $add_class : ''; ?>><?php echo $row['round_lose']; ?></td>
					<td<?php echo $column == 'playtime' ? $add_class : ''; ?>><?php echo toMinutes($row['playtime']); ?></td>
					<td<?php echo $column == 'lastconnect' ? $add_class : ''; ?>><?php echo gmdate('r',$row['lastconnect']); ?></td>
				</tr>
				<?php endwhile; ?>
			</table>
		</body>
	</html>
	<?php
	$result->free();
}
?>