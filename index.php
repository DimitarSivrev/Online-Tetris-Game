<html>
<link rel="stylesheet" href="style.css">

<head>

<ul class="top_nav_bar">
  <li><a href="index.php" class = "home">Home</a></li>
  <li><a href="tetris.php" class = "tetris">Play Tetris</a></li>
  <li><a href="leaderboard.php" class = "leaderboard">Leaderboard</a></li>
</ul>
</head>

<body>
<div class = "main">
<?php

  session_start();

  if (isset($_SESSION['username'])){
  echo 
  "<form class = 'welcome-box' action = 'tetris.php'>
  <label>Welcome to Tetris</label>
  <p>
  <input type='submit' value = 'Click here to play'></p>
  </form>";}else{
  echo
  "<form class = 'welcome-box' method = 'get' action = ''>
  <label>Welcome to Tetris</label>
  <p>
  <input name = 'username' placeholder='username' type='text'></p>
  <p>
  <input name = 'password' placeholder='password' type='text'></p>
  <p>
  <input type='submit'></p>
  <a href='register.php' class = 'register'>Don't have a user account? Register now.</a>
  </form>";
  if( isset($_POST["first-name"]) && 
  isset($_POST["last-name"]) && isset($_POST["user-name"]) 
  && isset($_POST["password"]) &&  isset($_POST["display"])){

    $firstname = $_POST["first-name"];
    $lastname = $_POST["last-name"];
    $username = $_POST["user-name"];
    $password = $_POST["password"];
    $display = $_POST["display"];

    if($display == 'yes'){
      $value = 1;
    }else{
      $value = 0;
    }

    require 'connect.php';

    $sql = "INSERT INTO Users VALUES
    ('$username', '$firstname', '$lastname', '$password', '$value');";
    $result = $conn->query($sql);

  }else if (isset($_GET["username"]) && isset($_GET["password"])){

  $username = $_GET["username"];
  $password = $_GET["password"];
  require 'connect.php';
  $found = false;
  if ($stmt = $conn->prepare('SELECT Password FROM Users WHERE UserName = ?')){
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
      $stmt->bind_result($temp_password);
      $stmt->fetch();

      if ($password == $temp_password){
        $_SESSION['username'] = $username;
        $found = true;
        header("Refresh:0");
        
      }
    }
  }
  if($found == false){
    echo "<script>window.alert('Incorrect password or username');</script>";
  }
  }
  }

?><brb>
</div>

</body>
</html>


