<?php
/**
 * Listing all hot places of particual city
 * method GET
 * url /specials         
 */
$app->get('/specials/allofplacefor/:place_id/:datetime', function($place_id, $datetime) {
            global $user_id;
            $response = array();
            $db = new DbHandler();
 
            // fetching all user tasks
            $result = $db->getSpecialsOf($place_id, $datetime);
 
            $response["error"] = false;
            $response["specials"] = array();
 
            // looping through result and preparing places array
            while ($specials = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["title"] = utf8_encode($specials["title"]);
                $tmp["price"] = utf8_encode($specials["price"]);
                $tmp["currency_simbol"] = utf8_encode($specials["currency_simbol"]);
                $tmp["code"] = utf8_encode($specials["code"]);
				$tmp["image"] = utf8_encode($specials["image"]);
				$tmp['from_date'] = utf8_encode($specials["from_date"]);
				$tmp['to_date'] = utf8_encode($specials["to_date"]);
				$tmp['days_of_week'] = utf8_encode($specials["sunday"] == "1" ? "1," : "");
				$tmp['days_of_week'] = $tmp['days_of_week'] . utf8_encode($specials["monday"] == "1" ? "2," : "");
				$tmp['days_of_week'] = $tmp['days_of_week'] . utf8_encode($specials["tuesday"] == "1" ? "3," : "");
				$tmp['days_of_week'] = $tmp['days_of_week'] . utf8_encode($specials["wednsday"] == "1" ? "4," : "");
				$tmp['days_of_week'] = $tmp['days_of_week'] . utf8_encode($specials["thursday"] == "1" ? "5," : "");
				$tmp['days_of_week'] = $tmp['days_of_week'] . utf8_encode($specials["friday"] == "1" ? "6," : "");
				$tmp['days_of_week'] = $tmp['days_of_week'] . utf8_encode($specials["saturday"] == "1" ? "7" : "");
                array_push($response["specials"], $tmp);
            }
 
            echoRespnse(200, $response);
        });