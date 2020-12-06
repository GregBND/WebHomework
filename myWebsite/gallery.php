<?php
    // Application logic:
    include('config.inc.php');
    $messages = array();   
    
        // Form checkings:
        if (isset($_POST['send'])) {
          //print_r($_FILES);
          foreach($_FILES as $file) {
              if ($file['error'] == 4);   // There was no file uploaded
              elseif (!in_array($file['type'], $MEDIATYPES))
                  $messages[] = " The type is not correct: " . $file['name'];
              elseif ($file['error'] == 1   // The file size exceeds the limit allowed in php.ini
                          or $file['error'] == 2   // The file size exceeds the limit allowed in HTML Form
                          or $file['size'] > $MAXSIZE) 
                  $messages[] = " Too big file: " . $file['name'];
              else {
                  $target_dir = $FOLDER.strtolower($file['name']);
                  if (file_exists($target_dir))
                      $messages[] = " Already exist: " . $file['name'];
                  else {
                      move_uploaded_file($file['tmp_name'], $target_dir);
                      $messages[] = ' Ok: ' . $file['name'];
                  }
              }
          }        
      }
    // Collecting data:    
    $images = array();
    $reader = opendir($FOLDER);
    while (($file = readdir($reader)) !== false) {
        if (is_file($FOLDER.$file)) {
            $end = strtolower(substr($file, strlen($file)-4));
            if (in_array($end, $TYPES)) {
                $images[$file] = filemtime($FOLDER.$file);
            }
        }
    }
    closedir($reader);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Protect Our Wildlife | Values</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<style>
			.fakeimg
			{
				height: 200px;
				background: #090E11;
			}

		</style>
		<div class="jumbotron text-center" style="margin-bottom:0">
			<img src="Images/header.png" width=100% />
		</div>
	</head>
	<body>
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item"><a class="nav-link" href="HomePage.html">Values & Goals</a></li>
					<li class="nav-item"><a class="nav-link" href="trapping.html">Trapping In Vermont</a></li>
					<li class="nav-item"><a class="navbar-brand" href="gallery.php">Image Gallery</a></li>
					<li class="nav-item"><a class="nav-link" href="getInvolved.html">Get Involved</a></li>
					<li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
				</ul>
			</div>
		</nav>
		<div class="container" style="margin: 10px 0">
			<div class="row">
				<div class="col-sm-4">
					<div class="jumbotron text-left" style="margin: 10px 0">
						<center><h1>Upload</h1></center>
						<form action="gallery.php" method="post"enctype="multipart/form-data">
							<label><b>File:</b><input type="file" name="first" required></label>
							<input type="submit" name="send">
						</form>
					</div>
				</div>

				<div class="col-sm-8">
					<div>
						<center>
							<h1>GALLERY</h1>
						</center>
						<div class="container" style="margin-top:30px" >
							<div id="gallery">
								<?php
								arsort($images);
								foreach($images as $file => $date)
								{
								?>
									<div class="image">
										<a href="<?php echo $FOLDER.$file ?>">
											<img src="<?php echo $FOLDER.$file ?>">
										</a>            
										<p>Name:  <?php echo $file; ?></p>
										<p>Date:  <?php echo date($DATEFORMAT, $date); ?></p>
									</div>
								<?php
								}
								?>
							</div>
							<?php
							if (!empty($messages))
							{
								echo '<ul>';
								foreach($messages as $m)
									echo "<li>$m</li>";
								echo '</ul>';
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="jumbotron text-center" style="line-height:10px">
			<div class="container" style="margin: 10px 0">
				<div class="row">
					<div class="col-sm-4">
						<img src="Images/logo.webp" height=150px />
					</div>
					<div class="col-sm-8">
						<p>
							<b>Protect Our Wildlife </b>
							©2020
						</p>
						<p>
							PO Box 3024 
						</p>
						<p>
							Stowe, VT 05672
						</p>
						<p>
							802-253-1592
						</p>
						<a href="https://www.protectourwildlifevt.org">Original Website</a>
						<br>
						</br>
						<p>
							POW is a nonprofit 501(c)3 organization.
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>