			<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
				<a class="navbar-brand" href="/home.php">My Boy Dino</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="/bestof.php">Best in Show</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/videos.php">Videos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/pictures.php">Pictures</a>
						</li>
					</ul>

					<!-- TODO: probably should redo this, crazy colors, what the F is "mt-md-0"?? -->

					<form class="form-inline mt-2 mt-md-0" action='search.php' method='POST'>
						<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name='search_for'>
						<button class="btn my-2 my-sm-0" type="submit">Search</button>
					</form>
				</div>
			</nav>
