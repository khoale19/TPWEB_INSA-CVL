
<?php include('config.php'); ?>
<?php include('includes/public/head_section.php'); ?>
<?php include('includes/all_functions.php'); ?>

<title> <?php echo $post['title'] ?>MyWebSite | Filtered posts</title>
</head>

<body>
    <div class="container">
        <!-- Navbar -->
        <?php include(ROOT_PATH . '/includes/public/navbar.php'); ?>
        <!-- // Navbar -->
        <div class="content">
            <?php
            if (isset($_GET['topic'])) {
                $postTopic = $_GET['topic'];
            }
            $posts = getPublishedPostsByTopic($postTopic);
            // Check if there are any posts
            if (!empty($posts)) {
                // Loop through each post
                foreach ($posts as $post) {
            ?>
                    <!-- Page wrapper -->
                    <div class="post-wrapper">
                        <!-- full post div -->
                        <div class="full-post-div">
                            <h2 class="post-title"><?php echo $post['title']; ?></h2>
                            <div class="post-body-div">
                                <p><?php echo $post['body']; ?></p>
                            </div>
                        </div>
                        <!-- // full post div -->
                    </div>
            <?php
                }
            }
            ?>

            <!-- // Page wrapper -->
            <!-- post sidebar -->
            <div class="post-sidebar">
                <div class="card">
                    <div class="card-header">
                        <h2>Topics</h2>
                    </div>
                    <?php $topics = getAllTopics();
                    foreach ($topics as $topic) {
                    ?>
                        <div class="card-content">
                            <a href="filtered_posts.php?topic=<?php echo $topic['id'] ?>"><?php echo $topic['name']; ?></a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <!-- // post sidebar -->
        </div>
    </div>
    <!-- // content -->
    <?php include(ROOT_PATH . '/includes/public/footer.php'); ?>