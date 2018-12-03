<?php
include('config.php');

include('functions.php');

$action = $_GET['action'];

$gameid = get('gameid');


$game = null;

$game_genres = array();

if(!empty($gameid)) {
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
	$game_genres_associative = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($game_genres_associative as $genre) {
		$game_genres[] = $genre['genreid'];
	}
}

$sql = file_get_contents('sql/getGenres.sql');
$statement = $database->prepare($sql);
$statement->execute();
$genres = $statement->fetchAll(PDO::FETCH_ASSOC); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$gameid = $_POST['gameid'];
	$title = $_POST['game-title'];
	$game_genres = $_POST['game-genre'];
	$publisher = $_POST['game-publisher'];
	$price = $_POST['game-price'];
	
	if($action == 'add') {
		$sql = file_get_contents('sql/insertGame.sql');
		$params = array(
			'gameid' => $gameid,
			'title' => $title,
			'publisher' => $publisher,
			'price' => $price
		);
	
		$statement = $database->prepare($sql);
		$statement->execute($params);
		
		$sql = file_get_contents('sql/insertGameGenre.sql');
		$statement = $database->prepare($sql);
		
		foreach($game_genres as $genre) {
			$params = array(
				'gameid' => $gameid,
				'genreid' => $genre
			);
			$statement->execute($params);
		}
		header('location: admin.php');
	}
	
	elseif ($action == 'edit') {
		$sql = file_get_contents('sql/updateGame.sql');
        $params = array( 
            'gameid' => $gameid,
            'title' => $title,
            'publisher' => $publisher,
            'price' => $price
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
        
        $sql = file_get_contents('sql/removeGenres.sql');
        $params = array(
            'gameid' => $gameid
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
        
        $sql = file_get_contents('sql/insertGameGenre.sql');
        $statement = $database->prepare($sql);
        
        foreach($game_genres as $genre) {
            $params = array(
                'gameid' => $gameid,
                'genreid' => $genre
            );
            $statement->execute($params);
        };	
		header('location: index.php');
	}
	
}

// In the HTML, if an edit form:
	// Populate textboxes with current data of book selected 
	// Print the checkbox with the book's current categories already checked (selected)
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Manage Game</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="publisher" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Manage Game</h1>
		<form action="" method="POST">
		<div class="form-element">
				<label>GameID:</label>
				<?php if($action == 'add') : ?>
					<input type="text" name="gameid" class="textbox" value="<?php echo $game['gameid'] ?>" />
				<?php else : ?>
					<input readonly type="text" name="gameid" class="textbox" value="<?php echo $game['gameid'] ?>" />
				<?php endif; ?>
			</div>
			<div class="form-element">
				<label>Title:</label>
				<input type="text" name="game-title" class="textbox" value="<?php echo $game['title'] ?>" />
			</div>
			<div class="form-element">
				<label>Genre:</label>
				<?php foreach($genres as $genre) : ?>
					<?php if(in_array($genre['genreid'], $game_genres)) : ?>
						<input checked class="radio" type="checkbox" name="game-genre[]" value="<?php echo $genre['genreid'] ?>" /><span class="radio-label"><?php echo $genre['name'] ?></span><br />
					<?php else : ?>
						<input class="radio" type="checkbox" name="game-genre[]" value="<?php echo $genre['genreid'] ?>" /><span class="radio-label"><?php echo $genre['name'] ?></span><br />
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div class="form-element">
				<label>Publisher</label>
				<input type="text" name="game-publisher" class="textbox" value="<?php echo $game['publisher'] ?>" />
			</div>
			<div class="form-element">
				<label>Price:</label>
				<input type="number" step="any" name="game-price" class="textbox" value="<?php echo $game['price'] ?>" />
			</div>
			<div class="form-element">
				<input type="submit" class="button" />&nbsp;
				<input type="reset" class="button" />
			</div>
		</form>
	</div>
</body>
</html>