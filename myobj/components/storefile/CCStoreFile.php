<?php
class CCStoreFile extends CComponent {
	private $test8;
	public function  setTest8($val) {
		$this->test8 = $val;
	}
	public function getTest8() {
		return $this->test8;
	}
	public function init() {
		//import
		Yii::import('MYOBJ.components.storefile.src.*');
		Yii::import('MYOBJ.components.storefile.src.plugins.*');
        Yii::import('MYOBJ.components.storefile.behaviors.*');
        Yii::import('MYOBJ.components.storefile.widgets.*');
		Yii::import('MYOBJ.models.modul_storefile.*');
	}

	/**
	 * Инициализирует объекты с необходимым плагином для работы
	 * @param mixed $objPlugin название плагина или сконфигурированный объект обязателен
	 * @param mixed $arrIdObj по сути можно передать все что угодно зависит от плагина
	 * @return mixed возвращает объект или список(array) объектов класса FileStoreCms
	 */
	public function obj($objPlugin=null,array $arrIdObj=null) {
		if(!is_object($objPlugin)) {
			$objPlugin = new $objPlugin();
		}
		if($arrIdObj) {
			return $objPlugin->factoryInit($arrIdObj);
		}
		else {
			return $objPlugin->factoryInit(null);
		}
	}
}
