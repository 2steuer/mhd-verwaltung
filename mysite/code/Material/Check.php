<?php

class Check extends MaterialDataObject {
	static $db = array(
			'NextCheck' => 'Date',
			'Comment' => 'Text'
		);

	static $has_one = array(
			'Supplier' => 'Supplier',
			'Type' => 'CheckType',
			'Device'=>'Device'

		);

	static $has_many = array(
			'CheckRecords' => 'CheckRecord'
		);

	public function ActiveRecords() {
		return $this->CheckRecords()->filter(array('Active'=>'1'));
	}

	public function TypeName() {
		return $this->Type()->Name;
	}

	public function AlertClass() {
		$classes = array('check-date-ok', 'check-date-warning', 'check-date-alert');

		return $classes[$this->CheckAlert()];
	}

	public function CheckAlert() {
		$date = $this->dbObject('NextCheck');

		if($date->InPast() || $date->IsToday()) {
			return 2;
		}

		$diff = mktime(0,0,0, $date->Format('m'), $date->DayOfMonth(), $date->Year()) - time();
		$diff = $diff / (60*60*24);
		$diff = floor($diff);

		if($diff > 28) {
			return 0;
		}
		else if($diff <= 28 && $diff > 7) {
			return 1;
		}
		else {
			return 2;
		}
	} 

}