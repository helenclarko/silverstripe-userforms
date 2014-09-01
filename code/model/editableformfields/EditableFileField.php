<?php

/**
 * Allows a user to add a field that can be used to upload a file.
 *
 * @package userforms
 */

class EditableFileField extends EditableFormField {
	
	private static $singular_name = 'File Upload Field';
	
	private static $plural_names = 'File Fields';

	public function getFieldConfiguration() {
		$field = parent::getFieldConfiguration();
		$folder = ($this->getSetting('Folder')) ? $this->getSetting('Folder') : null;

		$tree = UserformsTreeDropdownField::create(
			$this->getSettingName("Folder"),
			_t('EditableUploadField.SELECTUPLOADFOLDER', 'Select upload folder'),
			"Folder"
		);

		$tree->setValue($folder);

		$field->push($tree);

		return $field;
	}

	public function getFormField() {
		$field = new FileField($this->Name, $this->Title);

		if($this->getSetting('Folder')) {
			$folder = Folder::get()->byId($this->getSetting('Folder'));

			if($folder) {
				$field->setFolderName(
					preg_replace("/^assets\//","", $folder->Filename)
				);
			}
		}

		return $field;
	}
	
	
	/**
	 * Return the value for the database, link to the file is stored as a
	 * relation so value for the field can be null.
	 *
	 * @return string
	 */
	public function getValueFromData() {
		return null;
	}
		
	/**
	 * @return SubmittedFileField
	 */
	public function getSubmittedFormField() {
		return Injector::inst()->create('SubmittedFileField');
	}
}