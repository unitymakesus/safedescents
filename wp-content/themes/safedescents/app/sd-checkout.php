<?php
/**
 * This file contains functions that will get and push data from and to the Safe Descents API
 */

namespace App;

require_once('sdk/SafeDescents.php');

function sd_checkout() {
  return var_dump($_REQUEST);
}
