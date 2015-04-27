<?php

class EditableCompositeField extends EditableFormField {

	private static $singular_name = 'Container Field';
	
	private static $plural_name = 'Container Fields';
	
	public static $has_many = array(
		"SubFields" => "EditableFormField"
	);
	
	public function getFormField() {
		$children = $this->SubFields();
		$field = new CompositeField();
		if($children && $children->exists()) {
			foreach($children as $child) {
				$field->push($child->getFormField());
			}
		}
		return $field;
	}
	public function IsContainer(){return true;}
}