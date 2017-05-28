<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class DatesConvertComponent extends Component
{
	/**
	 * Convert datetime UtC like "Thu May 04 2017 00:00:00 GMT-0400 (EDT)" 
	 * to "2017-05-04 04:00:00"
	 * @param  [string] $date in format UTC
	 * @return [string]
	 */
    public function utcToDateTime($date)
    {
    	$dt = strtotime($date);
        return date("Y-m-d H:i:s", $dt);
    }
}