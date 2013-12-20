<?php
/**
 * Класс файла который хранится в модели AR yii
 * Class CStoreFileModel
 */
class CStoreFile extends AbsCStoreFile {
	/**
	 * @var Объект модели
	 */
	protected $_objAr;

	public function __construct($objPlugin,$arObj) {
		$this->objPlugin = $objPlugin;
		$this->_objAr = $arObj;
	}
	/**
	 * Сохранить файл в базе и на сервере (может работать через сокет если это описано в плагине)
	 */
	public function save() {
		$this->objPlugin->save($this->_objAr);
	}

	/**
	 * Удалить файл и изменить объект
	 * @param integer $key
	 */
	public function del($key=null) {
		if($key) {
			unset($this->_realArrayConfObj[$key]);
		}
		$this->objPlugin->del($this->_objAr);
	}
}