<?php
declare(strict_types=1);
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('vendor/autoload.php');


use App\Controllers\Jobs\Jobs;
use App\Models\Provider\Provider;


$additionalConnectOptions = [CURLOPT_CONNECTTIMEOUT => 120];

$provider = new Provider($additionalConnectOptions);
$jobsData = $provider->getAllJobsOffer();

$jobs = new Jobs();
$jobs->setJobsData($jobsData);

// only test - get offer jobs from isntance jobs class
$jobsInstance = $jobs->getAllData();
var_dump($jobsInstance);
