<?php  

namespace Gilglecio;

class SmartTimer
{
	// d-m-Y H:i:s
	private $_date1;
	private $_date2;

	private $_difference;
	private $_before;

	private $_data = [
		'year' => 0,
		'month' => 0,
		'week' => 0,
		'day' => 0,
		'hour' => 0,
		'minute' => 0,
		'second' => 0
	];

	// seconds
	const SECOND = 1;
	const MINUTE = 60;
	const HOUR = 3600;
	const DAY = 86400;
	const WEEK = 604800;
	const MONTH = 2592000; // 30 days
	const YEAR = 31104000;

	public function __construct($_date1, $_date2=null)
	{	
		$this->_date1 = $_date1;
		$this->_date2 = $_date2 ? $_date2 : date('Y-m-d H:i:s');

		return $this->validation() ? $this->show() : 'Format: Y-m-d H:i:s';
	}

	public function __toString()
	{
		return $this->show();
	}

	public function validation()
	{

		// Y-m-d H:i:s
		$match = '/^(((\d{4})(-)(0[13578]|10|12)(-)(0[1-9]|[12][0-9]|3[01]))|((\d{4})(-)(0[469]|1‌​1)(-)([0][1-9]|[12][0-9]|30))|((\d{4})(-)(02)(-)(0[1-9]|1[0-9]|2[0-8]))|(([02468]‌​[048]00)(-)(02)(-)(29))|(([13579][26]00)(-)(02)(-)(29))|(([0-9][0-9][0][48])(-)(0‌​2)(-)(29))|(([0-9][0-9][2468][048])(-)(02)(-)(29))|(([0-9][0-9][13579][26])(-)(02‌​)(-)(29)))(\s([0-1][0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9]))$/';
		
		if (preg_match($match, $this->_date1)) { 
			return preg_match($match, $this->_date2);
		}

		return false;
	}

	public function show()
	{
		$json = [
			'date1' => $this->dateLess(),
			'date2' => $this->dateLarger(),
			'date' => $this->_data
		];

		$this->difference();
		
		$out = null;

		foreach ($this->_data as $string => $value) {
			if ($value) {
				$out .= $value . ' ' . ucfirst($string) . ($value>1 ? 's' : '') . ' ';
			}
		}

		$json['string'] = $out;

		return json_encode($json);
	}

	private function second()
	{
		$this->_data[__FUNCTION__] = $this->division(self::SECOND);
	}

	private function minute()
	{
		$this->_data[__FUNCTION__] = $this->division(self::MINUTE);
		return $this->second();
	}

	private function hour()
	{
		$this->_data[__FUNCTION__] = $this->division(self::HOUR);
		return $this->minute();
	}

	private function day()
	{
		$this->_data[__FUNCTION__] = $this->division(self::DAY);
		return $this->hour();
	}

	private function week()
	{
		$this->_data[__FUNCTION__] = $this->division(self::WEEK);
		return $this->day();
	}

	private function month()
	{
		$this->_data[__FUNCTION__] = $this->division(self::MONTH);
		return $this->week();
	}

	private function year()
	{

		$this->_data[__FUNCTION__] = $this->division(self::YEAR);
		return $this->month();
	}

	private function difference()
	{
		$this->_difference = (int) (strtotime($this->dateLarger()) - strtotime($this->dateLess()));
		$this->year();
	}

	private function division($const)
	{
		if ($this->_difference < $const) {
			return 0;
		}

		if ($this->_before) {
			$this->_difference = ($this->_difference - ($this->_before['int'] * $this->_before['const']));
		}

		$division = $this->_difference / $const;
		$int = (int) $division;

		$this->_before = [
			'const' => $const,
			'int' => $int
		];

		return $int;
	}

	private function dateLess()
	{
		return ($this->_date1 < $this->_date2) ? $this->_date1 : $this->_date2;
	}

	private function dateLarger()
	{
		return ($this->_date1 > $this->_date2) ? $this->_date1 : $this->_date2;
	}
}

$date1 = $_POST['date1'];
$date2 = $_POST['date2'];

echo new SmartTimer($date1, $date2);
