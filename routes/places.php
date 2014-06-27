<?php
/**
 * Listing all hot places of particual city
 * method GET
 * url /hotplaces         
 */
$app->get('/hotplaces/:city_id', function($city_id) {
            global $user_id;
            $response = array();
            $db = new DbHandler();
 
            // fetching all user tasks
            $result = $db->getHotPlacesAt($city_id);
 
            $response["error"] = false;
            $response["places"] = array();
 
            // looping through result and preparing places array
            while ($place = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["pk_place_id"] = utf8_encode($place["pk_place_id"]);
                $tmp["name"] = utf8_encode($place["name"]);
                $tmp["geolocation"] = utf8_encode($place["geolocation"]);
                $tmp["gp_formatted_address"] = utf8_encode($place["gp_formatted_address"]);
				$tmp["gp_icon"] = utf8_encode($place["gp_icon"]);
				$tmp["gp_url_website"] = utf8_encode($place["gp_url_website"]);
				$tmp["capacity"] = utf8_encode($place["capacity"]);
				$tmp["fullness"] = utf8_encode($place["fullness"]);
                array_push($response["places"], $tmp);
            }
 
            echoRespnse(200, $response);
        });