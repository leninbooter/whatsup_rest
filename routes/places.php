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

$app->get('/place/getevents/:place_id/:datetime', function($place_id, $datetime) {
		$response = array();
            $db = new DbHandler();
 
            // fetching all user tasks
            $result = $db->getEventsFrom($place_id, $datetime);
 
            $response["error"] = false;
            $response["events"] = array();
			$tmp = array();
			$tmp["pk_event_id"] = "";
			$tmp["title"] = "";
			$tmp["datetime_from"] = "";
			$tmp["datetime_to"] = "";			
			$tmp["pictures"] = array();
			$pk_event_id_last = 0;
			$i = 0;
			$first = true;
			// looping through result and preparing places array
            while ($item = $result->fetch_assoc()) {						
				if( $pk_event_id_last != $item["pk_event_id"] && !$first ) {
					array_push($response["events"], $tmp);
					$tmp = array();
				}
				$tmp["pk_event_id"] = utf8_encode($item["pk_event_id"]);
				$tmp["title"] = utf8_encode($item["title"]);
				$tmp["datetime_from"] = utf8_encode($item["datetime_from"]);
				$tmp["datetime_to"] = utf8_encode($item["datetime_to"]);
				if( $first) {
					$pk_event_id_last = $tmp["pk_event_id"];
					$first = false;
				}
				
				if( $pk_event_id_last != $item["pk_event_id"] ) {
					$tmp["pictures"] = array();
					$pic = array();					
					
				}else {
					$pic = array();
					
				}
				$pic["source"] = utf8_encode($item["source"]);
				$pic["gp_html_attributions"] = utf8_encode($item["gp_html_attributions"]);
				array_push($tmp["pictures"], $pic);
				$pk_event_id_last = $tmp["pk_event_id"];				
							
			}
			array_push($response["events"], $tmp);
			echoRespnse(200, $response);
			
		});		