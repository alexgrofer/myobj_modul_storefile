<?php
/**
 * Класс файла который хранится в модели AR yii
 * Class CStoreFileModel
 */
class CStoreFile extends AbsCStoreFile {
	/**
	 * @var Объект модели
	 */

	public function __construct($objPlugin) {
		$this->objPlugin = $objPlugin;
	}

	/**
	 * @param $arObj Заполнить поля существующего файла, не для нового
	 */
	public  function setAutoParams($arObj) {
		if($arObj->isNewRecord===false) {
			foreach($this->getListEdit() as $index => $keyName) {
				$this->autoArrayConfObj[$index][$keyName] = $this->arObj->get_EArray($this->arObj->getNameColEArray(), 'name', $keyName, true);
			}
		}
	}
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
}