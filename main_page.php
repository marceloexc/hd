<!DOCTYPE html>


<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css">
		<link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="hdr.js"> </script>
		<?php
		include 'render_board.php';

		$motd_array = array("Disco Duro",
							"Lobotomy Software",
							"My life on the internet",
							"Mendez Forever",
							"Marcelographic",
							"Im fine...bye bye",
							"Pig worker");
		$motd_key = array_rand($motd_array, 1);

		$motd = $motd_array[$motd_key];

		echo "<title>$motd</title>";
		?>
	</head>
	<body>
		<main>
			<header>
				<div class="video-text">

					<video class="hdr clip" id="bright" autoplay muted loop playsinline>
						<source src="/static/hdr.webm" type="video/webm">
						<source src="/static/hdr.mp4" type="video/mp4">
					</video>

					<video class="sdr clip" id="fallback" autoplay muted loop playsinline>
						<source src="/static/black.mp4" type="video/mp4">
					</video>


					<svg class="hdr-compatible" id="hdr" viewBox="0 -40 500 120" preserveAspectRatio="xMidYMid meet">
						<defs>
							<clipPath id="clip" clipPathUnits="userSpaceOnUse">
								<text x="0%" y="100%"
									  text-anchor="start"

									  font-family="HappyTimes, Tahoma"
									  font-weight="100"
									  font-size="160"
									  letter-spacing="-12">
									<tspan>Hard</tspan>
									<tspan x="0%" y="248">Drive</tspan>
								</text>
							</clipPath>
						</defs>
					</svg>
				</div>

				<?php

				/* lobotomy software  */
				$banner_array = array("/static/banner.jpg",
									  "/static/banner2.jpg",
									  "/static/van.JPG",
									  "/static/box.jpeg",
									  "/static/god.jpeg",
									  "/static/cig.jpg",
									  "/static/oxxo.JPG",
									  "/static/shack.jpg",
									  "/static/tavi.jpg",
									  "/static/sun.jpg",
									  "/static/clau.jpg",
									  "/static/view.jpg",
									  "/static/shack2.jpg",
									  "/static/villas.jpg",
									  "/static/fantastic_light.jpg");

				$banner_image_key = array_rand($banner_array, 1);

				$header_img = $banner_array[$banner_image_key];
				echo "<img src=$header_img>";

				?>
			</header>
			<h3>
			</h3>
			<ul style="list-style: none; padding-left: 20px;" class="listing">
				<?php
				$boards = new BoardListingsRenderer("content");
				$boards->render();

				?>
			</ul>
		</main>

		<footer>
			<?php
			$footer_array = array("/static/soriginal.jpg",
								  "/static/lunch.jpeg",
								  "/static/dusk.jpeg",
								  "/static/still.gif",
								  "/static/att.jpg",
								  "/static/light.jpg",
								  "/static/msp.jpg",
								  "/static/chrysler.jpg",
								  "/static/hat.png",
								  "/static/hardstaff.webp",
								  "/static/hardstaff2.webp",
								  "/static/brady.jpg",
								  "/static/cinema.jpg",
								  "/static/crash.mp4",
								  "/static/mendez.jpeg",
								  "/static/delft.png",
								  /* "/static/shine3.gif", */
								  "/static/ween.jpg",
								  "/static/ugly_boy.png",
								  "/static/wejdas.jpg",
								  "/static/action.gif",
								  "/static/chains.gif",
								  "/static/shut_the_fuck_up.jpeg",
								  "/static/lynx.webp",
								  "/static/reed_warbler.jpg",
								  '/static/portrait.jpg',
								  "/static/fox.jpg",
								  "/static/wildebeest.png",
                                  "/static/itunes.png",
                                  "/static/john-pankow-richard-kind.webp");

			// reed warblers use the inclination of the magnetic field (magenta lines) to navigate to and find their breeding sites (yellow dots)

			$footer_image_key = array_rand($footer_array, 1);

			$footer_img = $footer_array[$footer_image_key];

			if (str_ends_with($footer_img, ".mp4")) {
				echo "<video src='$footer_img' class='footer-vid' autoplay muted loop playsinline ></video>";
			} else {
				echo "<img src=$footer_img >";

			}

			?>

			<p>
				cool links
			</p>

			<div class="listing sidebar">
				<a href="https://rm2000.app">rm2000 tape recorder for macintosh</a>
				<br>
				<a href="https://stanleylieber.com/">stanley lieber</a>
				<br>
				<a href="https://wiki.xxiivv.com">devine lu linvega</a>
				<br>
				<a href="https://valvearchive.com">valve archive</a>
				<br>
				<a href="https://www.epiclylaterd.com/">epicly later'd</a>
				<br>
				<a href="https://howcouldyoudothisto.us/">how could you do this to us</a>
				<br>
				<a href="https://otto-b.info/" >otto benson</a>
				<br>
				<a href="https://www.unchangingwindow.com/content/">unchanging window</a>
				<br>
				<a href="https://www.php.net/">php</a>
				<br>
				<a href="https://ja-cob.itch.io/hyper">hyperkidmorph2mr.gunner</a>
				<br>
				<a href="https://fieldoflove.tumblr.com">fieldoflove</a>
				<br>
				<!-- <a href="https://twitter.com/krezrg_1">krezrg_1</a>
					 <br> -->
				<a href="https://www.johnnyhardstaff.com/home/future-of-gaming">hardstaff at his best</a>
				<br>
				<a href="https://orllewin.uk/pcr/">pudsey clough radio</a>
				<br>
				<a href="https://eerilyrealistic.com/">eerilyrealistic</a>
				<br>
				<a href="https://felicityjlord.online">felicity j lord</a>
				<br>
				<a href="https://emacsformacos.com/">emacs for mac os</a>
				<br>
				<a href="http://www.danamania.com/print/">dana's print archive</a>
				<br>
			</div>
			<?php

			function formatBytes($bytes, $precision = 2) {
				$units = ['B', 'KB', 'mb', 'GB', 'TB'];

				$bytes = max($bytes, 0);
				$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
				$pow = min($pow, count($units) - 1);

				$bytes /= pow(1024, $pow);
				// this will also work in place of the above line:
				// $bytes /= (1 << (10 * $pow));

				return round($bytes, $precision) . $units[$pow];
			}


			$total_size = 0;
			$di = new RecursiveDirectoryIterator('.');
			foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
				if($file->isFile()) {
					/* echo $filename . ' - ' . $file->getSize() . ' bytes <br/>'; */
					$total_size += $file->getSize();
				}
			}

			$total_size_formatted = formatBytes($total_size);

			echo "<p>hosted on debian</p>"; //in bytes
			/* echo "<p>$total_size_formatted</p>"; */
			?>

			<br>	<br>
			<p>
				marcelo mendez 2025. <a href="/all.html">all</a>
			</p>


		</footer>

	</body>

</html>
