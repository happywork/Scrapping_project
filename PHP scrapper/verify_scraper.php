<?php

$base = dirname(__FILE__) . '/';
$maxRate = 300;

$economy_cpm = 6;
$business_cpm = 16;
$premium_cpm = 10;
$first_cpm = 10;
$devel = 1;

include('/var/www/mightytravels/dashboardv2/links_functions.php');

$mask = '/home/ubuntu/mightytravels/cheap*.csv';
$global_file = '/home/ubuntu/mightytravels/cheap_tj_global.csv';
$logDir = '/';

$checked_economy = 0;
$checked_business = 0;
$checked_premium = 0;
$checked_first = 0;

$valid_cheap_economy = 0;
$valid_cheap_business = 0;
$valid_wego_economy = 0;
$valid_wego_business = 0;
$passed_economy = 0;
$passed_business = 0;
$passed_cpm_economy = 0;
$passed_cpm_business = 0;
$invalid_cheap_economy = 0;
$invalid_cheap_busienss = 0;
$invalid_wego_economy = 0;
$invalid_wego_business = 0;


$not_pass_mess = '';


if ($devel == 1) {

    define('DB_DASH', "mightytravels-devel");
    define('DASH_HOST', "10.138.115.95");
    define('DASH_USER', "mightytravels-de");
    define('DASH_PASSWORD', "vAL7aLWX298RDAvJ");
} else {

    define('DB_DASH', "mightytravels");
    define('DASH_HOST', "127.0.0.1");
    define('DASH_USER', "mightytravels");
    define('DASH_PASSWORD', "xNtBNOwRQxK");
}


$conn = mysqli_connect(DASH_HOST, DASH_USER, DASH_PASSWORD, DB_DASH);


if ($argc < 2) {
    die("provide scraper name, e.g. momondo\n");
}

$name = $argv[1];
$name = $name . "_scraper";

$name2 = "wego_scraper";

if (!file_exists("$base/core/$name.class.php")) {
    die("unknown scraper '$name'\n");
}

require_once($base . 'core/env.php');
$lock = $name;
if (!empty($argv[2]) && !is_numeric($argv[2])) {
    $lock .= md5($argv[2]);
}
$env = env::get_instance("process_lock:$lock", "scraper", "scraper_helper", "storage", "log");
if (!$env->process_lock->acquire()) {
    $lock_filepath = $env->process_lock->get_filepath();
    echo "another copy of this script is apparently running, exiting\n(if not, remove $lock_filepath)\n";
    exit;
}

$lccs = array();

$sql_lcc = mysqli_query($conn, "SELECT `name` FROM `airline` WHERE `alliance`='lcc'");
while ($row_lcc = mysqli_fetch_array($sql_lcc)) {
    $lccs[] = $row_lcc['name'];
}


env::get_instance($name);
env::get_instance($name2);

class FilesToRemove
{
    static $files = array();

