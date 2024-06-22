<?php

function request(string $name = null, $fallback = null)
{
    $request = array_merge($_GET, $_POST);

    if ($name) {
        if (!isset($request[$name])) {
            return $fallback;
        }
        return $request[$name];
    }

    return $request;
}

function response(array $data = [])
{
    header('Content-type: application/json');

    echo json_encode($data);
    exit;
}

function requestValidate(array $requests) 
{
    $status = true;

    $data = request();

    foreach ($requests as $key => $request) {
        if (!isset($data[$request])) {
            $status = false;
        }
    }

    return $status;
}