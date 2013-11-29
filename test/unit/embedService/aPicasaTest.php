<?php

/**
 * aPicasa tests.
 */
include dirname(__FILE__).'/../../bootstrap/unit.php';


 
$t = new lime_test(1);

$user = '117691556920140787386';

$service = new aPicasa();
$results = $service->browseUser($user, 4, 30);

echo "\n";
echo count($results['results']);
echo "\n";

$t->pass('This test always passes.');
