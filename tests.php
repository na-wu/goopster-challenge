<?php 



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


class Test extends \PHPUnit_Framework_TestCase {

  
    

    public function testSomeJsonReturnsJson ($someJson) {

        $returnedJson = getAvailableTimeSlots($someJson, "America/Los_Angeles",10);

        $expectedJson = '{"2019-07-15":"CLOSED",
            "2019-07-16":["09:00am-09:30am","09:15am-09:45am","09:30am-10:00am","09:45am-10:15am","10:00am-10:30am","10:15am-10:45am","10:30am-11:00am","10:45am-11:15am","11:00am-11:30am","11:15am-11:45am","11:30am-12:00pm","11:45am-12:15pm","12:00pm-12:30pm","12:15pm-12:45pm","12:30pm-01:00pm","12:45pm-01:15pm","01:00pm-01:30pm","01:15pm-01:45pm","01:30pm-02:00pm","01:45pm-02:15pm","02:00pm-02:30pm","02:15pm-02:45pm","02:30pm-03:00pm","02:45pm-03:15pm","03:00pm-03:30pm","03:15pm-03:45pm","03:30pm-04:00pm","03:45pm-04:15pm","04:00pm-04:30pm","04:15pm-04:45pm","04:30pm-05:00pm"],
            "2019-07-17":["09:00am-09:30am","09:15am-09:45am","09:30am-10:00am","09:45am-10:15am","10:00am-10:30am","10:15am-10:45am","10:30am-11:00am","10:45am-11:15am","11:00am-11:30am","11:15am-11:45am","11:30am-12:00pm","11:45am-12:15pm","12:00pm-12:30pm","12:15pm-12:45pm","12:30pm-01:00pm","12:45pm-01:15pm","01:00pm-01:30pm","01:15pm-01:45pm","01:30pm-02:00pm","01:45pm-02:15pm","02:00pm-02:30pm","02:15pm-02:45pm","02:30pm-03:00pm","02:45pm-03:15pm","03:00pm-03:30pm","03:15pm-03:45pm","03:30pm-04:00pm","03:45pm-04:15pm","04:00pm-04:30pm","04:15pm-04:45pm","04:30pm-05:00pm","07:00pm-07:30pm","07:15pm-07:45pm","07:30pm-08:00pm","07:45pm-08:15pm","08:00pm-08:30pm","08:15pm-08:45pm","08:30pm-09:00pm","08:45pm-09:15pm","09:00pm-09:30pm","09:15pm-09:45pm","09:30pm-10:00pm","09:45pm-10:15pm","10:00pm-10:30pm","10:15pm-10:45pm","10:30pm-11:00pm","10:45pm-11:15pm","11:00pm-11:30pm","11:15pm-11:45pm","11:30pm-12:00am","11:45pm-12:15am","12:00am-12:30am","12:15am-12:45am","12:30am-01:00am","12:45am-01:15am","01:00am-01:30am","01:15am-01:45am","01:30am-02:00am","01:45am-02:15am","02:00am-02:30am","02:15am-02:45am","02:30am-03:00am"],
            "2019-07-18":["09:00am-09:30am","09:15am-09:45am","09:30am-10:00am","09:45am-10:15am","10:00am-10:30am","10:15am-10:45am","10:30am-11:00am","10:45am-11:15am","11:00am-11:30am","11:15am-11:45am","11:30am-12:00pm","11:45am-12:15pm","12:00pm-12:30pm","12:15pm-12:45pm","12:30pm-01:00pm","12:45pm-01:15pm","01:00pm-01:30pm","01:15pm-01:45pm","01:30pm-02:00pm","01:45pm-02:15pm","02:00pm-02:30pm","02:15pm-02:45pm","02:30pm-03:00pm","02:45pm-03:15pm","03:00pm-03:30pm","03:15pm-03:45pm","03:30pm-04:00pm","03:45pm-04:15pm","04:00pm-04:30pm","04:15pm-04:45pm","04:30pm-05:00pm"]}';
            
