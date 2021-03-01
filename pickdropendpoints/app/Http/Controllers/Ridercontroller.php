<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Rider;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Ridercontroller extends Controller
{
    public function calccoordinate($location, $type){
        $client = new Client();
        $request =  $client->post('https://maps.googleapis.com/maps/api/geocode/json?address=' .$location. '&key=AIzaSyDonkw-wV3f4KQAA5X9eZrm2S0OngR4Adc')->getBody();
        $json= json_decode($request)->results[0]->geometry->location;

        switch ($type) {
            case 'latitude':
                return $json->lat;
                break;

            default:
                return $json->lng;
                break;
        }
    }

    public function allriders($lat, $long, $vehicle_type){
       $latitude = $lat;
       $longitude = $long;
       $allriders = [];
       
       $riders = Rider::where('online_status', 'online')->where('vehicle_type', $vehicle_type)->selectRaw('*, ( 6367 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $latitude])->having('distance', '<', 30)->orderBy('distance')->get();

        foreach ($riders as  $rider) {
            $result = User::where('uuid', $rider['user_id'])->get();
            $signal['onesignal_id'] = $result[0]->onesignal_id;
            
            array_push($allriders,(array_merge($rider->toArray(), $signal)));
        }

        return $allriders;
    }

    public function locationfinder($from_address, $to_address, $vehicle_type){
        $client = new Client();

        $to_latitude = $this->calccoordinate($to_address, 'latitude');
        $to_longitude = $this->calccoordinate($to_address, 'longitude');

        $from_latitude = $this->calccoordinate($from_address, 'latitude');
        $from_longitude = $this->calccoordinate($from_address , 'londitude');

        $container = array();
        $result = array();

        foreach($this->allriders($from_latitude, $from_longitude, $vehicle_type) as $rider){
            array_push($container, $rider);
        }
        shuffle($container);

        $getdistance = $client->post('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$from_address.'&destinations='.$to_address.'&key=AIzaSyDonkw-wV3f4KQAA5X9eZrm2S0OngR4Adc')->getBody();
        $getdistance= json_decode($getdistance);

        $travel_time = $getdistance->rows[0]->elements[0]->duration->value/60;
        $travel_distance = $getdistance->rows[0]->elements[0]->distance->value ;

        $car['base_rate'] = 3.20;
        $car['cost'] = (8 * $travel_time) / 10;
        $car['total_cost'] = (int) ($car['base_rate'] + $car['cost']);

        $truck['base_rate'] = 5.10;
        $truck['cost'] = (11 * $travel_time) / 10;
        $truck['total_cost'] = (int) ($truck['base_rate'] + $truck['cost']);

        // \dd($from_latitude, $from_longitude, $to_latitude, $to_longitude);
        // array_push($result, $getdistance);
        $result['status'] = count($container) > 0 ? 'success' : 'failed';
        $result['message'] = count($container) > 0 ? 'Details retrieved successfully' : 'Rider not found';
        $result['rider_detail'] = count($container) > 0 ? $container[0] : null;
        $result['truck'] = $truck;
        $result['car'] = $car;

        return response()->json($result);

    }

    
}
