<?php

class Html extends \Fuel\Core\Html {

	public static function attributes(array $attributes = NULL)
	{
		if (empty($attributes))
			return '';

		/*$sorted = array();
		foreach (HTML::$attribute_order as $key)
		{
			if (isset($attributes[$key]))
			{
				// Add the attribute to the sorted list
				$sorted[$key] = $attributes[$key];
			}
		}

		// Combine the sorted attributes
		$attributes = $sorted + $attributes;*/

		$compiled = '';
		foreach ($attributes as $key => $value)
		{
			if ($value === NULL)
			{
				// Skip attributes that have NULL values
				continue;
			}

			if (is_int($key))
			{
				// Assume non-associative keys are mirrored attributes
				$key = $value;
			}

			// Add the attribute value
			$compiled .= ' '.$key.'="'.Html::chars($value).'"';
		}

		return $compiled;
	}

	public static function chars($value, $double_encode = TRUE)
	{
		return htmlspecialchars( (string) $value, ENT_QUOTES, "UTF-8", $double_encode);
	}
}