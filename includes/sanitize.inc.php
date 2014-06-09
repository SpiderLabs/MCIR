<?php
/*
Magical Code Injection Rainbow - A set of configurable injection testbeds 
Daniel "unicornFurnace" Crowley
Copyright (C) 2014 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

if(isset($_REQUEST['submit'])){ //Injection time!	
	
	//Double up single-quotes if requested
	if(isset($_REQUEST['quotes_double']) and $_REQUEST['quotes_double'] == 'on') $_REQUEST['inject_string'] = str_replace('\'', '\'\'', $_REQUEST['inject_string']);
	
	//Parse blacklist
	if(isset($_REQUEST['sanitization_params'])){
		$params = explode(',' , $_REQUEST['sanitization_params']);
	}
	
	if(isset($_REQUEST['sanitization_level']) and isset($_REQUEST['sanitization_type']) and $_REQUEST['sanitization_type']=='keyword'){
		switch($_REQUEST['sanitization_level']){
			//We process blacklists differently at each level. At the lowest, each keyword is removed case-sensitively.
			//At medium blacklisting, checks are done case-insensitively.
			//At the highest level, checks are done case-insensitively and repeatedly.
			case 'whitelist':
				$pass = 0;
				foreach($params as $keyword){
					if(strstr($_REQUEST['inject_string'], $keyword)!='') {
						$pass = 1;
					}
				}
				if(!$pass) die("\n<br>Input rejected!");
				break;
			case 'reject_low':
				foreach($params as $keyword){
					if(strstr($_REQUEST['inject_string'], $keyword)!='') {
						die("\n<br>Input rejected!");
					}
				}
				break;
			case 'reject_high':
				foreach($params as $keyword){
					if(strstr(strtolower($_REQUEST['inject_string']), strtolower($keyword))!='') {
						die("\n<br>Input rejected!");
					}
				}
				break;
			case 'escape':
				foreach($params as $keyword){
					$_REQUEST['inject_string'] = str_replace($keyword, '\\'.$keyword, $_REQUEST['inject_string']);
				}
				break;
			case 'low':
				foreach($params as $keyword){
					$_REQUEST['inject_string'] = str_replace($keyword, '', $_REQUEST['inject_string']);
				}
				break;
			case 'medium':
				foreach($params as $keyword){
					$_REQUEST['inject_string'] = str_ireplace($keyword, '', $_REQUEST['inject_string']);
				}
				break;
			case 'high':
				do{
					$keyword_found = 0;
					foreach($params as $keyword){
						$_REQUEST['inject_string'] = str_ireplace($keyword, '', $_REQUEST['inject_string'], $count);
						$keyword_found += $count;
					}	
				}while ($keyword_found);
				break;
			
		}
	}

	if(isset($_REQUEST['sanitization_level']) and isset($_REQUEST['sanitization_type']) and $_REQUEST['sanitization_type']=='regex'){
		switch($_REQUEST['sanitization_level']){
			
			case 'whitelist':
				$pass = 0;
				foreach($params as $param){
					if(preg_match($param,$_REQUEST['inject_string'])==1){
						$pass = 1;
					}
				}
				if(!$pass) die("\nInput rejected!");
				break;
			case 'reject_low':
				foreach($params as $param){
					if(preg_match($param,$_REQUEST['inject_string'])==1){
						die("\nInput rejected!");
					}
				}
				break;
			case 'reject_high':
				foreach($params as $param){
					if(preg_match($param.'i',$_REQUEST['inject_string'])==1){
						die("\nInput rejected!");
					}
				}
				break;
			case 'escape':
				foreach($params as $param){
					$_REQUEST['inject_string'] = preg_replace($param, "\\\\$0", $_REQUEST['inject_string']);
				}
				break;
			case 'low':
				foreach($params as $param){
					$_REQUEST['inject_string'] = preg_replace($param, '', $_REQUEST['inject_string']);
				}
				break;
			case 'medium':
				foreach($params as $param){
					$_REQUEST['inject_string'] = preg_replace($param.'i', '', $_REQUEST['inject_string']);
				}
				break;
			case 'high':
				do{
					$keyword_found = 0;
					foreach($params as $param){
						$_REQUEST['inject_string'] = preg_replace($param.'i', '', $_REQUEST['inject_string'], -1, $count);
						$keyword_found += $count;
					}	
				}while ($keyword_found);
				break;
			
		}
	}
}

?>
