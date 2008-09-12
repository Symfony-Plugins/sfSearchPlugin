<?php

if (file_exists(dirname(__FILE__) . '/constants.php'))
{
  include dirname(__FILE__) . '/constants.php';
}

if (!defined('SF_LIB_DIR'))
{
  die('Please define a SF_LIB_DIR constant.');
}

set_include_path(get_include_path() . PATH_SEPARATOR . SF_LIB_DIR);
