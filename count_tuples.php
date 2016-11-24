#!/usr/local/bin/php

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Home Page</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mystylesheetHome.css" rel = "stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="myScript.js"></script>
  </head>
  <body>
    <div class = 'container'>
      <div id = 'header'> 
        <img src = 'index_files/image3651.png' id = 'image'/>
        <h1> The Beats Captain</h1>
      </div>
      
      <div style="position: relative;top: 200px; left: 700px; font-size:150%">
		 Tuple Count: 110001
      </div>

  <div id="Search_Section" "width:50%">
    <form action = "choose.php" method="POST" class="form-inline" role="form">
        <div class="form-group">
          <input type="text" class="form-control" name="search" id="mySearch" placeholder="Search">
           <select class="form-control selectpicker" id = 'select' name="selection">
            <option value = "artist"> Artist </option>
            <option value = "song"> Song </option>
            <option value = "album"> Album </option>
          </select>
          <!--<div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Artist <span class="caret"></span>
          </button>
          <<ul class="dropdown-menu" role="menu">
          <li><a href="#">Song</a></li>
          <li><a href="#">Album</a></li>
          </ul>
        </div>-->

        </div>
        <button type="submit" id = 'submit' class="btn btn-default">Submit</button>
    </form>
      
  </div>

      
  <div id = 'leftColumn'>
    <button type="button" class="btn btn-default btn-lg" id = 'home' onclick = "link_home()">
     Home
    </button>
    <!--<button type="button" class="btn btn-default btn-lg" id = 'aboutUs'>
     About Us
    </button>-->
    <button type="button" class="btn btn-default btn-lg" id = 'artistSearch' onclick= "link_artist()">
     Artist Search
    </button>
    <button type="button" class="btn btn-default btn-lg" id = 'albumSearch' onclick = "link_album()">
     Album Search
    </button>
    <button type="button" class="btn btn-default btn-lg" id = 'songSearch' onclick= "link_song()">
     Song Search
    </button>
  </div>
  
  </div>
  </div>
  </body>
</html>
