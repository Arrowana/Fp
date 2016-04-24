<! DOCTYPE html >
<html>
	<head>
		<meta charset ="utf-8" />
		<link rel="stylesheet" href ="Content/style.css" />
		<title>Arowana - Short story alpha </title>
	</head >
	
	<body>
		
		<header>
			<div id="main_header">
				<div onclick="location.href='index.php';" style="cursor:pointer;" id="head_title">
					<h1 class="motherh">Librarizer</h1>
					<p>Free library for readers and writers</p>
				</div>
				<div id="why">
					<ul>
						<li><p>Free</p></li>
						<li><p>Remunerating writers</p></li>
						<li><p>Share</p></li>
					</ul>
				</div>
			</div>
		</header>

		<div id="bloc_page">
				<div id="nav">
					<ul>
						<li><a href="index.php?controller=browser">Stories</a></li>
						<li><a href="index.php?controller=news">News Feed</a></li>
						<li><a href="#">Shelf</a></li>
						<li><a href="#">Register</a></li>
						<li><a href="#">Contact</a></li>
					</ul>
				</div>
			<section>		
				<article>
					<?= $page_content ?>
				</article>
			
				<aside>
					<div id="liner">
						<div id="search_tool">
							<form action="index.php?controller=browser&action=search" method="post">
								<p>Search : <input type="text" name="keyword"></p>
							</form>
						</div>
						
						<?= $logger ?>

					</div>
					
					<nav>
						<ul>
							<li>Accueil</li>
							<li>Search</li>
							<li>What's new?</li>
							<li>Librarizer selection</li>
							<li>Register</li>
							<li><a href="admin.php">Administrator</a></li>
							<li>Contact</li>
						</ul>
					</nav>
					
					<nav>
						<div id="ad">
						</div>
					</nav>
				</aside>
			</section>
			
			<footer>
				<h2 id="contact"></h2>
			</footer>
		</div>
	</body>
	

</html>
