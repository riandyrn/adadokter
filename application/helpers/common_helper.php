<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('debug'))
{
    function debug($data)
    {
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
    }   
}

if(!function_exists('getWeeks'))
{	
	function getWeeks($date, $rollover)
	{
		$cut = substr($date, 0, 8);
		$daylen = 86400;

		$timestamp = strtotime($date);
		$first = strtotime($cut . "00");
		$elapsed = ($timestamp - $first) / $daylen;

		$i = 1;
		$weeks = 1;

		for($i; $i<=$elapsed; $i++)
		{
			$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
			$daytimestamp = strtotime($dayfind);

			$day = strtolower(date("l", $daytimestamp));

			if($day == strtolower($rollover))  $weeks ++;
		}

		return $weeks;
	}
}

if(!function_exists('displayRecallTime'))
{
	function displayRecallTime($week, $month, $year)
	{
		echo 'Week ' . $week . ', ' . date('F', mktime(0, 0, 0, $month, 10)) . ' ' . $year;
	}
}