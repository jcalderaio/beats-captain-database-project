#!/usr/local/bin/php


<?php
session_start();

$_SESSION['search'] = $_POST['search'];


if($_POST['selection'] == "artist") {
	
	header('Location: artist.php');
}
elseif($_POST['selection'] == "song") {
	
	header('Location: song.php');
}
elseif($_POST['selection'] == "album") {
	
	header('Location: album.php');
}



?>
