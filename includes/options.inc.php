<?php
/*
Magical Code Injection Rainbow - A set of configurable injection testbeds 
Daniel "unicornFurnace" Crowley
Copyright (C) 2014 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
*/
?>

<form method="get">
<table>
<tr><td><b>Input Sanitization:</b></td></tr>
<tr><td><small><i>Criteria for manipulating, escaping, or rejecting attack strings</i></small></td></tr>
	<tr><td>Double-up Single Quotes:</td><td><input type="checkbox" name="quotes_double" <?php if(isset($_REQUEST["quotes_double"])) echo "checked"; ?> ></td></tr>
	<tr><td>Sanitization Level:</td><td><select name="sanitization_level">
		<option value="none">No sanitization</option>
		<option value="whitelist" <?php if(isset($_REQUEST["sanitization_level"]) and $_REQUEST["sanitization_level"]=="whitelist") echo "selected"; ?>>Accept Only Whitelisted Items</option>
		<option value="reject_low" <?php if(isset($_REQUEST["sanitization_level"]) and $_REQUEST["sanitization_level"]=="reject_low") echo "selected"; ?>>Case-Sensitively Reject Blacklisted Items</option>
		<option value="reject_high" <?php if(isset($_REQUEST["sanitization_level"]) and $_REQUEST["sanitization_level"]=="reject_high") echo "selected"; ?>>Case-Insensitively Reject Blacklisted Items</option>
		<option value="escape" <?php if(isset($_REQUEST["sanitization_level"]) and $_REQUEST["sanitization_level"]=="escape") echo "selected"; ?>>Backslash-Escape Blacklisted Items</option>
		<option value="low" <?php if(isset($_REQUEST["sanitization_level"]) and $_REQUEST["sanitization_level"]=="low") echo "selected"; ?>>Case-Sensitively Remove Blacklisted Items</option>
		<option value="medium" <?php if(isset($_REQUEST["sanitization_level"]) and $_REQUEST["sanitization_level"]=="medium") echo "selected"; ?>>Case-Insensitively Remove Blacklisted Items</option>
		<option value="high" <?php if(isset($_REQUEST["sanitization_level"]) and $_REQUEST["sanitization_level"]=="high") echo "selected"; ?>>Case-Insensitively and Repetitively Remove Blacklisted Items</option>
	</select></td></tr>
	<tr><td>Pattern matching style</td><td>Keywords <input type="radio" value="keyword" name="sanitization_type" <?php if(!isset($_REQUEST['sanitization_type']) or $_REQUEST["sanitization_type"]=="keyword") echo "checked"; ?>>
		Regexes <input type="radio" value="regex" name="sanitization_type" <?php if(isset($_REQUEST["sanitization_type"]) and $_REQUEST["sanitization_type"]=="regex") echo "checked"; ?>></td></tr>
	<tr><td>Enter comma-separated keywords or regexes<br>to whitelist or blacklist below.</td></tr>
	<tr><td>Sanitization Parameters:</td><td><textarea name="sanitization_params"><?php if(isset($_REQUEST["sanitization_params"])) echo $_REQUEST["sanitization_params"]; ?></textarea></td></tr>
<tr><td><br/></td><td></td></tr>
<tr><td><b>Environmental Settings:</b></td></tr>
<tr><td><small><i>Simulate transient application issues</i></small></td></tr>
	<tr><td>Random Failure?</td><td><input type="checkbox" name="random_failure"<?php echo isset($_REQUEST['random_failure']) ? ' checked' : '' ?>>
	<tr><td>Random Time Delay?</td><td><input type="checkbox" name="random_delay"<?php echo isset($_REQUEST['random_delay']) ? ' checked' : '' ?>>
<tr><td><br/></td><td></td></tr>
<tr><td><b>Output Level:</b></td></tr>
<tr><td><small><i>Configure the verbosity of output received</i></small></td></tr>
	<tr><td>Output Results:</td><td><select name="query_results">
		<option value="all_rows">All results</option>
		<option value="one_row" <?php if(isset($_REQUEST["query_results"]) and $_REQUEST["query_results"]=="one_row") echo "selected"; ?>>One result</option>
		<option value="bool" <?php if(isset($_REQUEST["query_results"]) and $_REQUEST["query_results"]=="bool") echo "selected"; ?>>Boolean (result vs no result)</option>
		<option value="none" <?php if(isset($_REQUEST["query_results"]) and $_REQUEST["query_results"]=="none") echo "selected"; ?>>No results</option>
	</select></td></tr>
	<tr><td>Error Verbosity:</td><td><select name="error_level">
		<option value="verbose">Verbose error messages</option>
		<option value="generic" <?php if(isset($_REQUEST["error_level"]) and $_REQUEST["error_level"]=="generic") echo "selected"; ?>>Generic error messages</option>
		<option value="none" <?php if(isset($_REQUEST["error_level"]) and $_REQUEST["error_level"]=="none") echo "selected"; ?>>No error messages</option>
	</select></td></tr>
	<tr><td>Show payload in context?:</td><td><input type="checkbox" name="show_query" value="on" <?php if(isset($_REQUEST["show_query"])) echo "checked"; ?> ></td></tr>
<tr><td><br/></td><td></td></tr>
<tr><td><b>Injection Parameters:</b></td></tr>
<tr><td><small><i>Enter your attack string and point of injection</i></small></td></tr>
<tr><td>Injection String:</td><td><textarea name="inject_string"><?php if(isset($_REQUEST["inject_string"])) echo htmlentities($_REQUEST["inject_string"]); ?></textarea></td></tr>
