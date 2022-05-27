<?php
function callAPI($method, $url, $data)
{
    $curl = curl_init();
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'APIKEY: 111111111111111111111',
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    // if (!$result) {
    //     curl_close($curl);
    // }
    curl_close($curl);
    return $result;
}

/**
 * Get the given variable from $_REQUEST or from the url
 * @param string $variableName
 * @param mixed $default
 * @return mixed|null
 */
function getParam($variableName, $default = null)
{

    // Was the variable actually part of the request
    if (array_key_exists($variableName, $_REQUEST))
        return $_REQUEST[$variableName];

    // Was the variable part of the url
    $urlParts = explode('/', preg_replace('/\?.+/', '', $_SERVER['REQUEST_URI']));
    $position = array_search($variableName, $urlParts);
    if ($position !== false && array_key_exists($position + 1, $urlParts))
        return $urlParts[$position + 1];

    return $default;
}

class User
{
    public $id;
    public $email;
    public $password;
    public $firstName;
    public $lastName;
    public $permissionLevel;
}
