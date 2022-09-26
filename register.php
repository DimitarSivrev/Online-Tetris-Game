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
<form class = "registration-box" action = "index.php" method = "POST">
  <label>Register</label>
  <p>
  <input placeholder="First Name" type="text" id = "first-name" name ="first-name" required></p>
  <p>
  <input placeholder="Last name" type="text" id = "last-name" name = "last-name" required></p>
  <p>
  <input placeholder="Username" type="text" id ="user-name" name ="user-name" required></p>
  <p>
  <input placeholder="Password" id="password" name="password" onchange=
  "if(this.checkValidity()) form.c_password.pattern = this.value;"  required>
  <p>
  <input placeholder="Confirm Password" id="c_password" required></p>

  <p>Display Scores on leaderboard</p>
  <input type="radio" id="yes" name="display" value="yes" required>
  <label for="yes">Yes</label><br>
  <input type="radio" id="no" name="display" value="no"  required>
  <label for="yes">No</label><br>
  <input type="submit">

</form>
</div>

</body>
</html>