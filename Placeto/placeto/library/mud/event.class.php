<?php
	class mud_Event // handles event triggers/hooks
	{
		public function add(){} // add event
		public function get($strEvent=false){} // returns array of events or one
		public function hook($strEvent){} // hooks an object reference to an event
		public function load(){} // fires the linked events
	}
?>