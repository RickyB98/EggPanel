<?php
require "global.php";
  if (preg_match("/^\/?$/i", $_SERVER['REQUEST_URI'])) {
    $page = "index";
    include "frontend/index.php";
  } elseif (preg_match("/^\/dashboard\/?$/i", $_SERVER['REQUEST_URI'])) {
    $page = "index";
    include "dash/index.php";
  } elseif (preg_match("/^\/dashboard\/([A-Za-z0-9]+)\/?$/i", $_SERVER['REQUEST_URI'], $match)) {
    $page = strtolower($match[1]);
    include "dash/index.php";
  } elseif (preg_match("/^\/([A-Za-z0-9]+)\/?$/i", $_SERVER['REQUEST_URI'], $match)) {
    $page = strtolower($match[1]);
    include "frontend/index.php";
  } elseif (preg_match("/^\/dashboard\/([A-Za-z0-9]+)\/([A-Za-z0-9]+)\/?$/i", $_SERVER['REQUEST_URI'], $match)) {
    $page = strtolower($match[1]);
    $arg = strtolower($match[2]);
    include "dash/index.php";
  } else {
    $page = "404";
    include "frontend/index.php";
  }
