<?php

include('connect.php');

if (isset($_POST['btnDelete'])) {
    $alisinNa = $_POST['delete'];
    $deleteQuery = "DELETE FROM posts WHERE postID = '$alisinNa'";
    executeQuery($deleteQuery);

    header('Location: index.php');
}
$query = "
    SELECT userInfo.userID, userInfo.firstName, userInfo.lastName, posts.postID, posts.dateTime, posts.content
    FROM userInfo 
    LEFT JOIN posts ON userInfo.userID = posts.userID
    ORDER BY userInfo.userID
";

$result = executeQuery($query);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="shared/css/style.css">
    <link rel="icon" href="image/icon.png">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .formContainer {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin: 40px 0 20px;
            color: #354e7e;
            font-weight: bold;
        }

        .card {
            margin-bottom: 20px;
            margin-top: 20px;
            border-radius: 15px;
        }

        .headerBox {
            max-width: 700px;
            margin: 50px auto 20px;
            padding: 15px;
            border-radius: 20px;
            background-color: white;
            color: #E4E0E1;
            align-items: center;
            font-weight: bold;
            display: flex;
            justify-content: flex-start;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-size: 1.1em;
        }

        .btnPrimary {
            background-color: #30b3a1;
            border-color: #30b3a1;
            font-family: Arial;
        }

        .btnPrimary:hover {
            background-color: #30b3a1;
            border-color: 32
        }

        @media (max-width: 576px) {
            h1 {
                margin-top: 20px;
            }
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 10px;
            }
        }

        /* Colors based on users */
        .user-1 { background-color: #D0E8FF; }
        .user-2 { background-color: #FFCCDC; }
        .user-3 { background-color: #CFFFE5; }
        .user-4 { background-color: #FFFFF0; }
        .user-5 { background-color: #FFDDC1; }
        .user-6 { background-color: #FFF5E4; }
        .user-7 { background-color: #E0FFFF; }
        .user-8 { background-color: #F0E0FF; }
        .user-9 { background-color: #E6D8B8; }
        .user-10 { background-color: #FFE4A0; }
        .user-11 { background-color: #ffe34d; } 
        .user-12 { background-color: #ADFF2F; } 
        .user-13 { background-color: #FF69B4; }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
        <div class="container-fluid">
            <a href = "login.php"><img src="https://iconape.com/wp-content/files/fb/344772/svg/344772.svg" alt="Navbar Logo" class="img-fluid" style="width: 90px; height: 40px;" /></a>
        </div>
    </nav>

        <div class="userList mt-4" style="display: block;">
            <div class="row justify-content-center">
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($user = mysqli_fetch_assoc($result)) {
                            $userId = $user['userID'] % 13 + 1;
                            $userClass = 'user-' . $userId;
                            
                            $content = !empty($user['content']) ? $user['content'] : '';
                            ?>
                            <div class="col-12 col-md-10 col-lg-8 mb-3">
                                <div class="card <?php echo $userClass; ?>">

                                    <div class="card-body">
                                        <h5 class="card-title"><b><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></b></h5>
                                        <p><b>User ID:</b> <?php echo htmlspecialchars($user['userID']); ?></p>
                                        <p><i><?php echo htmlspecialchars($user['dateTime']); ?></i></p>
                                        <?php if (!empty($content)): ?>
                                            <p><b><?php echo htmlspecialchars($content); ?></b></p>
                                        <?php else: ?>
                                            <p><b>Content:</b> No content available.</p>
                                        <?php endif; ?>
                                        
                                        <form method="post">
                                            <input type="hidden" value="<?php echo $user['postID']?>" name="delete">
                                            <button class="btn btn-danger" name="btnDelete">Delete</button>
                                        </form>

                                        <form>
                                            <a href="edit.php?id=<?php echo $user['postID']; ?>" class="btn btn-warning mt-2">Edit</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="col-12"><p class="text-center">No users found.</p></div>';
                    }
                ?>
            </div>
        </div>
        <a href = "login.php"><button class = "btn btnPrimary">Back</button></a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybR8jH2gCqC2C1j3q4FNT6eDFT6e0bcA6Z0DgEG0o9R6wBz5K" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-n78PRWJY6Ez9mG2Tg5ZxV1BdH7We2pNlyT2bRjXhW+ALEwIH" crossorigin="anonymous"></script>
</body>

</html>
