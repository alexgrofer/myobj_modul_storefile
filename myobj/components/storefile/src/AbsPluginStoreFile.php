<?php
abstract class AbsPluginStoreFile extends CComponent
{
	/**
	 * Нужно определять класс файла
	 * @return mixed
	 * return string имя класса файла
	 */
	abstract public function getClassFileName();

	/**
	 * @var Некоторые дополнительные параметры для поведения плагина (будет кропать картинки определенным способом)
	 */
	protected $_params;
	public function __construct($params=array()) {
		$this->_params = $params;
	}

	/**
	 * Фабрика объектов файлов
	 * @param null $arrIdObj
	 * @return mixed
	 */
	abstract public function factoryInit($arrIdObj=null);
}
