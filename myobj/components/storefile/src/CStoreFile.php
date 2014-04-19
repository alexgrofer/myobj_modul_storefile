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
	 *  Удалит элемент сразу
	 * @param null $key если null удалит все
	 */
	public function del($key=null) {
		$this->objPlugin->del($this, $key);
	}

	//это для EArray если в одном объекте хранится много файлов
	public function getNextIndex() {
		$this->objPlugin->getNextIndex($this);
	}
}