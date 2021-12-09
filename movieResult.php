<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css.map">
	
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>MOVIE RESULTS</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-plot-listing.css">
    <link rel="stylesheet" href="assets/css/animated.css">
    <link rel="stylesheet" href="assets/css/owl.css">
	<script>
		function resetForm(){
			document.getElementById("t").value = "";
			document.getElementById("y").value = "";
			document.getElementById("ac").checked  = false;
		}
	</script>
	
  </head>
<body>
  <?php include_once 'searchData.php';

	$title = urlencode($_GET['title']);
	$year = $_GET['year'];	

	if($year == '')
		$year = 'undefined';

	if(!isset($_GET['page']))
		$page = 1;
	else
		$page = $_GET['page'];

	if(isset($_GET['adultCont']))
		$adult = 'true';
	else
		$adult = 'false';
	print_r($json);
	$json = getSearchResult($key, $title, $page, $year, $adult);
?>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="index.php" class="logo">
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
                  
            <a class='menu-trigger'>
                <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <div class="main-banners">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="top-text header-text">
            <h6>Over 36,500+ movies </h6>
            <h2>Find movie by title and year</h2>
          </div>
        </div>
        <div class="col-lg-12">
          
		<form class="form-search" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="well">
              <div class="row">
			  <div class="form-group col-sm-4">
						<div class="input-group">
							<input type="text" id="t" name="title" class="form-control" placeholder="title" value="<?php echo $_GET['title']; ?>" required>
						</div>
					</div>
					<div class="form-group col-sm-2">
						<div class="input-group">
							<input type="number" id="y" name="year" class="form-control" placeholder="year" value="<?php echo $_GET['year']; ?>">
						</div>
					</div>
					<div class="form group col-sm-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" id="ac" name="adultCont" value="1" <?php if(isset($_GET['adultCont'])) echo 'checked'; ?>> Adults Content
							</label>
						</div>
					</div>
					<div class="form-group col-sm-4">

						<button type="submit" class="btn btn-primary" id="search" value="search">Search</button>
						<button type="button" class="btn btn-default" id="reset" onclick="resetForm()">Reset</button>

					</div>
              </div>
            </div>
          </form>

		<div class="row">
			<fieldset>
				<legend>Result:</legend>
				<p>Total result : <?php echo $json->total_results; ?></p>
			</fieldset>
			<div class="col-sm-12">
				<table class="table table-striped">

					<?php 
					foreach ($json->results as $result)
					{
						echo '<tr>';
						echo '<td>';
						echo '<a href="movieDetail.php?id='.$result->id.'" target="_blank">';

						if($result->poster_path)
							echo '<img src="https://image.tmdb.org/t/p/w92/'.$result->poster_path.'" class="rounded float-xs-left img-sz-res" alt="Poster image">';
						else
							echo '<img src="assets/images/null.png" class="rounded float-xs-left img-sz-res" alt="Poster image">';
						echo '<span>&nbsp;</span>';
						echo '<span>'.$result->title.'</span>';
						echo '<span>&nbsp; - &nbsp;</span>';
						if($result->release_date != "")
							echo '<span>'.substr($result->release_date, 0, 4).'</span>';
						else
							echo '<span>Unknown</span>';

						if($result->adult == true)
						{
							echo '<span>&nbsp; - &nbsp;</span>';
							echo '<span>Adult</span>';
						}
						echo '</a>';
						echo '</td>';
						echo '<td class="text-right text-info td-wd">';
						if($result->vote_average != 0)
							echo '&#32;'.$result->vote_average;
						else
							echo '&#32;Not Rated';
						echo '&#32;<span class="glyphicon glyphicon-star"></span>';
						echo '<br/>';
						if($result->release_date != "")
							echo '&#32;'.$result->release_date.'&#32;<span class="glyphicon glyphicon-calendar"></span>';
						else
							echo '&#32;Unknown&#32;<span class="glyphicon glyphicon-calendar"></span>';
						echo '</td>';
						echo '</tr>';
					}
					?>
				</table>	
			</div>	
		</div>

		<div class="row text-center">
			<div class="col-sm-12">
				<nav aria-label="...">
					<ul class="pager">
						<?php
						if($page > 1)
						{
							echo '<li class="previous">';
							echo '<a href="../movieResult.php?page='.($page-1).'&title='.$title.'&year='.$year;
							if(isset($_GET['adultCont']))
								echo '&adultCont=true';
							echo '"><span aria-hidden="true">&larr;</span> Previous</a>';
							echo '</li>';
						}
						else
						{
							echo '<li class="previous disabled">';
							echo '<a href="#"><span aria-hidden="true">&larr;</span> Previous</a>';
							echo '</li>';	
						}

						echo '<li><span>'.$page.' of '.$json->total_pages.'</span></li>';

						if($page < $json->total_pages)
						{
							echo '<li class="next">';
							echo '<a href="../movieResult.php?page='.($page+1).'&title='.$title.'&year='.$year;
							if(isset($_GET['adultCont']))
								echo '&adultCont=true';
							echo '">Next<span aria-hidden="true">&rarr;</span></a>';
							echo '</li>';
						}
						else
						{
							echo '<li class="next disabled">';
							echo '<a href="#">Next<span aria-hidden="true">&rarr;</span></a>';
							echo '</li>';	
						}
						?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	</div>
      </div>
    </div>
  </div>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="about">
            <div class="logo">
              <img src="assets/images/black-logo.png" alt="Plot Listing">
            </div>
            <p>If you consider that <a rel="nofollow" href="https://templatemo.com/tm-564-plot-listing" target="_parent">Plot Listing template</a> is useful for your website, please <a rel="nofollow" href="https://www.paypal.me/templatemo" target="_blank">support us</a> a little via PayPal.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="contact-us">
            <h4>Contact Us</h4>
            <p>27th Street of New Town, Digital Villa</p>
            <div class="row">
              <div class="col-lg-6">
                <a href="#">010-020-0340</a>
              </div>
              <div class="col-lg-6">
                <a href="#">090-080-0760</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="sub-footer">
            <p>Copyright © 2021 Plot Listing Co., Ltd. All Rights Reserved.
            <br>
			Design: <a rel="nofollow" href="https://templatemo.com" title="CSS Templates">TemplateMo</a></p>
          </div>
        </div>
      </div>
    </div>
  </footer>


  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/animation.js"></script>
  <script src="assets/js/imagesloaded.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
