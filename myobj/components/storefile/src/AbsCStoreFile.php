<?php
abstract class AbsCStoreFile extends CComponent {
	private $_id;
	public function getId() {
		return $this->_id;
	}
	public function setId($id) {
		return $this->_id = $id;
	}

	/**
	 * @var DefaultPluginStoreFile объект плагина
	 */
	public $objPlugin;

	/**
	 * @return array Список возможных для редактирования полей
	 */
	protected function getListEdit() {
		return array(
			'name',
			'path',
			'title',
			'sort',
		);
	}

	/**
	 * @var array Массив заполняется ключами в случае изменения ключей объекта
	 */
	public $realArrayConfObj=array();
	/**
	 * @var array Массив заполняется реальными данными из уже существующего объекта.
	 * Для новых объектов он пуст
	 */
	public $autoArrayConfObj=array();

	protected function _getDefParam($name,$key) {
		return (isset($this->realArrayConfObj[$key]) && isset($this->realArrayConfObj[$key][$name]))?
			$this->realArrayConfObj[$key][$name]
			: //если не заполнен новым значением то вернуть то что было при инициализации объекта AR
			(isset($this->autoArrayConfObj[$key]) && isset($this->autoArrayConfObj[$key][$name]))?
				$this->realArrayConfObj[$key][$name]
				:
				null
			;
	}
	protected function _setDefParam($name,$key,$val) {
		$this->realArrayConfObj[$key][$name] = $val;
	}

	public function set_Name($name,$key) {
		$this->_setDefParam('name',$key,$name);
	}
	public function get_Name($key) {
		return $this->_getDefParam('name',$key);
	}

	public function set_Path($title,$key) {
		$this->_setDefParam('path',$key,$title);
	}
	public function get_Path($key) {
		return $this->_getDefParam('path',$key);
	}

	public function set_Title($title,$key) {
		$this->_setDefParam('title',$key,$title);
	}
	public function get_Title($key) {
		return $this->_getDefParam('title',$key);
	}

	public function set_Sort($sort,$key) {
		$this->_setDefParam('sort',$key,$sort);
	}
	public function get_Sort($key) {
		return $this->_getDefParam('sort',$key);
	}

	//ВСПОМОГАТЕЛЬНЫЕ МЕТОДЫ, НЕ ЯВЛЯЮТСЯ ХРАНИМЫМИ ДАННЫМИ

	/**
	 * @param mixed $file можно загрузить один или множество файлов
	 * @param $key
	 */
	public function set_File($file,$key) {
		$this->_setDefParam('file',$key,$file);
	}
	public function get_File($key) {
		return $this->_getDefParam('file',$key);
	}

	//установить новое название для файла
	public function set_IsRand($bool,$key) {
		$this->_setDefParam('rand',$key,$bool);
	}
	public function get_IsRand($key) {
		return $this->_getDefParam('rand',$key);
	}
}
