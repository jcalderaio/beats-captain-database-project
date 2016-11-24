#!/usr/local/bin/php


<?php 
session_start(); 

$search = $_SESSION['search'];

$bar = $_POST['search'];   //Search bar from this page

$start = $_POST['start'];   //Start date

$end = $_POST['end'];   //End date

$num_songs = $_POST['num_songs'];

$radio = $_POST['radio'];

$count_tuples = $_POST['tuple'];

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Artist Page</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mystylesheetArtist.css" rel = "stylesheet">
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
        <h1> Artist Search</h1>
      </div>


    <div id="Search_Section" "width:50%">
      <form action = "artist.php" method="POST" class="form-inline" role="form">
        <div class="form-group">
          <input type="text" class="form-control" name="search" id="mySearch" placeholder="Search">
        </div>
        <button type="submit" id = 'submit' class="btn btn-default">Submit</button>

    </div>
    <div id = 'leftColumn'>
    <button type="button" class="btn btn-default btn-lg" id = 'home' onclick = "link_home()">
     Home
    </button>
  
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


<div id = "rightColumn">

  <div>
    <form class="form-horizontal" role="form">
      
      <b>Number of songs composed:</b> <br> <br>
      <input type="text" name="num_songs" class="form-control" id="SongsComposed" placeholder="Enter a number">
     

  </div>

  <div id = "radioButton">
  
      <label class="radio-inline">
        <input type="radio" name="radio" id="StandardDeviation" value="stand_dev"> Standard Deviation
      </label>
      <label class="radio-inline">
        <input type="radio" name="radio" id="AverageSongTempo" value="avg_temp"> Average Song Tempo
      </label>
      <label class="radio-inline">
        <input type="radio" name="radio" id="AverageSongDuration" value="avg_dur"> Average Song Duration
      </label>
      <label class="radio-inline">
        <input type="radio" name="radio" id="AverageSongPopularity" value="avg_pop"> Average Song Popularity
      </label>

    </div>

    <div id = "Search_by_Year">
      <p id = "myText"> Search By Year </p>
      <label for="exampleInputFile">Start Date</label>
      <input type="date" class="form-control" action="artist.php" method="POST" name="start" id = "StartDate" 		placeholder="Start Year, ex.1930">
      <label for="exampleInputFile">End Date</label>
      <input type="date" class="form-control" action="artist.php"method="POST" name="end" id = "EndDate" 			placeholder="End Year, ex.1990">
    </div>
  </form>
  </div>

<!-- This is the beginning of the php div ----------------------------------------------------------------------------------------->
    
<div style = "position = absolute" id = "position">

<?php


