<?php
/**
 * Класс файла который хранится в модели AR yii
 * Class CStoreFileModel
 */
class CStoreFileARModel extends AbsCStoreFile {
	/**
	 * @var Объект модели
	 */
	protected $_objAr;

	public function __construct($objPlugin,$arObj) {
		$this->_objPlugin = $objPlugin;
		$this->_objAr = $arObj;
	}
	/**
	 * Сохранить файл в базе и на сервере (может работать через сокет если это описано в плагине)
	 */
	public function save() {
		//переписать объекты из базы данных если изменялся - делает плагин
		//сохранить файл если он изменялся - делает плагин
		//если исключение удалить файл - делает плагин
		/* @var CFile $objCFile */
		$this->_objPlugin->save($this, $this->_objAr);
	}

	/**
	 * Удалить файл и изменить объект
	 * @param integer $key
	 */
	public function del($key=null) {
		if($key) {
			unset($this->_realArrayConfObj[$key]);
		}
		$this->_objPlugin->del($this, $this->_objAr);
	}
}