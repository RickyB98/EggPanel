<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require "global.php";
  if (preg_match("/^\/?$/i", $_SERVER['REQUEST_URI'])) {
    $page = "index";
    include "frontend/index.php";
  } elseif (preg_match("/^\/dashboard\/?$/i", $_SERVER['REQUEST_URI'])) {
    $page = "index";
    include "dash/index.php";
  } elseif (preg_match("/^\/dashboard\/(\S+)\/?$/i", $_SERVER['REQUEST_URI'], $match)) {
    $page = strtolower($match[1]);
    include "dash/index.php";
  } elseif (preg_match("/^\/(\S+)\/?$/i", $_SERVER['REQUEST_URI'], $match)) {
    $page = strtolower($match[1]);
    include "frontend/index.php";
  } else {
    $page = "404";
    include "frontend/index.php";
  }
