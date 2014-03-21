<?php

$intOpts = array(
    'options' => array(
        'min_range' => 1,
    ),
);

// get value via /proc/cpuinfo
$numOfCores = shell_exec('/usr/bin/lscpu | /bin/grep -E \'^CPU\\(s\\):\' | /usr/bin/awk \'{print $2}\'');
$numOfCores = filter_var(
    $numOfCores[0],
    FILTER_VALIDATE_INT,
    $intOpts
);

// If number of cores is not found, run fallback
if ($numOfCores === false) {
    $numOfCores = filter_var(
        shell_exec('/usr/bin/nproc'),
        FILTER_VALIDATE_INT,
        $intOpts
    );
}

if ($numOfCores === false) {
    $numOfCores = 'unknown';
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($numOfCores);