        assertEquals($returnedJson,$expectedJson);

    }

    public function testOpenEverydayReturnsJson ($openEveryday) {

        $returnedJson = getAvailableTimeSlots($openEveryday, "America/Los_Angeles",10);

        $expectedJson = '{"2019-07-15":["ASAP","ALL"],"2019-07-16":["ASAP","ALL"],"2019-07-17":["ASAP","ALL"],"2019-07-18":["ASAP","ALL"]}';


        assertEquals($returnedJson,$expectedJson);

    }

    public function testOpenEveryday1ReturnsJson ($openEveryday1) {

        $returnedJson = getAvailableTimeSlots($openEveryday1, "America/Los_Angeles",10);
        $expectedJson = '{"2019-07-15":["ASAP","ALL"],"2019-07-16":["ASAP","ALL"],"2019-07-17":["ASAP","ALL"],"2019-07-18":["ASAP","ALL"]}';  

        assertEquals($returnedJson,$expectedJson);

    }
       
    public function testOpenEveryday1ReturnsJson ($allCrossdays) {

        $returnedJson = getAvailableTimeSlots($allCrossdays, "America/Los_Angeles",10);
        $expectedJson = '{"2019-07-15":["09:00am-09:30am","09:15am-09:45am","09:30am-10:00am","09:45am-10:15am","10:00am-10:30am","10:15am-10:45am","10:30am-11:00am","10:45am-11:15am","11:00am-11:30am","11:15am-11:45am","11:30am-12:00pm","11:45am-12:15pm","12:00pm-12:30pm","12:15pm-12:45pm","12:30pm-01:00pm","12:45pm-01:15pm","01:00pm-01:30pm","01:15pm-01:45pm","01:30pm-02:00pm","01:45pm-02:15pm","02:00pm-02:30pm","02:15pm-02:45pm","02:30pm-03:00pm","02:45pm-03:15pm","03:00pm-03:30pm","03:15pm-03:45pm","03:30pm-04:00pm","03:45pm-04:15pm","04:00pm-04:30pm","04:15pm-04:45pm","04:30pm-05:00pm","07:00pm-07:30pm","07:15pm-07:45pm","07:30pm-08:00pm","07:45pm-08:15pm","08:00pm-08:30pm","08:15pm-08:45pm","08:30pm-09:00pm","08:45pm-09:15pm","09:00pm-09:30pm","09:15pm-09:45pm","09:30pm-10:00pm","09:45pm-10:15pm","10:00pm-10:30pm","10:15pm-10:45pm","10:30pm-11:00pm","10:45pm-11:15pm","11:00pm-11:30pm","11:15pm-11:45pm","11:30pm-12:00am","11:45pm-12:15am","12:00am-12:30am","12:15am-12:45am","12:30am-01:00am","12:45am-01:15am","01:00am-01:30am","01:15am-01:45am","01:30am-02:00am"],
            "2019-07-16":["09:00am-09:30am","09:15am-09:45am","09:30am-10:00am","09:45am-10:15am","10:00am-10:30am","10:15am-10:45am","10:30am-11:00am","10:45am-11:15am","11:00am-11:30am","11:15am-11:45am","11:30am-12:00pm","11:45am-12:15pm","12:00pm-12:30pm","12:15pm-12:45pm","12:30pm-01:00pm","12:45pm-01:15pm","01:00pm-01:30pm","01:15pm-01:45pm","01:30pm-02:00pm","01:45pm-02:15pm","02:00pm-02:30pm","02:15pm-02:45pm","02:30pm-03:00pm","02:45pm-03:15pm","03:00pm-03:30pm","03:15pm-03:45pm","03:30pm-04:00pm","03:45pm-04:15pm","04:00pm-04:30pm","04:15pm-04:45pm","04:30pm-05:00pm","07:00pm-07:30pm","07:15pm-07:45pm","07:30pm-08:00pm","07:45pm-08:15pm","08:00pm-08:30pm","08:15pm-08:45pm","08:30pm-09:00pm","08:45pm-09:15pm","09:00pm-09:30pm","09:15pm-09:45pm","09:30pm-10:00pm","09:45pm-10:15pm","10:00pm-10:30pm","10:15pm-10:45pm","10:30pm-11:00pm","10:45pm-11:15pm","11:00pm-11:30pm","11:15pm-11:45pm","11:30pm-12:00am","11:45pm-12:15am","12:00am-12:30am","12:15am-12:45am","12:30am-01:00am","12:45am-01:15am","01:00am-01:30am","01:15am-01:45am","01:30am-02:00am"],
            "2019-07-17":["09:00am-09:30am","09:15am-09:45am","09:30am-10:00am","09:45am-10:15am","10:00am-10:30am","10:15am-10:45am","10:30am-11:00am","10:45am-11:15am","11:00am-11:30am","11:15am-11:45am","11:30am-12:00pm","11:45am-12:15pm","12:00pm-12:30pm","12:15pm-12:45pm","12:30pm-01:00pm","12:45pm-01:15pm","01:00pm-01:30pm","01:15pm-01:45pm","01:30pm-02:00pm","01:45pm-02:15pm","02:00pm-02:30pm","02:15pm-02:45pm","02:30pm-03:00pm","02:45pm-03:15pm","03:00pm-03:30pm","03:15pm-03:45pm","03:30pm-04:00pm","03:45pm-04:15pm","04:00pm-04:30pm","04:15pm-04:45pm","04:30pm-05:00pm","07:00pm-07:30pm","07:15pm-07:45pm","07:30pm-08:00pm","07:45pm-08:15pm","08:00pm-08:30pm","08:15pm-08:45pm","08:30pm-09:00pm","08:45pm-09:15pm","09:00pm-09:30pm","09:15pm-09:45pm","09:30pm-10:00pm","09:45pm-10:15pm","10:00pm-10:30pm","10:15pm-10:45pm","10:30pm-11:00pm","10:45pm-11:15pm","11:00pm-11:30pm","11:15pm-11:45pm","11:30pm-12:00am","11:45pm-12:15am","12:00am-12:30am","12:15am-12:45am","12:30am-01:00am","12:45am-01:15am","01:00am-01:30am","01:15am-01:45am","01:30am-02:00am"],
            "2019-07-18":["09:00am-09:30am","09:15am-09:45am","09:30am-10:00am","09:45am-10:15am","10:00am-10:30am","10:15am-10:45am","10:30am-11:00am","10:45am-11:15am","11:00am-11:30am","11:15am-11:45am","11:30am-12:00pm","11:45am-12:15pm","12:00pm-12:30pm","12:15pm-12:45pm","12:30pm-01:00pm","12:45pm-01:15pm","01:00pm-01:30pm","01:15pm-01:45pm","01:30pm-02:00pm","01:45pm-02:15pm","02:00pm-02:30pm","02:15pm-02:45pm","02:30pm-03:00pm","02:45pm-03:15pm","03:00pm-03:30pm","03:15pm-03:45pm","03:30pm-04:00pm","03:45pm-04:15pm","04:00pm-04:30pm","04:15pm-04:45pm","04:30pm-05:00pm","07:00pm-07:30pm","07:15pm-07:45pm","07:30pm-08:00pm","07:45pm-08:15pm","08:00pm-08:30pm","08:15pm-08:45pm","08:30pm-09:00pm","08:45pm-09:15pm","09:00pm-09:30pm","09:15pm-09:45pm","09:30pm-10:00pm","09:45pm-10:15pm","10:00pm-10:30pm","10:15pm-10:45pm","10:30pm-11:00pm","10:45pm-11:15pm","11:00pm-11:30pm","11:15pm-11:45pm","11:30pm-12:00am","11:45pm-12:15am","12:00am-12:30am","12:15am-12:45am","12:30am-01:00am","12:45am-01:15am","01:00am-01:30am","01:15am-01:45am","01:30am-02:00am"]}';  
                  
        assertEquals($returnedJson,$expectedJson);

    }


    public function testClosedEverydayReturnsString ($closedEveryday) {

        $returnedJson = getAvailableTimeSlots($closedEveryday, "America/Los_Angeles",10);
        $expectedJson = 'Store is closed every day.'

        assertEquals($returnedJson == $expectedJson);

    }

    public function testClosedEveryday1ReturnsString ($closedEveryday1) {

        $returnedJson = getAvailableTimeSlots($closedEveryday1, "America/Los_Angeles",10);
        $expectedJson = 'Store is closed every day.'

        assertEquals($returnedJson,$expectedJson);

    }

        

    
}

?>
