<?php
/**
 * Класс файла который хранится в модели AR yii
 * Class CStoreFileModel
 */
class CStoreFile extends AbsCStoreFile {
	public function __construct($objPlugin) {
		$this->objPlugin = $objPlugin;
	}

	/**
	 * @var переменная хранит объект модели
	 */
	public $activeRObj;
	/**
	 * Сохранить файл в базе и на сервере (может работать через сокет если это описано в плагине)
	 */
	public function save() {
		$this->objPlugin->save($this);
	}

	/**
	 * Удалить файл и изменить объект
	 * @param integer $key
	 */
	public function del($key=null) {
		if($key) {
			unset($this->_realArrayConfObj[$key]);
		}
		$this->objPlugin->del($this,$key);
	}

	//это для EArray
	public function getNextIndex() {
		$this->objPlugin->getNextIndex($this);
	}
}