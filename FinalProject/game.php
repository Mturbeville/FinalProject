<?php

include('config.php');

include('functions.php');

$gameid = get('gameid');


$sql = file_get_contents('sql/getGame.sql');
$params = array(
	'gameid' => $gameid
);
$statement = $database->prepare($sql);
$statement->execute($params);
$games = $statement->fetchAll(PDO::FETCH_ASSOC);

$game = $games[0];

$sql = file_get_contents('sql/getGameGenres.sql');
$params = array(
	'gameid' => $gameid
);
$statement = $database->prepare($sql);
$statement->execute($params);
$genres = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Game</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1><?php echo $game['title'] ?></h1>
		<p>
			<?php echo $game['publisher']; ?><br />
			<?php echo $game['price']; ?><br />
		</p>
		
		<ul>
			<?php foreach($genres as $genre) : ?>
				<li><?php echo $genre['name'] ?></li>
			<?php endforeach; ?>
		</ul>
		
	</div>
</body>
</html>