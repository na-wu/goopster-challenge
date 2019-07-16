<?php 

    //line break constant
    $br = "<br>";

    //  open_hours sample formats:
    $someJson = '{"MON":"CLOSED",
    "TUE":"09:00-17:00",
    "WED":"09:00-17:00,19:00-03:00",
    "THU":"09:00-17:00",
    "FRI":"09:00-17:00,22:00-03:00",
    "SAT":"ALL",
    "SUN":"ALL"
    }';

    $closedEveryday = '{"ALL":"CLOSED"}';
    $closedEveryday1 = '{"ALL":"-1"}';
    $openEveryday = '{"ALL":"ALL"}';
    $openEveryday1 = '{"ALL":"1"}';
    $allCrossdays = '{"ALL":"9:00-17:00, 19:00-2:00"}';


     /**
     * 
     * @param String open_hours 
     * @param String time_zone 
     * @param Int range  
     * @param Int interval 
     * @param Int days 
     * @param Int preparation_minutes 
     * 
     * @return JSON object of available time slots over given days
     */
    function getAvailableTimeSlots($open_hours, $time_zone, $preparation_minutes, $range = 30, $interval = 15, $days = 4) {
        if(is_null($open_hours) || is_null($time_zone) || ($preparation_minutes <= 0 && $preparation_minutes >= 180)) {
            throw new Exception("Open hours and time zone must be set, 0 <= preparation minutes <= 180");
        } 
        if(isClosedEveryday($open_hours,$time_zone)) {
            echo "Store is closed every day."."<br>";
        } else 
        return json_encode(getAvailableTimeSlots_Wrap($open_hours, $time_zone, $preparation_minutes, $range, $interval, $days));
    }

    /**
     * 
     * @param String open_hours 
     * @param String time_zone 
     * @param Int range  
     * @param Int interval 
     * @param Int days 
     * @param Int preparation_minutes 
     * 
     * @return JSON object of available time slots over given days
     */

    function getAvailableTimeSlots_Wrap($open_hours, $time_zone, $preparation_minutes, $range, $interval, $days) {
       
        $dateArray = getDateRange($days,$time_zone);
        $hoursDecoded = decodeHours($open_hours);
        $timeRangeForDay = array();

        if(isOpenEveryday($open_hours, $time_zone)) {
            foreach($dateArray as $date) {
                $array = array("ASAP","ALL");
                $timeRangeForDay[] = $array;
                
            }
        } else if(key($hoursDecoded) == "ALL" && $hoursDecoded["ALL"] !== "1") {
            foreach($dateArray as $date) {
                $timeRangeForDay[] = getTimeRange("ALL",$hoursDecoded,$range,$interval);
                
            }

        } else {
            foreach($dateArray as $date) {
                $unixTimestamp = strtotime($date);
                $dayOfWeek = date("D", $unixTimestamp);
                $searchKey = strtoUpper($dayOfWeek);
                $timeRangeForDay[] = getTimeRange($searchKey,$hoursDecoded,$range,$interval);
                
            }
        }
        $final = array_combine($dateArray,$timeRangeForDay);
        echo "<br>";
        return $final;
    }

    /**
     * 
     * @param String searchKey
     * @param Array hoursDecoded
     * @param Int range
     * @param Int interval
     * 
     * @return Array of size $dateArray filled with either a time range, CLOSED, or ALL
     */
    function getTimeRange($searchKey,$hoursDecoded,$range,$interval) {

        $hours = $hoursDecoded[$searchKey];
        if($hours === "ALL") {
            $openAllDay = getTime("0:00-24:00",$range,$interval);
            array_unshift($openAllDay,"ASAP");
            return $openAllDay;

        } else if($hours === "CLOSED") {
            return "CLOSED";

        } else {
            if(strpos($hours,",") === false) {
                $temp = getTime($hours,$range,$interval);
                return $temp;
            } else if(strpos($hours,",") > 0) {
                $splitTwoTimeRange = explode(",",$hours);
                $temp1 = getTime($splitTwoTimeRange[0],$range,$interval);
                $temp2 = getTime($splitTwoTimeRange[1],$range,$interval);
                
                $arrayCombined = array_merge($temp1,$temp2);
                return $arrayCombined;
            }
            return $hours;
        }
    }

    /**
     * 
     * @param String hours
     * @param Int range
     * @param Int interval
     * 
     * @return Array between hours in H:ia - H:ia format, every $interval minutes for $range minutes
     */
    function getTime($hours,$range,$interval) {

        $temp = array();
        $tempArr = explode("-",$hours);
        $startTime = strtoTime($tempArr[0]);
        $endTime = strtoTime($tempArr[1]);
        $endTime = strtoTime("-".$range." minutes",$endTime);

        while ($startTime != $endTime) {
            if(date("h:ia",$startTime) == date("h:ia",$endTime)) {
                break;
            }
            $nextTime = strtoTime("+".$range." minutes",$startTime);
            $temp[] = date("h:ia",$startTime)."-".date("h:ia",$nextTime);
            $startTime = strtoTime("+".$interval." minutes", $startTime);
        }
        $nextTime = strtoTime("+".$range." minutes",$startTime);
        $temp[] = date("h:ia",$startTime)."-".date("h:ia",$nextTime);
        return $temp;
    }

    /**
     * 
     * @param Int days 
     * @param String time_zone
     * 
     * @return Array of days starting from today in Y-m-d format
     * 
     */
    function getDateRange($days, $time_zone) {
        date_default_timezone_set($time_zone);
        $currentTime = date("Y-m-d h:i:sa");
        $startdate = strtotime($currentTime);
        $enddate = strtotime("+$days days", $startdate);
        $dateArray = array();

        while ($startdate < $enddate) {
            $dateArray[] = date("Y-m-d", $startdate);
            $startdate = strtotime("+1 day", $startdate);
          }

          return $dateArray;
    }

    /**
     *  @param String open_hours
     * 
     *  @return Array based on the given hours
     */
    function decodeHours($open_hours) {
        $array = json_decode($open_hours,true);
        $hours = array();

        return $array;
    }





    /**
     * returns true if store is currently open, based on open_hours and given time_zone
     * @param String open_hours 
     * @param String time_zone
     * 
     * @return Boolean true if open based on open_hours, otherwise false
     * throws exception if either open_hours or time_zone is not passed in as argument
     *
     */

     // test with no inputs, null input, proper input
    function isOpenNow($open_hours=null,$time_zone=null) {

        // set TZ to $time_zone
        date_default_timezone_set($time_zone);
        $currentHourMinute = date("h:i");
        $currentRoundedMinute = round($currentHourMinute / (15 * 60)) * (15 * 60);
        echo $currentRoundedMinute;

        if(isOpenEveryday($open_hours,$time_zone)) {
            return True;
        }
        return True;
        
    }



    try {
       
        getAvailableTimeSlots($someJson, "America/Los_Angeles",10);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        getAvailableTimeSlots($openEveryday, "America/Los_Angeles",10);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        getAvailableTimeSlots($openEveryday1, "America/Los_Angeles",10);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        getAvailableTimeSlots($allCrossdays, "America/Los_Angeles",10);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        getAvailableTimeSlots($closedEveryday, "America/Los_Angeles",10);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        getAvailableTimeSlots($closedEveryday1, "America/Los_Angeles",10);

        
    } catch (Exception $e) {
        echo "Caught Exception: " . $e->getMessage() . "\n";
    }



    /** 
     * @return True if is open everyday
     */
    function isOpenEveryday($open_hours,$time_zone) {
        $test = json_decode($open_hours,true); 
        $first_key = key($test);
        if ($first_key === "ALL" && ($test[$first_key] === "ALL" || $test[$first_key] === "1")) {
            return True;
        } return False;
    }


    /** 
     * 
     * @param String open_hours
     * @param String time_zone
     * 
     * 
     * @return True if is closed everyday
     */
    function isClosedEveryday($open_hours,$time_zone) {
        $test = json_decode($open_hours,true);
        $first_key = key($test);
        if($first_key === "ALL" && ($test[$first_key] === "CLOSED" || $test[$first_key] === "-1")) {
            return True;
        } return False;
    }
    

?>