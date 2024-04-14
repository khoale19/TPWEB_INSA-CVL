<?php include ('config.php'); ?>
<?php include ('includes/public/head_section.php'); ?>
<?php include ('includes/all_functions.php'); ?>
<title>MyWebSite | Home </title>
</head>

<body>

	<div class="container">

		<!-- Navbar -->
		<?php include (ROOT_PATH . '/includes/public/navbar.php'); ?>
		<!-- // Navbar -->

		<!-- Banner -->
		<?php include (ROOT_PATH . '/includes/public/banner.php'); ?>
		<!-- // Banner -->

		<!-- Messages -->

		<!-- // Messages -->

		<!-- content -->
		<div class="content">
			<h2 class="content-title">Recent Articles</h2>
			<hr>

			<?php
			// Get the published posts
			$posts = getPublishedPosts();

			// Check if there are any posts
			if (!empty ($posts)) {
				// Loop through each post
				foreach ($posts as $post) {
					?>
					<div class="post">
						<p class="category"><?php echo $post['topic']['name']; ?></p>
						<img src="static/images/<?php echo $post['image']; ?>" alt="" class="post_image">

						<p class="post_info">
							<?php echo $post['title']; ?><br><span>
								<?php $dateString = $post['created_at'];
								$newDateFormat = date("F j, Y", strtotime($dateString));
								echo $newDateFormat; ?><br>
								<span class="read_more"><a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">Read more...</a>
</span>
							</span>
						</p>

					</div>
					<?php
				}
			} else {
				// Display a message if there are no published posts
				echo "<p>No published posts found.</p>";
			}
			?>

		</div>
		<!-- // content -->


	</div>
	<!-- // container -->


	<!-- Footer -->
	<?php include (ROOT_PATH . '/includes/public/footer.php'); ?>
	<!-- // Footer -->