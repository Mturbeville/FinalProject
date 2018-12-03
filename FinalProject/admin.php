<?php
// Create and include a configuration file with the database connection
include('config.php');

// Include functions for application
include('functions.php');

// Get search term from URL using the get function
$term = get('search-term');

// Get a list of books using the searchBooks function
// Print the results of search results
// Add a link printed for each book to book.php with an passing the isbn
// Add a link printed for each book to form.php with an action of edit and passing the isbn
$games = searchGames($term, $database);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Welcome Admin</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Welcome Admin</h1>
		<form method="GET">
			<input type="text" name="search-term" placeholder="Search..." />
			<input type="submit" />
		</form>
		<?php foreach($games as $game) : ?>
			<p>
				<?php echo $game['title']; ?><br />
				<?php echo $game['publisher']; ?> <br />
				<?php echo $game['price']; ?> <br />
				<a href="form.php?action=edit&gameid=<?php echo $game['gameid'] ?>">Edit Game</a><br />
				<a href="game.php?gameid=<?php echo $game['gameid'] ?>">View Game</a>
			</p>
		<?php endforeach; ?>
		<a href = "form.php?action=add">Insert New Game</a><br />
		<a href = "logout.php">Admin Logout</a>
		
		<!-- print currently accessed by the current username -->
	</div>
</body>
</html>