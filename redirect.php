<?php

use Unisante\SaveAndReturnLater\SaveAndReturnLater;


$record_id = $_REQUEST['record'];

$saveAndReturnLater = new SaveAndReturnLater();
$saveAndReturnLater->redirect($project_id, $record_id);
