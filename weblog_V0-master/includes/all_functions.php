<?php
function getPostTopic($post_id)
{
    global $conn;
    $sql = "SELECT * FROM topics JOIN post_topic ON topics.id = post_topic.topic_id WHERE post_topic.post_id=$post_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $topic = mysqli_fetch_assoc($result);
    return $topic;
}

function getPublishedPosts()
{
    global $conn;
    $sql = "SELECT * FROM posts WHERE published=true";
    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $final_posts = array();
    foreach ($posts as $post) {
        $post['topic'] = getPostTopic($post['id']);
        array_push($final_posts, $post);
    }
    return $final_posts;
}

function getPost($slug) {
    global $conn;
    
    $sql = "SELECT * FROM posts WHERE slug='$slug'";
    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $final_posts = array();
    foreach ($posts as $post) {
        $topic = getPostTopic($post['id']);
        $post['topic'] = $topic['body']; 
        array_push($final_posts, $post);
    }
    return $final_posts;
}

function getAllTopics()
{
    global $conn;
    $sql = 'SELECT * from topics';
    $result = mysqli_query($conn, $sql);
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $topics;
}

function getPublishedPostsByTopic($topic_id) {
    global $conn;
    $sql = "SELECT * FROM posts WHERE id IN (SELECT post_id FROM post_topic WHERE topic_id=$topic_id) AND published=true";
    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    $final_posts = array();
    foreach ($posts as $post) {
        $post['topic'] = getPostTopic($post['id']);
        array_push($final_posts, $post);
    }
    return $final_posts;
}

?>
