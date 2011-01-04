<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" /> 
	<title>Colorpul - Color palette generator</title>
	<link href="css/reset.css" rel="stylesheet" media="all" />
	<link href="css/styles.css" rel="stylesheet" media="all" />
</head>
<body>

<div id="wrapper">

	<header>
		<a href="http://colorpul.com" id="logo">Colorpul</a>
		<p id="description">A simple color palette generating script.</p>
		<br class="clear" />
	</header>

	<div id="content-wrap">
		<div id="main-content">
			<?php
			error_reporting(0);
			
			// Our image will be passed via the onpage form with the name 'img'.
			$imgURL = $_POST['img'];
			
			// First we'll confirm that an image was submitted and that it's not a phony submission.
			if($imgURL != null && strlen($imgURL)>7){
			
				// Everything checks out, so let's get the width, height, and type of the image.	
				list($width, $height, $type, $attr) = getimagesize($imgURL);
				
				if($type == null){
					// Double check that an actual file has been uploaded.
					echo "<b>Uh oh.</b> You sure that was an image you were linking to?";
				} else {
				
					// Great, we're looking good! Let's check the filetype.
					switch($type) {
						case 1:
							$im = imagecreatefromgif($imgURL);
							break;
						case 2:
							$im = imagecreatefromjpeg($imgURL);
							break;
						case 3:
							$im = imagecreatefrompng($imgURL);
							break;
						case 6:
							$im = imagecreatefromxbm($imgURL);
					}
					
					// Now set dimensions on where to pull color values from (based on percentages).
					$percentages = array(0.2,0.7,0.5);
					
					$dimensions[] = ($width - ($width * $percentages[0]));
					$dimensions[] = ($height - ($height * $percentages[0]));
					$dimensions[] = ($width - ($width * $percentages[0]));
					$dimensions[] = ($height - ($height * $percentages[1]));
					$dimensions[] = ($width - ($width * $percentages[1]));
					$dimensions[] = ($height - ($height * $percentages[1]));
					$dimensions[] = ($width - ($width * $percentages[1]));
					$dimensions[] = ($height - ($height * $percentages[0]));
					$dimensions[] = ($width - ($width * $percentages[2]));
					$dimensions[] = ($height - ($height * $percentages[2]));
					
					// Here we'll pull the color values of certain pixels around the image based on our dimensions set above.
					for($k=0;$k<10;$k++){
						$newk = $k+1;
						$rgb[] = imagecolorat($im, $dimensions[$k], $dimensions[$newk]);
						$k++;
					}
					
					// Almost done! Now we need to get the individual r,g,b values for our colors.
					foreach($rgb as $colorvalue){
						$r[] = dechex(($colorvalue >> 16) & 0xFF);
						$g[] = dechex(($colorvalue >> 8) & 0xFF);
						$b[] = dechex($colorvalue & 0xFF);
					}
					
					// Rather than creating an array with each color generated, we'll store them as variables like so.
					$firstColor = strtoupper($r[0].$g[0].$b[0]);
					$secondColor = strtoupper($r[1].$g[1].$b[1]);				
					$thirdColor = strtoupper($r[2].$g[2].$b[2]);
					$fourthColor = strtoupper($r[3].$g[3].$b[3]);
					$fifthColor = strtoupper($r[4].$g[4].$b[4]);
					
					// Everything checks out, so now let's display the original photo and a present the colors.
				
				?>
				
			<a href="<?php echo $imgURL; ?>"><img class="preview" src="<?php echo $imgURL; ?>" /></a>
			
			<div id="palette">
				<div class="column">
					<div class="color" style="background-color: #<?php echo $firstColor; ?>"></div>
					<span class="colorlabel"><?php echo $firstColor; ?></span>
				</div>
				<div class="column">
					<div class="color" style="background-color: #<?php echo $secondColor; ?>"></div>
					<span class="colorlabel"><?php echo $secondColor; ?></span>
				</div>
				<div class="column">
					<div class="color" style="background-color: #<?php echo $thirdColor; ?>"></div>
					<span class="colorlabel"><?php echo $thirdColor; ?></span>
				</div>
				<div class="column">
					<div class="color" style="background-color: #<?php echo $fourthColor; ?>"></div>
					<span class="colorlabel"><?php echo $fourthColor; ?></span>
				</div>
				<div class="column">
					<div class="color" style="background-color: #<?php echo $fifthColor; ?>"></div>
					<span class="colorlabel"><?php echo $fifthColor; ?></span>
				</div>				
			</div>
				
			<?php
					} // This ends the filetype check to make sure an actual file was uploaded.
				} else { 
				
				// Our form hasn't been submitted yet, so let's display it so users can upload an image.
			?>
			
			<form action="" method="POST" id="colorpul">
				<label for="imageURL">Image URL:</label>
				<span class="input-wrap">
					<input type="text" name="img" id="img" placeholder="Image URL goes here." />
				</span>
				
				<input type="submit" value="Submit" name="submit" id="submit" />
			</form>
			<br class="clear" />
			
			<?php } ?>
		</div>
	</div>
</div>

</body>
</html>