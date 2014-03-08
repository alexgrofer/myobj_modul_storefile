<?php
/**
 * Класс необходим для админки
 * Class AdminModelARStoreFile
 */
class AdminModelARStoreFile extends ModelARStoreFile
{
	/**
	 * Файл помошник для админки в представлении сохраняется
	 * @var CStoreFile
	 */
	public $thisObjFile;

	protected function beforeDelete() {
		//плагин в файле знает что делать дальше в методе del
		$this->thisObjFile->del();
		return parent::beforeDelete();
	}

	protected function beforeSave() {
		$this->thisObjFile->save();
		return parent::beforeSave();
	}

	protected function beforeValidate()
	{
		//кастомно может поменять правила проверки для модели
		$this->thisObjFile->objPlugin->validateModel();
		return parent::beforeValidate();
	}
}
