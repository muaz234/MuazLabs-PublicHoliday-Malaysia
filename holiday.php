<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;

require_once 'credentials.php';
require_once 'connect.php';
require 'vendor/autoload.php';
$client = new Client();
$data = array();
$states_affected = array();
$datetime = new DateTime();
$count = 0;
try {
    $response = $client->get('https://calendarific.com/api/v2/holidays', ['query' => ['api_key' => $token, 'country' => 'MY', 'year' => 2020]]);

} catch(RequestException $e)
{
    echo Psr7\str($e->getRequest());
    if($e->hasResponse())
    {
        echo Psr7\str($e->getResponse());
    }
    die();
}
if($response->getStatusCode() == 200)
{
    $body = $response->getBody()->getContents();
    $array = json_decode($body, true);
    foreach ($array['response']['holidays'] as $holidays)
    {
        // check for holiday type
        if(is_array($holidays['type']))
        {
            // check value in array either national holiday or common local holiday only
            if(in_array("National holiday", $holidays['type']) || in_array("Common local holiday", $holidays['type']))
            {
                $data['type'] = implode(', ', $holidays['type']);
                if(!empty($holidays['name']))
                {
                    $data['name'] = $holidays['name'];
                }
                if(!empty($holidays['description']))
                {
                    $data['description'] = $holidays['description'];
                }
                // get date of holiday
                if(!empty($holidays['date']) && is_array($holidays['date']))
                {
                    $data['date'] = $holidays['date']['iso'];
                    $mutable = Carbon::parse($holidays['date']['iso']);
                    $data['day'] = $mutable->isoFormat('dddd');
                }
                // get locations(states) of the holiday
                if(!empty($holidays['locations']))
                {
                    $data['locations'] = $holidays['locations'];
                }
                // get states if available
                if(!empty($holidays['states']))
                {
                    if(is_array($holidays['states']))
                    {
                        foreach ($holidays['states'] as $states)
                        {
                            // add states name to array
                            array_push($states_affected, $states['name']);
                        }

                        $data['states'] = json_encode($states_affected);
//                                dd(implode(', ', $states_affected));
                        $states_affected = [];

                    }
                    else
                    {
                        $data['states'] = $holidays['states'];
                    }
                }
                // flag for affected holiday
                $data['active'] = 1;
                $data['created_at'] = $datetime->format('Y-m-d H:i:s');;
                $data['updated_at'] = $datetime->format('Y-m-d H:i:s');;
                $columns = implode(", " , array_keys($data));
                $escaped_value = array_map(array($db, 'real_escape_string'), array_values($data));
                $values = implode("', '", $escaped_value);
                $sql = "INSERT INTO `holidays` ($columns) VALUES ('$values')";
                $exec = mysqli_query($db, $sql) or die(mysqli_error($db));
                $count++;
            }
        }
    }
    echo ($count > 0) ?  json_encode(['success' => true, 'status' => 'inserted success', 'Rows inserted' => $count], 201) : json_encode(['success' => false, 'status' => 'failed. please see your error logs' ], 500) ;
}