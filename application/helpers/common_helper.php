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

if(!function_exists('weeks_in_month'))
{
	function weeks_in_month($year, $month, $start_day_of_week)
	{
		// Total number of days in the given month.
		$num_of_days = date("t", mktime(0,0,0,$month,1,$year));

		// Count the number of times it hits $start_day_of_week.
		$num_of_weeks = 0;
		for($i=1; $i<=$num_of_days; $i++)
		{
		  $day_of_week = date('w', mktime(0,0,0,$month,$i,$year));
		  if($day_of_week==$start_day_of_week)
			$num_of_weeks++;
		}

		return $num_of_weeks;
	}
}

if(!function_exists('getUnixTimeWeek'))
{
	function getUnixTimeWeek($date)
	{
		$date = date('Y-m-d', strtotime($date));
		
		$week = getWeeks($date, "sunday");
		$month = date('m', strtotime($date));
		$year = date('Y', strtotime($date));
		
		return strtotime($year . '-' . $month . '-' . $week);
	}
}