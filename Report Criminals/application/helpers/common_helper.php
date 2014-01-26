<?php

/*
 * ---------------------------------------------------------------------------------------
 * File: 		common_helper.php
 * Created by: 	Muhammad Rizwan
 * Description: This helper is autoloaded, so we will keep minumum function which are most 
 *              commonly used throughuot the code
 * Version:		1.0 - Added basic functions
 * ---------------------------------------------------------------------------------------
 */

	/*
	 * Function: trim_inner 
	 * Params: str => the string which you want to inner trim
	 * Written by: Muhammad Rizwan
	 * Description: Converts multiple space inside string to one space
	 *              Like "I    am    Rizwan" will be converted to "I am Rizwan"
	 */
	function trim_inner($str = '')
	{
		return implode(" ", array_filter(explode(" ", $str)));
	}
	
	/*
	 * Function: to_string
	 * Params: str => the string which you want to convert to string
	 * Written by: Muhammad Rizwan
	 * Description: Converts values to string format
	 */
	function to_string($str)
	{
		if(is_null($str))
			return "";
		else
			return (string)$str;
	}
	
	/*
	 * Function: generate_Key 
	 * Params: seed => postfix string to be concatenated to the generated key
	 * Written by: Muhammad Rizwan
	 * Description: Creates a random unique key
	 */
	 
	 
	function generate_Key($seed = '')
	{
		$time = time();
		return md5( rand(1000, $time ) . $seed);
	}
		
		
	/*
	 * Function: trim_inner 
	 * Params: object => any object which you want to convert to array
	 *         key_field =>
	 * Added by: Muhammad Rizwan
	 * Source: <unknown>
	 * Description: Recursively calls itself to convert an object to array
	 */
	function object2array($object, $key_field = "")
	{
	   $return = NULL;
	   if(is_array($object))
	   {
	       foreach($object as $key => $value)
		   {
				$arr = object2array($value);
				if( $key_field !="" )
					$return[$arr[$key_field]] = $arr;
				else
					$return[$key] = $arr;
		   }
	   }
	   else
	   {
	       $var = get_object_vars($object);
	         
	       if($var)
	       {
	           foreach($var as $key => $value)
	               $return[$key] = object2array($value);
	       }
	       else
	           return strval($object); // strval and everything is fine
	   }
	
	   return $return;
	}
	
	/*
	 * Function: trim_inner 
	 * Params: array => any array which you want to convert to object
	 * Added by: Muhammad Rizwan
	 * Source: <unknown>
	 * Description: Recursively calls itself to convert an array to stdClass object
	 */
	function arrayToObject($array)
	{
		if(!is_array($array))
		{
			return $array;
		}
		
		$object = new stdClass();
		if (is_array($array) && count($array) > 0)
		{
		  foreach ($array as $name=>$value)
		  {
			 $name = strtolower(trim($name));
			 if (!empty($name))
			 {
				$object->$name = arrayToObject($value);
			 }
		  }
		  return $object;
		}
		else
		{
			return FALSE;
		}
	}

	
	function br2nl($text)
	{    
		return  preg_replace('/<br\\s*?\/??>/i', '', $text);
	}
	
	
	function add_param($url, $key, $value) 
	{
		$url = preg_replace('/(.*)(\?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
		$url = substr($url, 0, -1);
		if (strpos($url, '?') === false) 
		{
			  return ($url . '?' . $key . '=' . $value);
		} 
		else 
		{
			return ($url . '&' . $key . '=' . $value);
		}
	}
   function remove_param($url, $key) 
   {
		$url = preg_replace('/(.*)(\?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
		$url = substr($url, 0, -1);
		return ($url);
    }
	
	function add_remove_param($url, $key,$value) 
	{
		$url = preg_replace('/(.*)(\?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
		$url = substr($url, 0, -1);
		
		$url = preg_replace('/(.*)(\?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
		$url = substr($url, 0, -1);
		if (strpos($url, '?') === false) 
		{
	 		  return ($url . '?' . $key . '=' . $value);
		} 
		else 
		{
			return ($url . '&' . $key . '=' . $value);
	    }
	}
	
	function getDbDate($format = null, $timestamp = null)
	{
		if(!isset($timestamp))
		{
			$timestamp = time();
		}
		
		if(!isset($format))
		{
			$format = "Y-m-d H:i:s";
		}
		
		return date($format, $timestamp);
	}
		
	function url_exists($url)
	{
		$handle = @fopen($url,'r');
		if($handle !== false)
		{
			return true;
		}
		else
		{
		   return false;
		}
	}
	  
	function is_email($email)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
	}
	
	function html2txt($document)
	{
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
					   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
					   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
					   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
				   );
		$text = preg_replace($search, '', $document);
		return $text;
	}
	
	function getFileExtension($filename) 
	{
        return substr($filename, strrpos($filename, '.'));
    }
	
	
	
?>