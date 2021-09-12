<?php

class Template 
{
	public $template = '';
	public $placeholders = array();

	function load( $file )
	{
		$this->template = $file;
	}

	function set( $var, $content ) 
	{
		$this->placeholders[$var] = $content;
	}

	function publish( $return = false ) 
	{
		global $db, $conf, $lang, $custom, $portal_conf, $f, $device_type, $offer_list, $geo_data, $hide_google, $page, $state_list, $lander_data, $offer_data, $citystate, $location, $keywords, $lander_template, $split_test;
	
		ob_start();
		include $this->template;
		$contents = ob_get_contents();
		
		// Now do all string replacement
		if ( is_array( $this->placeholders ) )
		{
			foreach( $this->placeholders AS $key => $value )
			{
				$contents = str_replace( '{' . $key . '}', $value, $contents );
			}
		}
		
		ob_end_clean();
		
		if ( $return == false )
		{
			echo $contents;
		}
		else
		{
			return $contents;
		}
	}
}

?>