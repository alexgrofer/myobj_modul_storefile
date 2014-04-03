<?php
/**
 * Класс необходим для админки
 * Class AdminModelARStoreFile
 */
class AdminModelARStoreFile extends ModelARStoreFile
{
	protected function beforeDelete() {
		//плагин в файле знает что делать дальше в методе del
		$this->thisObjFile->del();
		return parent::beforeDelete();
	}

	protected function beforeSave() {
		$this->thisObjFile->save();
		return parent::beforeSave();
	}
}