    public static function tearDown()
    {
        foreach (self::$files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        self::$files = array();
    }
}

register_shutdown_function(['FilesToRemove', 'tearDown']);

file_put_contents('log.txt', json_encode($argv));


$parallel = 4;
if (!empty($argv[2]) && is_numeric($argv[2])) {
    $parallel = intval($argv[2]);
}
$files = glob($mask);


$notpass = array();

$scraper = new $name();
$scraper2 = new $name2();

foreach ($files as $myfile) {
    if (strpos($myfile, "global") === FALSE) {
        env::get_instance("log")->log->put($myfile);

        $source = fopen($myfile, 'r');
        $destination = fopen($myfile . '.verified', 'w+');


        FilesToRemove::$files[] = $myfile . '.verified';
        $addCheckSum = true;
        while ($row = fgetcsv($source)) {


            $linksn = "";

            $fromCode = $row[0];
            $toCode = $row[2];
            $fromDate = $row[4];
            $toDate = $row[5];
            $price = $row[6];
            $airlines = $row[7];
            $rate = $row[9];

            if (strpos($myfile, "economy")) {
                $refval = $economy_cpm;
                $class = "Economy";
                $class_wego = "economy";
                $checked_economy++;
            }

            if (strpos($myfile, "business")) {
                $refval = $business_cpm;
                $class = "Business";
                $class_wego = "business";
                $checked_business++;
            }

            if (strpos($myfile, "premium")) {
                $refval = $premium_cpm;
                $class = "PremiumEconomy";
                $class_wego = "premium_economy";
                $checked_premium++;
            }

            if (strpos($myfile, "first")) {
                $refval = $first_cpm;
                $class = "First";
                $class_wego ="first";
                $checked_first++;
            }

            if ($row[0] == 'FROM') {
                if (end($row) == 'CHECK_STAMP') {
                    $addCheckSum = false;
                } else {
                    $row[] = 'CHECK_STAMP';
                }
                fputcsv($destination, $row);
                continue;
            }

            if ($addCheckSum) {
                $row[] = date('Y-m-d H:i:s');
            } else {
                $row[count($row) - 1] = date('Y-m-d H:i:s');
            }


            $ok_company = 1;


            if (in_array($row[7], $lccs)) {
                $ok_company = 0;
            }


            $today = date("Y-m-d");



            // env::get_instance("log")->log->put($ok_company);


            if ($ok_company == 1) {


                if (floatval($row[9]) <= $refval) {


                    if ($rate > $maxRate) {
                        fputcsv($destination, $row);
                        continue;
                    }
                    if (strtotime($fromDate) < time()) {
                        continue;
                    }
                    sleep(5);
                    $verificationPrice = $scraper->verify($fromCode, $toCode, $fromDate, $toDate, $airlines, $price, 1.2, $class);

                    if ($verificationPrice) {
                        env::get_instance("log")->log->put("Cheap price " . $verificationPrice);
                        /* $row[6] = $verificationPrice;*/
                        fputcsv($destination, $row);
                        if ($class == "Economy") {
                            $valid_cheap_economy++;
                        } else {
                            $valid_cheap_business++;
                        }
                    } else {
                        if ($class == "Economy") {
                            $invalid_cheap_economy++;
                        } else {
                            $invalid_cheap_busienss++;
                        }
                        $notpass[] = $row;

                        $cr = date("Y-m-d H:i:s");


                        if ($row[3]!=""){
                            $exp = "INSERT INTO `mightyDealsExpired` (`deal_id`, `class`, `fromregion`, `toregion`, `fromCode`, `fromCity`, `toCode`, `toCity`, `outbound`, `inbound`, `airline`, `price`, `milesFlown`, `CPM`, `link`, `saving`, `created`, `lastCheck`, `source`, `priceFound`) VALUES ('', '" . strtolower($class) . "','','','" . $row[0] . "','" . $row[1] . "','" . $row[2] . "','" . $row[3] . "','" . $row[4] . "','" . $row[5] . "','" . $row[7] . "','" . $row[6] . "','" . $row[8] . "','" . $row[9] . "','" . $row[10] . "','0','" . $cr . "', '" . $cr . "','scraper','$verificationPrice');";

                            mysqli_query($conn, $exp);
                        }



                        $linksn = getFlightLinksEmail($fromCode, $toCode, $row[1], $row[3], $fromDate, $toDate, $class, $airlines, "ALL");
                        $not_pass_mess .= '<br />Class: ' . $class . ' From: ' . $fromCode . ' To: ' . $toCode . ' FromDate: ' . $fromDate . ' ToDate: ' . $toDate . ' Airlines: ' . $airlines . ' Price: ' . $price . ' CPM: ' . $row[9];
                        $not_pass_mess .= ' ' . $linksn . '<br /><br />';

                    }
                } else {
                    if ($class == "Economy") {
                        $passed_cpm_economy++;
                    } else {
                        $passed_cpm_business++;
                    }
                    fputcsv($destination, $row);
                }
            } else {

                sleep(rand(3,6));
                $verificationPrice = $scraper2->verify($fromCode, $toCode, $fromDate, $toDate, $airlines, $price, 1.2, $class_wego);


                if ($verificationPrice) {

                    if ($verificationPrice <= ($price * 1.2)) {
                        env::get_instance("log")->log->put("WEGO price " . $verificationPrice);
                        /* $row[6] = $verificationPrice;*/
                        fputcsv($destination, $row);
                        if ($class == "Economy") {
                            $valid_wego_economy++;
                        } else {
                            $valid_wego_business++;
                        }
                    } else {
                        if ($class == "Economy") {
                            $invalid_wego_economy++;
                        } else {
                            $invalid_wego_business++;
                        }
                        $notpass[] = $row;

                        $cr = date("Y-m-d H:i:s");
                        if ($row[3]!="") {
                            $exp = "INSERT INTO `mightyDealsExpired` (`deal_id`, `class`, `fromregion`, `toregion`, `fromCode`, `fromCity`, `toCode`, `toCity`, `outbound`, `inbound`, `airline`, `price`, `milesFlown`, `CPM`, `link`, `saving`, `created`, `lastCheck`, `source`, `priceFound`) VALUES ('', '" . strtolower($class) . "','','','" . $row[0] . "','" . $row[1] . "','" . $row[2] . "','" . $row[3] . "','" . $row[4] . "','" . $row[5] . "','" . $row[7] . "','" . $row[6] . "','" . $row[8] . "','" . $row[9] . "','" . $row[10] . "','0','" . $cr . "', '" . $cr . "','scraper','$verificationPrice');";

                            mysqli_query($conn, $exp);
                        }

                        $linksn = getFlightLinksEmail($fromCode, $toCode, $row[1], $row[3], $fromDate, $toDate, $class, $airlines, "ALL");
                        $not_pass_mess .= '<br />Class: ' . $class . ' From: ' . $fromCode . ' To: ' . $toCode . ' FromDate: ' . $fromDate . ' ToDate: ' . $toDate . ' Airlines: ' . $airlines . ' Price: ' . $price . ' CPM: ' . $row[9];
                        $not_pass_mess .= ' ' . $linksn . '<br /><br />';
                    }


                } else {
                    if ($class == "Economy") {
                        $invalid_wego_economy++;
                    } else {
                        $invalid_wego_business++;
                    }
                    $notpass[] = $row;

                    $cr = date("Y-m-d H:i:s");
                    if ($row[3]!="") {

                        $exp = "INSERT INTO `mightyDealsExpired` (`deal_id`, `class`, `fromregion`, `toregion`, `fromCode`, `fromCity`, `toCode`, `toCity`, `outbound`, `inbound`, `airline`, `price`, `milesFlown`, `CPM`, `link`, `saving`, `created`, `lastCheck`, `source`, `priceFound`) VALUES ('', '" . strtolower($class) . "','','','" . $row[0] . "','" . $row[1] . "','" . $row[2] . "','" . $row[3] . "','" . $row[4] . "','" . $row[5] . "','" . $row[7] . "','" . $row[6] . "','" . $row[8] . "','" . $row[9] . "','" . $row[10] . "','0','" . $cr . "', '" . $cr . "','scraper','$verificationPrice');";

                        mysqli_query($conn, $exp);
                    }

                    $linksn = getFlightLinksEmail($fromCode, $toCode, $row[1], $row[3], $fromDate, $toDate, $class, $airlines, "ALL");
                    $not_pass_mess .= '<br />Class: ' . $class . ' From: ' . $fromCode . ' To: ' . $toCode . ' FromDate: ' . $fromDate . ' ToDate: ' . $toDate . ' Airlines: ' . $airlines . ' Price: ' . $price . ' CPM: ' . $row[9];
                    $not_pass_mess .= ' ' . $linksn . '<br /><br />';

                }


            }
        }
        fclose($destination);
        fclose($source);
        copy($myfile . '.verified', $myfile);
        unlink($myfile . '.verified');

    }


}
/* update global file */
unlink($global_file);
sleep(1);
$putglobal = fopen($global_file, 'w+');
foreach ($files as $myfile) {
    if (strpos($myfile, "global") === FALSE) {
        $source = fopen($myfile, 'r');

        while ($row = fgetcsv($source)) {

            fputcsv($putglobal, $row);
        }

    }
}

/* send alerts to email or resumes */

// require_once('ses.php');
//get credentials at http://aws.amazon.com My Account / Console > Security Credentials
// $ses = new SimpleEmailService('1NPKQZFR3A1DGYMQEQ82', 'ZwJgJ1TkMxMNkCNwW+SNau8V4Nq4S1pSd+vfIi5q');

if (count($notpass) > 0) {
    $subject_departure = "Not pass deals";

    $message_content = print_r($notpass, true);


    /*        $m = new SimpleEmailServiceMessage();

            $m->addTo("tj@bluusun.com");
            $m->setFrom("farealerts@mightytravels.com");
            $m->setSubject('Mighty Travels - Verify Scraper Not passed deals');
            $m->setMessageFromString('', $not_pass_mess);
            $ses->sendEmail($m);*/

}


/* Resume email */

$subject_departure = "Verify Scraper resume";

$message_content = "Economy
    Checked: " . $checked_economy . "
    Passed by CPM: " . $passed_cpm_economy . "
    Passed by Airline: " . $passed_economy . "
    Valid by cheap: " . $valid_cheap_economy . "
    INVALID by cheap: " . $invalid_cheap_economy . "
    Valid by WEGO: " . $valid_wego_economy . "
    INVALID by WEGO: " . $invalid_wego_economy . "
    
    
    Business
    Checked: " . $checked_business . "
    Passed by CPM: " . $passed_cpm_business . "
    Passed by Airline: " . $passed_business . "
    Valid by cheap: " . $valid_cheap_business . "
    INVALID by cheap: " . $invalid_cheap_busienss . "
    Valid by WEGO: " . $valid_wego_business . "
    INVALID by WEGO: " . $invalid_wego_business . "
    ";

/*  $m = new SimpleEmailServiceMessage();

  $m->addTo("farealerts@mightytravels.com");
  $m->setFrom("farealerts@mightytravels.com");
  $m->setSubject($subject_departure);
  $m->setMessageFromString($message_content);
  $ses->sendEmail($m);*/
