<?php
abstract class AbsCStoreFile extends CComponent {
	/**
	 * @var DefaultPluginStoreFile объект плагина
	 */

	//у каждого объекта должен быть плагин для поведения
	public $objPlugin;

	//у каждого объекта должен быть уникальный id
	private $_id;

	public function getNamePlugin() {
		return get_class($this->objPlugin);
	}
	public function getId() {
		return $this->_id;
	}

	public $realArrayConfObj=array();

	protected function _getDefParam($name,$key) {
		return (isset($this->realArrayConfObj[$key]) && isset($this->realArrayConfObj[$key][$name]))?
			$this->realArrayConfObj[$key][$name]
			:
			null;
	}
	protected function _setDefParam($name,$key,$val) {
		$this->realArrayConfObj[$key][$name] = $val;
	}

	//относительный путь к файлу
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

	//установить описание для файла
	public function set_Title($title,$key) {
		$this->_setDefParam('title',$key,$title);
	}
	public function get_Title($key) {
		return $this->_getDefParam('title',$key);
	}

	//сортировка файлов
	public function set_Sort($sort,$key) {
		$this->_setDefParam('sort',$key,$sort);
	}
	public function get_Sort($key) {
		return $this->_getDefParam('sort',$key);
	}

	//not real это не сохранятся только для признака что делать с файлом
	//установить новый файл
	public function set_File(CUploadedFile $path,$key) {
		$this->_setDefParam('file',$key,$path);
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

	//+остальные необходимые методы, допустимы также в классе наследнике

	//end not real
}
