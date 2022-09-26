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

<div class= "main">
<div class= "game-background">
  <div id ="tetris-bg" class = "tetris-bg">
  <h3 id = "score-box" >Score:<span id="score">0</span></h3>

  </div>
  </div>
</div>
</div>

<script>
var audio = new Audio('music.mp3');
audio.play();

const width = 10;
let timer;
const grid = document.querySelector('#tetris-bg');
let blocks = document.querySelectorAll('#tetris-bg div');
const scoreDisplay = document.querySelector('#score')
let currentBlock = null;
let blockWidth = 0;
let blockHeight = 0;
let score = 0;
let blockY = 0;
let blockX = 0;

tetrisArray = [
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "],
  [" "," "," "," "," "," "," "," "," "," "]]


var shapes = {
  "L" : [ [[1,1],[1,2],[1,3],[2,3]],[],[],[]  ],
  "Z" : [ [[1,1],[2,1],[2,2],[3,2]],[],[],[]  ],
  "S" : [ [[1,2],[2,1],[2,2],[3,1]],[],[],[]  ],
  "T" : [ [[1,1],[2,1],[2,2],[3,1]],[],[],[]  ],
  "O" : [ [[1,1],[1,2],[2,1],[2,2]],[],[],[]  ],
  "I" : [ [[1,1],[1,2],[1,3],[1,4]],[],[],[]  ]
}
var colors = {
  "L" : "blue",
  "Z" : "red",
  "S" : "black",
  "T" : "yellow",
  "O" : "purple",
  "I" : "green"
}
var dimensions = {
  "L" : [60,90],
  "Z" : [90,60],
  "S" : [90,60],
  "T" : [90,60],
  "O" : [60,60],
  "I" : [30,120]
}

//Creates button
var button = document.createElement('button');
button.setAttribute('onclick', 'start()');
button.setAttribute('id', 'button');
button.innerText = 'Start the game';
document.getElementsByClassName('tetris-bg')[0].appendChild(button);

//Selects random tetris block
  function selectShape() {
    var tags = ["L","Z","S","T","O","I"];
    var tag = tags[Math.floor(Math.random()*6)];
    var id = tag + Math.floor(Math.random()*9999999);
    return id;}


  var shape = selectShape(), rotation = 0;
 
  //Creates the tetris block using div elements
  function draw(type){
  blockY =0;
  score += 1;
  scoreDisplay.innerHTML = score
  currentBlock = shapes[type.charAt(0)][rotation];
  blockWidth = dimensions[type.charAt(0)][0];
  blockHeight = dimensions[type.charAt(0)][1];

  var block_position = [
  [currentBlock[0][0]*30 -30,currentBlock[0][1]*30 -30],
  [currentBlock[1][0]*30 -60,currentBlock[1][1]*30 -30],
  [currentBlock[2][0]*30 -90,currentBlock[2][1]*30 -30],
  [currentBlock[3][0]*30 -120,currentBlock[3][1]*30 -30]
]
  var mainBlock = document.createElement('div');
  mainBlock.setAttribute('class', 'mainBlock');
  mainBlock.setAttribute('id', type);
  grid.appendChild(mainBlock);
  var color = colors[type.charAt(0)];
  
  for(let i = 0; i < 4; i++){
    var blockPiece = document.createElement('div');
    blockPiece.setAttribute('class', 'block');
    blockPiece.setAttribute('id', type + i);
    mainBlock.appendChild(blockPiece);
    document.getElementById(type + i).style.transform =  "translate("+ block_position[i][0]
    +"px,"+block_position[i][1]+"px)";
    document.getElementById(type + i).style["background-color"] = color;
    
  }
 
 }

 //Starts the game
  function start(){
    draw(shape)
    timer = setInterval(move_down, 1000,shape);
    document.getElementById('button').remove();
  }

//Moves the tetris block downwards
  function move_down(type){
    var mainBlock = document.getElementById(type);
    var offsets = mainBlock.getBoundingClientRect();
    var offsets2 =  grid.getBoundingClientRect();
    var top = offsets.top;
    var top2 = offsets2.top;
    
    let num = top-top2+30;
    var num2 = offsets.left-offsets2.left;
    
    var empty = updateArray(blockY);
    console.log(empty);
    console.log(tetrisArray);
    if(empty == true && top-top2<600-blockHeight){
    blockY += 1;
    mainBlock.style.transform =  "translate("+ num2 +"px,"+num+"px)";}
    if(empty == false){
      
      clearInterval(timer);
      timer = null;
      collision = null;
      shape = selectShape()
      draw(shape)
      orderArray();
      timer = setInterval(move_down, 1000,shape);
    }

  }

//Moves the block right
  function moveRight(type){
    var mainBlock = document.getElementById(type);
    var offsets = mainBlock.getBoundingClientRect();
    var offsets2 =  grid.getBoundingClientRect();
    var top = offsets.top;
    var top2 = offsets2.top;

    let num = top-top2;
    var num2 = offsets.left-offsets2.left +30;
    console.log(blockHeight);
    if(offsets.left-offsets2.left<300-blockWidth){
      blockX += 1;
      mainBlock.style.transform =  "translate("+ num2 +"px,"+num+"px)";}
  }

//Moves the block left
  function moveLeft(type){
    var mainBlock = document.getElementById(type);
    var offsets = mainBlock.getBoundingClientRect();
    var offsets2 =  grid.getBoundingClientRect();
    var top = offsets.top;
    var top2 = offsets2.top;

    let num = top-top2;
    var num2 = offsets.left-offsets2.left -30;

    if(offsets.left-offsets2.left>0){
      blockX -= 1;
    mainBlock.style.transform =  "translate("+ num2 +"px,"+num+"px)";}
  }

//Checks if the arrow keys have been pressed
  function control(e) {
    if(e.keyCode === 37) {
      moveLeft(shape)
    } else if (e.keyCode === 38) {
      rotate()
    } else if (e.keyCode === 39) {
      moveRight(shape)
    } else if (e.keyCode === 40) {
      move_down(shape)
    }
  }
  document.addEventListener('keyup', control)

//Updates the 2d array
  function updateArray(number){
  if(number + blockHeight/30 <20){
      if (tetrisArray[(number + blockHeight/30)][blockX]== " "){
        for(let i = 0; i< blockWidth/30; i++){
          tetrisArray[(number)][(blockX+i)]= "Y";}
      
      return true;
    }else{return false;}
  }else{return false;}
  }

  //Orders the 2d array
  function orderArray(){
    for(let i = 0; i<20;i++){
      if(tetrisArray[i][0] == " "){
      tetrisArray[i][0] = "shape.charAt(0)";
    }}
    // if(tetrisArray[i][0] == "Y" && i == 20-blockHeight){
    //   console.log(222222222222);
    //   for(let y =0; y<blockHeight;y++){
    //     tetrisArray[i+y][0] == "shape.charAt(0)";
    //   }
    // }
    for(let i = 0; i<20;i++){
    if(tetrisArray[i][0] == "Y"){
      tetrisArray[i][0] = " ";
    }}
    return true;
 
    
  }
</script>
</body>
</html>