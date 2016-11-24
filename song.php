#!/usr/local/bin/php


<?php 
session_start(); 

$search = $_SESSION['search'];   //Input from main page

$bar = $_POST['search'];   //Search bar from this page

$start = $_POST['start'];   //Start date

$end = $_POST['end'];   //End date

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Song Page</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mystylesheetSong.css" rel = "stylesheet">
    <link href="css/style.css" rel = "stylesheet">
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
      
      <form action="count_tuples.php">
      <div id = 'count'> 
         <button type="sumbit" class="btn btn-default">Count Tuples</button>
      </div>
	</form>
      
      <div id = 'search_header'> 
        <h1> Song Search</h1>
      </div>


    <div id="Search_Section" "width:50%">
      <form action = "song.php" method="POST" class="form-inline" role="form">
        <div class="form-group">
          <input type="text" class="form-control" name="search" id="mySearch" placeholder="Search">
        </div>
        <button type="submit" id = 'submit' class="btn btn-default">Submit</button>
  </div>
  
  
  <div id = 'leftColumn'>
    <button type="button" class="btn btn-default btn-lg" id = 'home' onclick = "link_home()">
     Home
    </button>
    <!--<button type="button" class="btn btn-default btn-lg" id = 'aboutUs'>
     About Us
    </button>-->
    <button type="button" class="btn btn-default btn-lg" id = 'artistSearch' onclick = "link_artist()">
     Artist Search
    </button>
    <button type="button" class="btn btn-default btn-lg" id = 'albumSearch' onclick = "link_album()">
     Album Search
    </button>
    <button type="button" class="btn btn-default btn-lg" id = 'songSearch' onclick = "link_song()">
     Song Search
    </button>
  </div>

  <div id = "Search_by_Year">
      <p> Search By Year </p>
      <label for="exampleInputFile">Start Year</label>
      <input type="date" class="form-control" action="song.php" method="POST" name="start" id = "StartDate" 		placeholder="Start Year, ex.1930">
      <label for="exampleInputFile">End Year</label>
      <input type="date" class="form-control" action="song.php"method="POST" name="end" id = "EndDate" 			placeholder="End Year, ex.1990">
    </div>
    </form>

  
    
    
    
<!-- This is the beginning of the php div -->
    
    
    
<div style = "position = absolute" id = "position">

<?php

