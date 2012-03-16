<?php

class Time {
	
	/**	 
	 * @var array meridians: AM and PM
	 */
	public static $meridian = array('AM'=>'AM','PM'=>'PM');
	
	/**	 
	 * @var array range of hours: 01 -12
	 */
	public static $hour_range = array(
			'00'=>'00',
			'01'=>'01',
			'02'=>'02',
			'03'=>'03',
			'04'=>'04',
			'05'=>'05',
			'06'=>'06',
			'07'=>'07',
			'08'=>'08',
			'09'=>'09',
			'10'=>'10',
			'11'=>'11',
			'12'=>'12',
		);
	/**	 
	 * @var array range of minutes: 01 -60
	 */
	public static $minute_range = array(
			'00'=>'00',
			'01'=>'01',
			'02'=>'02',
			'03'=>'03',
			'04'=>'04',
			'05'=>'05',
			'06'=>'06',
			'07'=>'07',
			'08'=>'08',
			'09'=>'09',
			'10'=>'10',
			'11'=>'11',
			'12'=>'12',
			'13'=>'13',
			'14'=>'14',
			'15'=>'15',
			'16'=>'16',
			'17'=>'17',
			'18'=>'18',
			'19'=>'19',
			'20'=>'20',
			'21'=>'21',
			'22'=>'22',
			'23'=>'23',
			'24'=>'24',
			'25'=>'25',
			'26'=>'26',
			'27'=>'27',
			'28'=>'28',
			'29'=>'29',
			'30'=>'30',
			'31'=>'31',
			'32'=>'32',
			'33'=>'33',
			'34'=>'34',
			'35'=>'35',
			'36'=>'36',
			'37'=>'37',
			'38'=>'38',
			'39'=>'39',
			'40'=>'40',
			'41'=>'41',
			'42'=>'42',
			'43'=>'43',
			'44'=>'44',
			'45'=>'45',
			'46'=>'46',
			'47'=>'47',
			'48'=>'48',
			'49'=>'49',
			'50'=>'50',
			'51'=>'51',
			'52'=>'52',
			'53'=>'53',
			'54'=>'54',
			'55'=>'55',
			'56'=>'56',
			'57'=>'57',
			'58'=>'58',
			'59'=>'59',
	
		);
		
		/**		 
		 * Splits up a time piece into constituent parts: hours, minutes and meridian with preceding zeros
		 * @param string a time piece as 04:00AM
		 * @return array of time parts e.g array('hr'=>04, 'min'='00', 'mer'=>'AM')
		 */
		public static function split($time)
		{			
			$mer = substr($time, (strpos($time, ':')+3), 2);
			$min = substr($time, (strpos($time, ':')+1),2);
			$hour = substr($time, 0, 2);
			return array('hr'=>$hour,'min'=>$min,'mer'=>$mer);
		}
		
		/**		 
		 * Converts date time to 12hour time format
		 * @param Date $time
		 */
		public static function ConvertTo12HrFormat($time)
		{
			$time = trim($time);
			
			
			$date = substr($time, 0, 10);		
			$hr = substr($time, -8, 2);			
			$min = substr($time, -5, 2);		
			$mer = '';
			if($hr > 12)
			{
				
				$hr = $hr - 12;
				$mer = 'PM';
			}
			else
			{
				$mer = 'AM';
			}
			$time = $hr.':'.$min.' '.$mer;
			return array('date'=>$date, 'time'=>$time);
		}
		
		/**		 
		 * @return array of time components array('hr'=>$hr, 'min'=>$min, 'sec'=>$sec) 
		 * @param date time $time
		 */
		public static function getTimeComponents($time)
		{
			$time = trim($time);
			$hr = substr($time, -8, 2);			
			$min = substr($time, -5, 2);	
			$sec = substr($time, -2, 2);	
			$mer = '';
			if($hr > 12)
			{
				
				$hr = $hr - 12;
				$mer = 'PM';
			}
			else
			{
				$mer = 'AM';
			}
			return array('hr'=>$hr, 'min'=>$min, 'sec'=>$sec, 'mer'=>$mer);
		}
		

}

?>