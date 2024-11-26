<?php
include('connect.php');

$postID = $_GET['id'];

if (isset($_POST['btnEdit'])) {
    $newContent = $_POST['content'];

    $editQuery = "UPDATE posts SET content = '$newContent' WHERE postID = '$postID'";
    executeQuery($editQuery);

    header('Location: index.php');
}

$query = "
    SELECT userInfo.userID, userInfo.firstName, userInfo.lastName, posts.postID, posts.dateTime, posts.content
    FROM userInfo 
    LEFT JOIN posts ON userInfo.userID = posts.userID
    WHERE postID = '$postID'
    ORDER BY userInfo.userID
";
$result = executeQuery($query);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="shared/css/style.css">
    <link rel="icon" href="image/icon.png">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
        <div class="container-fluid">
            <a href="login.php"><img src="https://iconape.com/wp-content/files/fb/344772/svg/344772.svg" alt="Navbar Logo" class="img-fluid" style="width: 90px; height: 40px;" /></a>
        </div>
    </nav>

    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="h3 text-center">
                    Edit Post
                </div>

                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($posts = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="card">
                            <div class="card-body">
                                <form method="post">
                                    <input type="hidden" value="<?php echo $posts['postID']; ?>" name="edit">

                                    <div class="mb-3">
                                        <label for="content" class="form-label">Post Content</label>
                                        <textarea class="form-control" id="content" name="content" rows="5"><?php echo htmlspecialchars($posts['content']); ?></textarea>
                                    </div>

                                    <button class="btn btn-primary" type="submit" name="btnEdit">Save</button>
                                    <a href="index.php" class="btn btn-primary">Cancel</a>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybR8jH2gCqC2C1j3q4FNT6eDFT6e0bcA6Z0DgEG0o9R6wBz5K" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-n78PRWJY6Ez9mG2Tg5ZxV1BdH7We2pNlyT2bRjXhW+ALEwIH" crossorigin="anonymous"></script>

</body>
</html>
