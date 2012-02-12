<?php
	class Mud // provides higher Php functionality
	{
		public $class, $error, $event, $function, $security;
		
		public function __construct()
		{
			$this->class=new mud_Class();
			$this->error=new mud_Error();
			$this->event=new mud_Event();
			$this->function=new mud_Function();
			$this->security=new mud_Security();
		}
	}
?>
