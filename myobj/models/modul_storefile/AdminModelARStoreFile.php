<?php
/*
 * файлы всегда лежат в массиве вне зависимости одиночно будут хранится или множественно, для сортировок одиночек есть параметр size
 */
class AdminModelARStoreFile extends ModelARStoreFile
{
	/**
	 * @var Название плагина который будет использоваться для этой модели по умолчанию
	 */
	public $namePluginLoader=EnumerationPluginStoreFile::DEF_ADMIN;

	//тут файл
	public $thiObjFile;
	protected function beforeDelete() {
		//плагин в файле знает что делать дальше в методе del
		$this->thiObjFile->del();
		return parent::beforeDelete();
	}

	protected function beforeSave() {
		$this->thiObjFile->save();
		return parent::beforeSave();
	}

	protected function beforeValidate()
	{
		//кастомно может поменять правила проверки для модели
		$this->thiObjFile->objPlugin->validateModel();
		return parent::beforeValidate();
	}
}