if($bar != NULL && $radio != NULL && $start != NULL && $end != NULL) {

	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	if($radio == "stand_dev") {
		$statement = oci_parse($connection, "SELECT ARTIST.ARTIST_NAME, round(STDDEV(SONG.SONG_DURATION), 3) as Std_Dev_song_durations FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND SONG.SONG_ID = ALBUM.SONG_ID AND UPPER(ARTIST.ARTIST_NAME) LIKE UPPER('%" . $bar . "%') AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' AND rownum <= 100 
		group by ARTIST.ARTIST_NAME order by ARTIST.ARTIST_NAME");
	}
	elseif($radio == "avg_temp") {
		$statement = oci_parse($connection, "SELECT ARTIST.ARTIST_NAME, round(avg(SONG.song_tempo), 3) as AVG_SONG_TEMPO FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND SONG.SONG_ID = ALBUM.SONG_ID AND UPPER(ARTIST.ARTIST_NAME) LIKE UPPER('%" . $bar . "%') AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' AND rownum <= 100 
		group by ARTIST.ARTIST_NAME order by ARTIST.ARTIST_NAME");
	}
	elseif($radio == "avg_dur") {
		$statement = oci_parse($connection, "SELECT ARTIST.ARTIST_NAME, round(avg(SONG.song_duration), 3) as AVG_SONG_DURATION FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND SONG.SONG_ID = ALBUM.SONG_ID AND UPPER(ARTIST.ARTIST_NAME) LIKE UPPER('%" . $bar . "%') AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' AND rownum <= 100 group  
		by ARTIST.ARTIST_NAME order by ARTIST.ARTIST_NAME");
	}
	elseif($radio == "avg_pop") {
		$statement = oci_parse($connection, "SELECT ARTIST.ARTIST_NAME, round(avg(song.song_hotttnesss), 3) as AVG_song_popularity FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND SONG.SONG_ID = ALBUM.SONG_ID AND SONG.SONG_HOTTTNESSS != 0 AND UPPER(ARTIST.ARTIST_NAME) LIKE UPPER('%" . $bar . "%') AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' AND rownum <= 100 group 
		by ARTIST.ARTIST_NAME order by ARTIST.ARTIST_NAME");
	}
	
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
elseif($bar == NULL && $num_songs != NULL && $radio == NULL && $start != NULL && $end != NULL) {

	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	$statement = oci_parse($connection, "SELECT * from (SELECT ARTIST.ARTIST_NAME AS Artist, COUNT(ARTIST.ARTIST_ID) AS Number_of_Songs_Composed
	 FROM ALBUM, ARTIST, SONG WHERE ARTIST.ARTIST_ID = ALBUM.ARTIST_ID AND ARTIST.ARTIST_ID = SONG.ARTIST_ID AND ALBUM_YEAR 
	 BETWEEN '" . $start . "' AND '" . $end . "' group by ARTIST.ARTIST_NAME HAVING (COUNT(ARTIST.ARTIST_ID) >= '" . $num_songs . "' ) 
	 ORDER BY ARTIST.ARTIST_NAME) where rownum <= 100");
	
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
elseif($bar == NULL && $radio == NULL && $start != NULL && $end != NULL && $num_songs == NULL) {

	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	$statement = oci_parse($connection, "SELECT ARTIST.ARTIST_NAME as Artist, SONG.SONG_TITLE as Song, ALBUM.album_name as album, ALBUM.album_year as year, ARTIST.ARTIST_HOTTTNESSS as Popularity 
		FROM SONG, ARTIST, ALBUM WHERE ARTIST.ARTIST_ID = SONG.ARTIST_ID AND SONG.SONG_ID = ALBUM.SONG_ID AND ALBUM_YEAR BETWEEN '" . $start . "' 
		AND '" . $end . "' AND rownum <= 100 group by ARTIST.ARTIST_NAME, ALBUM.album_name, SONG.SONG_TITLE, ALBUM.album_year, ARTIST.ARTIST_HOTTTNESSS ORDER BY ALBUM.ALBUM_YEAR");
	
	
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
elseif($bar == NULL && $radio != NULL && $start != NULL && $end != NULL && $num_songs == NULL) {

	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	if($radio == "stand_dev") {
		$statement = oci_parse($connection, "SELECT ARTIST.ARTIST_NAME as Name, round(STDDEV(SONG.SONG_DURATION), 3) as Std_Dev_song_durations, ALBUM.ALBUM_YEAR AS Year FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND SONG.SONG_ID = ALBUM.SONG_ID AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' AND rownum <= 100 group 
		by ARTIST.ARTIST_NAME, ALBUM.ALBUM_YEAR order by ALBUM.ALBUM_YEAR, ARTIST.ARTIST_NAME");
	}
	elseif($radio == "avg_temp") {
		$statement = oci_parse($connection, "SELECT ARTIST.ARTIST_NAME as Name, round(avg(SONG.song_tempo), 3) as Avg_Song_Tempo, ALBUM.ALBUM_YEAR as Year FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND SONG.SONG_ID = ALBUM.SONG_ID AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' AND rownum <= 100 group 
		by ARTIST.ARTIST_NAME, ALBUM.ALBUM_YEAR order by ALBUM.ALBUM_YEAR, ARTIST.ARTIST_NAME");
	}
	elseif($radio == "avg_dur") {
		$statement = oci_parse($connection, "SELECT ARTIST.ARTIST_NAME as Name, round(avg(SONG.song_duration), 3) as AVG_SONG_DURATION, ALBUM.ALBUM_YEAR as Year FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND SONG.SONG_ID = ALBUM.SONG_ID AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' AND rownum <= 100 group 
		by ARTIST.ARTIST_NAME, ALBUM.ALBUM_YEAR order by ALBUM.ALBUM_YEAR, ARTIST.ARTIST_NAME");
	}
	elseif($radio == "avg_pop") {
		$statement = oci_parse($connection, "SELECT ARTIST.ARTIST_NAME as Name, round(avg(song.song_hotttnesss), 3) as AVG_song_popularity, ALBUM.ALBUM_YEAR as Year FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND SONG.SONG_HOTTTNESSS != 0 AND SONG.SONG_ID = ALBUM.SONG_ID AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' AND rownum <= 100 group 
		by ARTIST.ARTIST_NAME, ALBUM.ALBUM_YEAR order by ALBUM.ALBUM_YEAR, ARTIST.ARTIST_NAME");
	}
	
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
elseif($bar == NULL && $radio == NULL && $start == NULL && $end == NULL && $num_songs !=NULL) {
	
	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	$statement = oci_parse($connection, "SELECT * from (SELECT ARTIST.ARTIST_NAME AS Artist, COUNT(ARTIST.ARTIST_ID) AS Number_of_Songs_Composed, ARTIST.artist_hotttnesss as Popularity
		FROM ARTIST group by ARTIST.ARTIST_NAME, artist_hotttnesss HAVING COUNT(ARTIST.ARTIST_ID) >= '" . $num_songs . "' order by ARTIST.ARTIST_NAME) where rownum <= 100");
	
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
			 echo "<tr><td colspan='4'>No results found for \"".$num_songs.'"</td></tr>';
	}
	
	
}
elseif($bar != NULL && $radio == NULL && $start != NULL && $end != NULL && $num_songs == NULL) {

	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	$statement = oci_parse($connection, "SELECT ARTIST.ARTIST_NAME as Artist, SONG.SONG_TITLE as Song, ALBUM.album_name as album, ALBUM.album_year as year, ARTIST.ARTIST_HOTTTNESSS as Popularity 
		FROM SONG, ARTIST, ALBUM WHERE ARTIST.ARTIST_ID = SONG.ARTIST_ID AND UPPER(ARTIST.ARTIST_NAME) LIKE UPPER('%" . $bar . "%') AND ALBUM_YEAR BETWEEN '" . $start . "' 
		AND '" . $end . "' AND rownum <= 100 group by ARTIST.ARTIST_NAME, ALBUM.album_name, SONG.SONG_TITLE, ALBUM.album_year, ARTIST.ARTIST_HOTTTNESSS order by ARTIST.ARTIST_NAME");
	
	
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
elseif($bar == NULL && $num_songs != NULL && $radio != NULL && $start != NULL && $end != NULL) {

	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	if($radio == "stand_dev") {
		$statement = oci_parse($connection, "SELECT * from (SELECT ARTIST.ARTIST_NAME AS Artist, COUNT(ARTIST.ARTIST_ID) AS Number_of_Songs_Composed,
		round(STDDEV(SONG.SONG_DURATION), 3) AS Std_Dev_Song_Duration FROM ALBUM, ARTIST, SONG WHERE ARTIST.ARTIST_ID = ALBUM.ARTIST_ID 
		AND ARTIST.ARTIST_ID = SONG.ARTIST_ID AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' group by ARTIST.ARTIST_NAME HAVING 
		(COUNT(ARTIST.ARTIST_ID) >= '" . $num_songs . "' ) ORDER BY ARTIST.ARTIST_NAME) where rownum <= 100");
	}
	elseif($radio == "avg_temp") {
		$statement = oci_parse($connection, "SELECT * from (SELECT ARTIST.ARTIST_NAME AS Artist, COUNT(ARTIST.ARTIST_ID) AS Number_of_Songs_Composed,
		round(avg(SONG.song_tempo), 3) AS AVG_SONG_TEMPO FROM ALBUM, ARTIST, SONG WHERE ARTIST.ARTIST_ID = ALBUM.ARTIST_ID 
		AND ARTIST.ARTIST_ID = SONG.ARTIST_ID AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' group by ARTIST.ARTIST_NAME HAVING 
		(COUNT(ARTIST.ARTIST_ID) >= '" . $num_songs . "' ) ORDER BY ARTIST.ARTIST_NAME) where rownum <= 100");
	}
	elseif($radio == "avg_dur") {
		$statement = oci_parse($connection, "SELECT * from (SELECT ARTIST.ARTIST_NAME AS Artist, COUNT(ARTIST.ARTIST_ID) AS Number_of_Songs_Composed,
		round(avg(SONG.song_duration), 3) AS AVG_SONG_DURATION FROM ALBUM, ARTIST, SONG WHERE ARTIST.ARTIST_ID = ALBUM.ARTIST_ID 
		AND ARTIST.ARTIST_ID = SONG.ARTIST_ID AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' group by ARTIST.ARTIST_NAME HAVING 
		(COUNT(ARTIST.ARTIST_ID) >= '" . $num_songs . "' ) ORDER BY ARTIST.ARTIST_NAME) where rownum <= 100");
	}
	elseif($radio == "avg_pop") {
		$statement = oci_parse($connection, "SELECT * from (SELECT ARTIST.ARTIST_NAME AS Artist, COUNT(ARTIST.ARTIST_ID) AS Number_of_Songs_Composed,
		round(avg(SONG.song_hotttnesss), 3) AS AVG_song_popularity FROM ALBUM, ARTIST, SONG WHERE ARTIST.ARTIST_ID = ALBUM.ARTIST_ID 
		AND ARTIST.ARTIST_ID = SONG.ARTIST_ID AND ALBUM_YEAR BETWEEN '" . $start . "' AND '" . $end . "' group by ARTIST.ARTIST_NAME HAVING 
		(COUNT(ARTIST.ARTIST_ID) >= '" . $num_songs . "' ) ORDER BY ARTIST.ARTIST_NAME) where rownum <= 100");
	}
	
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
elseif($bar != NULL && $radio != NULL && $start == NULL && $end == NULL) {

	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	if($radio == "stand_dev") {
		$statement = oci_parse($connection, "SELECT * FROM (SELECT ARTIST.ARTIST_NAME, round(STDDEV(SONG.SONG_DURATION), 3) as Std_Dev_song_durations FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND UPPER(ARTIST.ARTIST_NAME) LIKE UPPER('%" . $bar . "%') group by ARTIST.ARTIST_NAME order by ARTIST.ARTIST_NAME) WHERE rownum <= 100");
	}
	elseif($radio == "avg_temp") {
		$statement = oci_parse($connection, "select * from (SELECT ARTIST.ARTIST_NAME, round(avg(SONG.song_tempo), 3) as AVG_SONG_TEMPO FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND UPPER(ARTIST.ARTIST_NAME) LIKE UPPER('%" . $bar . "%') group 
		by ARTIST.ARTIST_NAME order by ARTIST.ARTIST_NAME) WHERE rownum <= 100");
	}
	elseif($radio == "avg_dur") {
		$statement = oci_parse($connection, "select * from (SELECT ARTIST.ARTIST_NAME, round(avg(SONG.song_duration), 3) as AVG_SONG_DURATION FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND UPPER(ARTIST.ARTIST_NAME) LIKE UPPER('%" . $bar . "%') group 
		by ARTIST.ARTIST_NAME order by ARTIST.ARTIST_NAME) WHERE rownum <= 100");
	}
	elseif($radio == "avg_pop") {
		$statement = oci_parse($connection, "select * from (SELECT ARTIST.ARTIST_NAME, round(avg(song.song_hotttnesss), 3) as AVG_song_popularity FROM SONG, ARTIST, ALBUM WHERE
		ARTIST.ARTIST_ID = SONG.ARTIST_ID AND SONG.SONG_HOTTTNESSS != 0 AND UPPER(ARTIST.ARTIST_NAME) LIKE UPPER('%" . $bar . "%') group 
		by ARTIST.ARTIST_NAME order by ARTIST.ARTIST_NAME) WHERE rownum <= 100");
	}
	
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

elseif($bar != NULL && $radio == NULL && $start == NULL && $end == NULL) {

	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	$statement = oci_parse($connection, "SELECT ARTIST_NAME as Artist, SONG_TITLE as Song, album_name as album, album_year as year, ARTIST_HOTTTNESSS as Popularity 
	FROM ARTIST, SONG, ALBUM WHERE ARTIST.ARTIST_ID = SONG.ARTIST_ID and artist.artist_id = album.artist_id AND UPPER(artist_name) LIKE UPPER('%" . $bar . "%') AND rownum <= 100 order by ARTIST.ARTIST_NAME");
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
elseif($bar == NULL && $num_songs != NULL && $radio != NULL && $start == NULL && $end == NULL) {

	$connection = oci_connect('KTufekci',
	                          'LarLar2014',
	                          '//oracle.cise.ufl.edu/orcl');
	
	if( !$connection ) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	if($radio == "stand_dev") {
		$statement = oci_parse($connection, "SELECT * from (SELECT ARTIST.ARTIST_NAME AS Artist, COUNT(ARTIST.ARTIST_ID) AS Number_of_Songs_Composed,
		round(STDDEV(SONG.SONG_DURATION), 3) AS Std_Dev_Song_Duration FROM ALBUM, ARTIST, SONG WHERE ARTIST.ARTIST_ID = ALBUM.ARTIST_ID 
		AND ARTIST.ARTIST_ID = SONG.ARTIST_ID group by ARTIST.ARTIST_NAME HAVING 
		(COUNT(ARTIST.ARTIST_ID) >= '" . $num_songs . "' ) ORDER BY ARTIST.ARTIST_NAME) where rownum <= 100");
	}
	elseif($radio == "avg_temp") {
		$statement = oci_parse($connection, "SELECT * from (SELECT ARTIST.ARTIST_NAME AS Artist, COUNT(ARTIST.ARTIST_ID) AS Number_of_Songs_Composed,
		round(avg(SONG.song_tempo), 3) AS AVG_SONG_TEMPO FROM ALBUM, ARTIST, SONG WHERE ARTIST.ARTIST_ID = ALBUM.ARTIST_ID 
		AND ARTIST.ARTIST_ID = SONG.ARTIST_ID group by ARTIST.ARTIST_NAME HAVING 
		(COUNT(ARTIST.ARTIST_ID) >= '" . $num_songs . "' ) ORDER BY ARTIST.ARTIST_NAME) where rownum <= 100");
	}
	elseif($radio == "avg_dur") {
		$statement = oci_parse($connection, "SELECT * from (SELECT ARTIST.ARTIST_NAME AS Artist, COUNT(ARTIST.ARTIST_ID) AS Number_of_Songs_Composed,
		round(avg(SONG.song_duration), 3) AS AVG_SONG_DURATION FROM ALBUM, ARTIST, SONG WHERE ARTIST.ARTIST_ID = ALBUM.ARTIST_ID 
		AND ARTIST.ARTIST_ID = SONG.ARTIST_ID group by ARTIST.ARTIST_NAME HAVING 
		(COUNT(ARTIST.ARTIST_ID) >= '" . $num_songs . "' ) ORDER BY ARTIST.ARTIST_NAME) where rownum <= 100");
	}
	elseif($radio == "avg_pop") {
		$statement = oci_parse($connection, "SELECT * from (SELECT ARTIST.ARTIST_NAME AS Artist, COUNT(ARTIST.ARTIST_ID) AS Number_of_Songs_Composed,
		round(avg(SONG.song_hotttnesss), 3) AS AVG_song_popularity FROM ALBUM, ARTIST, SONG WHERE ARTIST.ARTIST_ID = ALBUM.ARTIST_ID 
		AND ARTIST.ARTIST_ID = SONG.ARTIST_ID group by ARTIST.ARTIST_NAME HAVING 
		(COUNT(ARTIST.ARTIST_ID) >= '" . $num_songs . "' ) ORDER BY ARTIST.ARTIST_NAME) where rownum <= 100");
	}
	
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
	$statement = oci_parse($connection, "SELECT ARTIST_NAME as Artist, SONG_TITLE as Song, album_name as album, album_year as year, ARTIST_HOTTTNESSS as Popularity 
	FROM ARTIST, SONG, ALBUM WHERE ARTIST.ARTIST_ID = SONG.ARTIST_ID and artist.artist_id = album.artist_id AND UPPER(artist_name) LIKE UPPER('%" . $search . "%') AND rownum <= 100 order by ARTIST.ARTIST_NAME");
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
  </body>
</html>
