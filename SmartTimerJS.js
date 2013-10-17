(function() 
{
    "use strict";

    function SmartTimer () {};

	this._data = [
		'year' => 0,
		'month' => 0,
		'week' => 0,
		'day' => 0,
		'hour' => 0,
		'minute' => 0,
		'second' => 0
	];

	// seconds
	this.SECOND = 1;
	this.MINUTE = 60;
	this.HOUR = 3600;
	this.DAY = 86400;
	this.WEEK = 604800;
	this.MONTH = 2592000; // 30 days
	this.YEAR = 31104000;

 	SmartTimer.prototype.validation = function() 
 	{

		// Y-m-d H:i:s
		$match = '/^(((\d{4})(-)(0[13578]|10|12)(-)(0[1-9]|[12][0-9]|3[01]))|((\d{4})(-)(0[469]|1‌​1)(-)([0][1-9]|[12][0-9]|30))|((\d{4})(-)(02)(-)(0[1-9]|1[0-9]|2[0-8]))|(([02468]‌​[048]00)(-)(02)(-)(29))|(([13579][26]00)(-)(02)(-)(29))|(([0-9][0-9][0][48])(-)(0‌​2)(-)(29))|(([0-9][0-9][2468][048])(-)(02)(-)(29))|(([0-9][0-9][13579][26])(-)(02‌​)(-)(29)))(\s([0-1][0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9]))$/';
		
		if ( this._date1.match($match) ) { 
			return this._date2.match($match);
		}

		return false;
	};

	SmartTimer.prototype.dateLess = function () 
	{
		return (this._date1 < this._date2) ? this._date1 : this._date2;
	};

	SmartTimer.prototype.dateLarger = function ()
	{
		return (this._date1 > this._date2) ? this._date1 : this._date2;
	};

	SmartTimer.prototype.show = function () 
	{
		console.log(this);
		$json = [
			'date1' = this.dateLess(),
			'date2' = this.dateLarger(),
			'date' = this._data
		];

		this.difference();
		
		$out = null;

		$.each(this._data, function( string, value ) {
			console.log(string);
			
		});

		$json['string'] = $out;

		return $.parseJSON($json);
	};

	SmartTimer.prototype.second = function () 
	{
		this._data['second'] = this.division(this.SECOND);
	};

	SmartTimer.prototype.minute = function () 
	{
		this._data['minute'] = this.division(this.MINUTE);
		return this.second();
	};

	SmartTimer.prototype.hour = function () 
	{
		this._data['hour'] = this.division(this.HOUR);
		return this.minute();
	};

	SmartTimer.prototype.day = function () 
	{
		this._data['day'] = this.division(this.DAY);
		return this.hour();
	};

	SmartTimer.prototype.week = function () 
	{
		this._data['week'] = this.division(this.WEEK);
		return this.day();
	};

	SmartTimer.prototype.month = function () 
	{
		this._data['month'] = this.division(this.MONTH);
		return this.week();
	};

	SmartTimer.prototype.year = function () 
	{
		this._data['year'] = this.division(this.YEAR);
		return this.month();
	}; 

	SmartTimer.prototype.difference = function () 
	{
		this._difference = this.dateLarger().getTime() - this.dateLess().getTime();
		return this.year();
	};

	SmartTimer.prototype.division = function ($const) 
	{
		if (this._difference < $const) {
			return 0;
		}

		if (this._before) {
			this._difference = (this._difference - (this._before['int'] * this._before['const']));
		}

		$division = this._difference / $const;
		$int = parseInt($division);

		this._before['const'] = $const;
		this._before['int'] = $int;

		return $int;
	};

	SmartTimer.prototype.initialize = function ($_date1, $_date2) 
	{
		this._date1 = new Date($_date1);
		this._date2 = $_date2 ? $_date2 : new Date();

		return this.validation() ? this.show() : 'Format: Y-m-d H:i:s';
	};
}());