if($bar != NULL && $start == NULL && $end == NULL) {
	
	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	$statement = oci_parse($connection, "SELECT SONG_TITLE as Song_Title, ARTIST_NAME as Artist, SONG_HOTTTNESSS as Song_Popularity, ALBUM_NAME AS Album_Name, 
	ALBUM_YEAR AS Year, SONG_DURATION AS Duration, SONG_TEMPO AS Tempo FROM ARTIST, SONG, ALBUM WHERE ARTIST.ARTIST_ID = SONG.ARTIST_ID AND ARTIST.ARTIST_ID = ALBUM.ARTIST_ID 
	AND UPPER(SONG_TITLE) LIKE UPPER('%" . $bar . "%') AND rownum <= 100 ORDER BY SONG_TITLE, ARTIST_NAME");
	oci_execute($statement);
	
	
	if(oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
	
	echo "<table id=\"rounded-corner\" style=\"width:relative\">\n";
	$ncols = oci_num_fields($statement);
	echo "<tr>\n";
	for ($i = 1; $i <= $ncols; ++$i) {
	    $colname = oci_field_name($statement, $i);
	    echo "  <th><b>".htmlentities($colname, ENT_QUOTES)."</b></th>\n";
	}
	echo "</tr>\n";
	
	while (($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	     echo "<tr>\n";
	     foreach ($row as $item) {
	          echo "  <td>".($item !== null ? htmlentities($item, ENT_QUOTES):" ")."</td>\n";
	     }
	    echo "</tr>\n";
	}
	echo "</table>\n";  
	
	oci_free_statement($statement);
	oci_close($connection); }
	
	else {
			 echo "<tr><td colspan='4'>No results found for \"".$bar.'"</td></tr>';
	}
	
}
elseif($bar == NULL && $start != NULL && $end != NULL) {
	
	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	$statement = oci_parse($connection, "SELECT SONG_TITLE as Song_Title, ARTIST_NAME as Artist, SONG_HOTTTNESSS as Song_Popularity, ALBUM_NAME AS Album_Name, 
	ALBUM_YEAR AS Year, SONG_DURATION AS Duration, SONG_TEMPO AS Tempo FROM ARTIST, SONG, ALBUM WHERE ARTIST.ARTIST_ID = SONG.ARTIST_ID AND ARTIST.ARTIST_ID = ALBUM.ARTIST_ID
	AND ALBUM.ALBUM_YEAR BETWEEN '" . $start . " 'AND '" . $end . "' AND rownum <= 100 ORDER BY SONG_TITLE, ARTIST_NAME");
	oci_execute($statement);
	
	
	if(oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
	
	echo "<table id=\"rounded-corner\" style=\"width:relative\">\n";
	$ncols = oci_num_fields($statement);
	echo "<tr>\n";
	for ($i = 1; $i <= $ncols; ++$i) {
	    $colname = oci_field_name($statement, $i);
	    echo "  <th><b>".htmlentities($colname, ENT_QUOTES)."</b></th>\n";
	}
	echo "</tr>\n";
	
	while (($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	     echo "<tr>\n";
	     foreach ($row as $item) {
	          echo "  <td>".($item !== null ? htmlentities($item, ENT_QUOTES):" ")."</td>\n";
	     }
	    echo "</tr>\n";
	}
	echo "</table>\n";  
	
	oci_free_statement($statement);
	oci_close($connection); }
	
	else {
			 echo "<tr><td colspan='4'>No results found for \"".$bar.'"</td></tr>';
	}
	
}
elseif($bar != NULL && $start != NULL && $end != NULL) {
	
	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	$statement = oci_parse($connection, "SELECT SONG_TITLE as Song_Title, ARTIST_NAME as Artist, SONG_HOTTTNESSS as Song_Popularity, ALBUM_NAME AS Album_Name, 
	ALBUM_YEAR AS Year, SONG_DURATION AS Duration, SONG_TEMPO AS Tempo FROM ARTIST, SONG, ALBUM WHERE ARTIST.ARTIST_ID = SONG.ARTIST_ID AND ARTIST.ARTIST_ID = 
	ALBUM.ARTIST_ID AND UPPER(SONG_TITLE) LIKE UPPER('%" . $bar . "%') AND ALBUM.ALBUM_YEAR BETWEEN '" . $start . " 'AND '" . $end . "' AND rownum <= 100 ORDER BY SONG_TITLE, ARTIST_NAME");
	oci_execute($statement);
	
	
	if(oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
	
	echo "<table id=\"rounded-corner\" style=\"width:relative\">\n";
	$ncols = oci_num_fields($statement);
	echo "<tr>\n";
	for ($i = 1; $i <= $ncols; ++$i) {
	    $colname = oci_field_name($statement, $i);
	    echo "  <th><b>".htmlentities($colname, ENT_QUOTES)."</b></th>\n";
	}
	echo "</tr>\n";
	
	while (($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	     echo "<tr>\n";
	     foreach ($row as $item) {
	          echo "  <td>".($item !== null ? htmlentities($item, ENT_QUOTES):" ")."</td>\n";
	     }
	    echo "</tr>\n";
	}
	echo "</table>\n";  
	
	oci_free_statement($statement);
	oci_close($connection); }
	
	else {
			 echo "<tr><td colspan='4'>No results found for \"".$bar.'"</td></tr>';
	}
	
}
elseif($search != NULL) {
	
	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	$statement = oci_parse($connection, "SELECT SONG_TITLE as Song_Title, ARTIST_NAME as Artist, SONG_HOTTTNESSS as Song_Popularity, ALBUM_NAME AS Album_Name, ALBUM_YEAR AS Year, SONG_DURATION AS Duration, SONG_TEMPO AS Tempo 
	FROM ARTIST, SONG, ALBUM WHERE ARTIST.ARTIST_ID = SONG.ARTIST_ID AND ARTIST.ARTIST_ID = ALBUM.ARTIST_ID AND UPPER(SONG_TITLE) LIKE UPPER('%" . $search . "%') AND rownum <= 100 ORDER BY 
	SONG_TITLE, ARTIST_NAME");
	oci_execute($statement);
	
	
	if(oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
	
	echo "<table id=\"rounded-corner\" style=\"width:relative\">\n";
	$ncols = oci_num_fields($statement);
	echo "<tr>\n";
	for ($i = 1; $i <= $ncols; ++$i) {
	    $colname = oci_field_name($statement, $i);
	    echo "  <th><b>".htmlentities($colname, ENT_QUOTES)."</b></th>\n";
	}
	echo "</tr>\n";
	
	while (($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	     echo "<tr>\n";
	     foreach ($row as $item) {
	          echo "  <td>".($item !== null ? htmlentities($item, ENT_QUOTES):" ")."</td>\n";
	     }
	    echo "</tr>\n";
	}
	echo "</table>\n";  
	
	oci_free_statement($statement);
	oci_close($connection); }
	
	else {
			 echo "<tr><td colspan='4'>No results found for \"".$search.'"</td></tr>';
	}
	
}



else {
	echo "<tr><td colspan='4'>You haven't entered a search query</td></tr>";
}
	
	?>
	
</div>

  
  
  
 
 
 
 </div>
 


	</div>
  </body>
</html>


