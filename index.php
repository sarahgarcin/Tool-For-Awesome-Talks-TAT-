<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LTAT</title>
	<link rel="stylesheet" href="css/style.css">
	<!-- <link rel="stylesheet" href="default-template.css"> -->
	<link rel="stylesheet" href="css/lechner-template.css">
</head>
<body>
	<main class="row">
		<div class="damier">
		
			<?php 
				// error_reporting(E_ALL);
				@include "utils.php";
				include 'libs/Parsedown.php'; 
  			$Parsedown = new Parsedown();

				$dirlist = getFileList("images");
				array_multisort(array_column($dirlist, "name"), SORT_ASC, $dirlist ); 
				
				echo "<ul class='liste-damier'>";
					foreach($dirlist as $file){
						$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
						$fileName = str_replace('images/', '', $file['name']);
				  	$filePath = $file['name'];
				  	$legend = explode('.', $fileName);

						if($ext == 'txt'){
							// si le fichier est une légende d'image, ne pas l'afficher comme une slide
							if(count($legend) == 3){
								if($legend[1] == 'jpg' || $legend[1] == 'png' || $legend[1] == 'gif'){
									if($legend[2] == 'txt'){
										// echo "it is a legend";
									}
								} 
							}
							// sinon l'afficher
							else{
								$content = file_get_contents($file['name']);
								echo "<li class='texte'>";
								echo $Parsedown->text($content);
								echo "</li>";
							}

						}
						if($ext == 'mp4' || $ext == 'webm' || $ext == 'ogg'){
							
							echo "<li class='video' data-video='{$filePath}'>";
					  		echo "<h1>";
					  		echo $fileName;
					  		echo "</h1>";
					  	echo "</li>";
						}
						if($ext == 'mp3' || $ext == 'wav'){
							echo "<li class='audio' data-audio='{$filePath}'>";
					  		echo "<h1>";
					  		echo $fileName;
					  		echo "</h1>";
					  	echo "</li>";
						}
						if($ext == 'pdf'){
							echo "<li class='pdf' data-pdf='{$filePath}'>";
					  		echo "<h1>";
					  		echo $fileName;
					  		echo "</h1>";
					  	echo "</li>";
						}
						
						if($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $legend[2] == 'txt'){
				  		echo "<li class='image'>";
					  	if(count($legend) == 3){
								if($legend[1] == 'jpg' || $legend[1] == 'png' || $legend[1] == 'gif'){
									$cleanPath = str_replace('.txt', '', $filePath);
									$content = file_get_contents($file['name']);
						  		echo "<figure data-thumb='{$cleanPath}' data-image='{$cleanPath}' data-legend='true'>";
						  		echo "<img src='{$cleanPath}'/>";
						  		echo "<figcaption>". $Parsedown->text($content)."</figcaption>";
						  		echo "</figure>";
								}
							}
							else{
					  		echo "<figure data-thumb='{$filePath}' data-image='{$filePath}'>";
					  		echo "<img src='{$filePath}'/>";
					  		echo "</figure>";
							}
					  	echo "</li>";
						}

					}
				 echo "</ul>";
				 
		  
			?>
		</div>

		<div class="preview">
			<div class="image-wrapper">
				
			</div>
		</div>
	</main>


	<script src="js/jquery.min.js" type="text/javascript"></script>
	<script src="js/script.js" type="text/javascript"></script>

</body>
</html>