<?php

function checkAndPrepareParams($request, $params = [], $additionalParams = []): array
{
    $result = [];

    foreach ($params as $param) {
        if ( ! isset($request[$param])) {
            echo "обязательные параметры не переданы";
            die;
        }
        $result[$param] = $request[$param];
    }

    foreach ($additionalParams as $additionalParam) {
        if ( ! isset($request[$additionalParam])) {
            $result[$additionalParam] = NULL;
            continue;
        }
        $result[$additionalParam] = $request[$additionalParam];
    }

    return ($result);
}