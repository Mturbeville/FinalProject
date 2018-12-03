<?php
include('config.php');

include('functions.php');

$term = get('search-term');

$games = searchGames($term, $database);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Games</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Games</h1>
		<form method="GET">
			<input type="text" name="search-term" placeholder="Search..." />
			<input type="submit" />
		</form>
		<?php foreach($games as $game) : ?>
			<p>
				<?php echo $game['title']; ?><br />
				<?php echo $game['publisher']; ?> <br />
				<?php echo $game['price']; ?> <br />
				<a href="game.php?gameid=<?php echo $game['gameid'] ?>">View Game</a>
			</p>
		<?php endforeach; ?>
		<a href = "login.php">Admin Login</a>
		
	</div>
</body>
</html>