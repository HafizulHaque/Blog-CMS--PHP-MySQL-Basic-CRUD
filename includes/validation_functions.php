<?php 

	$errors;

	function field_name_as_text($name){
		return ucfirst(str_replace("_", " ", $name));
	}
	
	function has_presence($value){
		return isset($value) && trim($value) !=="";
	}
	function validate_persences($field_names){
		global $errors;
		foreach ($field_names as $field_name) {
			if(!has_presence($_POST[$field_name])){
				$errors[] = "Fill in " . field_name_as_text($field_name) . " field.";
			}
		}
	}

	function has_max_length($value, $len){
		return strlen(trim($value))<=$len;
	}
	function validate_max_lengths($field_names_with_max_length){
		global $errors;
		foreach ($field_names_with_max_length as $field_name => $max_len) {
			if(!has_max_length($_POST[$field_name], $max_len)){
				$errors[] = field_name_as_text($field_name) . " field is too long.";
			}
		}
	}

?>