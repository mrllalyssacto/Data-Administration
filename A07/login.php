<?php

include('connect.php');

$error = "";

  if (isset($_POST['btnPost'])) {
    $userID = $_POST['userID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dateTime = $_POST['dateTime'];
    $content = $_POST['content'];

    $checkUserQuery = "SELECT * FROM userinfo WHERE userID = '$userID'";
    $userResult = executeQuery($checkUserQuery);

    if (mysqli_num_rows($userResult) == 0) {
      $userinfoQuery = "INSERT INTO userinfo (userID, firstName, lastName)
                        VALUES ('$userID', '$firstName', '$lastName')";
      executeQuery($userinfoQuery);
    }
    
    $postQuery = "INSERT INTO posts (userID, dateTime, content)
                  VALUES ('$userID', '$dateTime', '$content')";   
    executeQuery($postQuery);  
    
    header("Location: index.php");
  }

  $query = "SELECT userInfo.userID, userInfo.firstName, userInfo.lastName, posts.dateTime, posts.content
            FROM userInfo 
            LEFT JOIN posts ON userInfo.userID = posts.userID
            ORDER BY userInfo.userID";

$result = executeQuery($query);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Universe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" href="image/icon.png">

  <style>
    .card {
      background-color: #0b132b;
      color: #30b3a1;
      padding: 1rem;
      max-width: 800px;
      margin: 0 auto;
    }

    .form-control {
      background-color: white;
      color: #0b132b;
      border: 1px solid #0b132b;
    }

    .btnPrimary {
      background-color: #30b3a1;
      border-color: #30b3a1;
      font-family: Arial;
    }

    .btnPrimary:hover {
      background-color: #2e3a8e;
      border-color: 32
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
    <div class="container-fluid">
      <a href="login.php"><img src="https://iconape.com/wp-content/files/fb/344772/svg/344772.svg" alt="Navbar Logo"
          class="img-fluid" style="width: 90px; height: 40px;" /></a>
    </div>
  </nav>

  <div class="container">

    <?php if ($error == "Not found") { ?>

    <div class="row">
      <div class="col">
        <div style="height: 50px" class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:">
            <use xlink:href="#exclamation-triangle-fill" />
          </svg>
          <div>
            User not found.
          </div>
        </div>
      </div>
    </div>

    <?php } ?>

    <div class="row my-5">
      <div class="col">
        <div class="card p-3 text-center rounded-4 shadow">
          <div class="h3 mb-5">Post</div>
          <form method="POST">
            <input class="mb-3 form-control" placeholder="First Name" name="firstName" type="firstName" required>
            <input class="mb-3 form-control" placeholder="Last Name" name="lastName" type="lastName">
            <input class="mb-3 form-control" placeholder="User ID" name="userID" type="userID" required>
            <input class="mb-3 form-control" placeholder="Date" name="dateTime" type="dateTime" required>
            <textarea class="mb-3 form-control" placeholder="Write a post" name="content" type="content"></textarea>
            <button class="mb-5 btn btnPrimary w-100" name="btnPost">Post</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>