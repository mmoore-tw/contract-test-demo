<?php

define("JENKINS_USER", 'jenkins');
define("JENKINS_PASSWORD", 'T55iwB4kJVrWDoUR41m4oYNvzJq7EpQ9');
define("ARTIFACTORY_URL", 'https://box.artifactoryonline.com/box');
define("ARTIFACTORY_PATH", 'box-maven-snapshots/net/box/infra/scala/contracts');

define("CONTRACT_OUTPUT", "contracts");
define("CONTRACT_INPUT", "contracts");



//function getContractManifest()
//{
//    downloadFromRepository("latest.txt", TEST_OUTPUT);
//
//    $contracts = explode('\n', file_get_contents(TEST_OUTPUT . "/latest.txt"));
//
//    foreach ($contracts as $contract) {
//        downloadFromRepository(rtrim($contract), DEFAULT_PROVIDER_CONTRACTS);
//    }
//}

//function downloadFromRepository($filename, $localDest = null)
//{
//    $localDest = isset($localDest) ? $localDest : TEST_OUTPUT;
//
//    $b64 = base64_encode(sprintf("%s:%s", JENKINS_USER, JENKINS_PASSWORD));
//    $auth = "Authorization: Basic $b64";
//    $opts = array(
//            'http' => array(
//                    'method' => "GET",
//                    'header' => $auth,
//                    'user_agent' => "PHPUnit",
//            )
//    );
//
//    $url = sprintf("%s/%s/%s", ARTIFACTORY_URL, ARTIFACTORY_PATH, $filename);
//    $context = stream_context_create($opts);
//    file_put_contents(sprintf("%s/%s", $localDest, $filename), fopen($url, 'r', false, $context));
//}
