<?php
/*
Magical Code Injection Rainbow - A set of configurable injection testbeds 
Daniel "unicornFurnace" Crowley
Copyright (C) 2014 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
*/


//Random failure. If enabled, script will die 10% of the time.
//This simulates a buggy application and highlights the issue with boolean-based blind injection.
if(isset($_REQUEST['random_failure'])){
	if(rand(1,10)==10){
		die('<br>Uh, wait, what was I doing?');
	}
}

//Random delay. If enabled, script will pause execution up to ten seconds.
//This simulates network latency and highlights the problem with time-based blind injection.
if(isset($_REQUEST['random_delay'])){
	sleep(rand(0,10));
}

?>
