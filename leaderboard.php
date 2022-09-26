<html>
<link rel="stylesheet" href="style.css">

<head>

<ul class="top_nav_bar">
  <li><a href="index.php" class = "home">Home</a></li>
  <li><a href="tetris.php" class = "tetris">Play Tetris</a></li>
  <li><a href="leaderboard.php" class = "leaderboard">Leaderboard</a></li>
</ul>

    <?php
        session_start();
        if( isset($_POST['score'])) {
            require 'connect.php';

            $username = $_SESSION['username'];
            $score = $_POST['score'];
            $sql = "INSERT INTO Scores VALUES(null,'$username', '$score');";
            $result = $conn->query($sql);
        }
    ?>
</head>

<body>
<div class = "main">
  <div class = "welcome-box">
    <table>
    <tr>
    <th>Username</th>
    <th>Score</th>
    </tr>
<?php
    require "connect.php";
    $sql = "SELECT Scores.Username, Score, Display ";
    $sql .= "FROM Scores, Users ";
    $sql .= "WHERE Scores.Username = Users.Username";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {   
        while ($row = mysqli_fetch_array($result)) {
            if ($row['Display'] == 1) {
              echo "<tr>";
              echo "<td>" . $row['Username'] ."</td>";
              echo "<td>" . $row['Score'] ."</td>";
              echo "</tr>";
            }
        }
    }

?>
 </table>
  </div>         
  </div>  
</body>
</html>