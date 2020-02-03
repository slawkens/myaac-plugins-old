<?php

if(getSession('user_landed') == false) {
	header('Location: landing/');
	exit();
}

?>