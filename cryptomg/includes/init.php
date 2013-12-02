<?php
/*
CryptOMG - A configurable CTF style test bed.
Andrew Jordan
Copyright (C) 2012 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it 
under the terms of the GNU General Public License as published by the 
Free Software Foundation, either version 3 of the License, or (at your 
option) any later version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General 
Public License for more details.

You should have received a copy of the GNU General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/>.
*/

$p_cipher = intval(@$_GET['cipher']);
$p_encoding = intval(@$_GET['encoding']);
$p_mode = intval(@$_GET['mode']);
$p_key_settings = intval(@$_GET['key']);
$p_iv_settings = intval(@$_GET['iv']);

if($p_cipher == 0)
	$p_cipher = 3;
if($p_encoding == 0)
	$p_encoding = 2;
if($p_mode == 0)
	$p_mode = 1;

$cipherList = mcrypt_list_algorithms();
$cipher = $cipherList[$p_cipher-1];
$modeList = mcrypt_list_modes();
$mode = $modeList[$p_mode-1];
$key_iv_list = getKeySettings();
$keysize = intval(mcrypt_get_key_size($cipher, $mode));
$blocksize = intval(mcrypt_get_block_size($cipher, $mode));
$key = genKey($keysize);
$iv = genIV($blocksize);
$encoding_list = list_encoding();




function list_encoding(){
	$encodings = array("base64",
					  "lower hex",
					  "upper hex",
					  "websafe base64");
	return $encodings;
}

function encode($text, $mode=2){
	switch($mode){
		case 1:
			return urlencode(base64_encode($text));
			break;
		case 2:
			return @array_shift(array_values(unpack("H*", $text)));
			break;
		case 3:
			return @strtoupper(array_shift(array_values(unpack("H*", $text))));
			break;
		case 4:
			$search = array("+", "/", "=");
			$replace = array("-", "_", ".");
			$string = base64_encode($text);
			return str_replace($search, $replace, $string);
			break;
		default:
			return array_shift(array_values(unpack(unpack("H*", $text))));
	}
}

function decode($text, $mode=2){
	switch($mode){
		case 1:
			return urldecode(base64_decode($text));
			break;
		case 2:
			return pack("H*", $text);
			break;
		case 3:
			return pack("H*", $text);
			break;
		case 4:
			$search = array("-", "_", ".");
			$replace = array("+", "/", "=");
			$string = str_replace($search, $replace, $text); 
			return base64_decode($string);
			break;
		default:
			return array_shift(array_values(pack("H*", $text)));
	}
}

function genIV($blocksize){
	$search = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_+{}|L:\"<>?[]\\l;',./`";
	$iv = "";
	for($i=0; $i<$blocksize; $i++)
//		$iv.=$search[$i];
		$iv .= "\0";
	return $iv;
}

function genNonce($blocksize){
	$search = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_+{}|L:\"<>?[]\\l;',./`";
	$nonce = "";
	for($i=0; $i<$blocksize-1; $i++){
		$place = mt_rand(0, strlen($search)-1);
		$nonce.=$search[$place];
	}
	return $nonce;
}
function genKey($keysize){
	$search = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_+{}|L:\"<>?[]\\l;',./`";
	$key = "";
	for($i=0; $i<intval($keysize); $i++)
		$key.= $search[$i % strlen($search)];
	return $key;
}


function encrypt($text, $cipher, $mode, $key, $iv){
	return @mcrypt_encrypt($cipher, $key, $text, $mode, $iv);	
}
function decrypt($text, $cipher, $mode, $key, $iv){
	return @mcrypt_decrypt($cipher, $key, $text, $mode, $iv);
}

function getKeySettings(){
		return array("null", "random", "custom");
}
?>
