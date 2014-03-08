<?php
class ModelARStoreFile extends AbsModelARStoreFile implements IEArrayModelARStoreFile
{
	public $content_file_array;

	public function getNameColEArray() {
		return 'content_file_array';
	}

	public function typesEArray() {
		return array(
			$this->getNameColEArray() => array(
				'elements' => array(
					'name',
					'title',
					'path',
					'sort',
				),
				'conf' => array(
					'isMany'=>true,
				),
				'rules'=>array(
					'*'=>array(
						array('safe'),
					),
				),
				'elementsForm' => array(
					'*'=>array(
						'type'=>'text',
					),
				),
			)
		);
	}
}
