<?php
session_start();
require 'functions.php';
session_destroy();
update_logged_out(connect());
redirectTo('index.php');