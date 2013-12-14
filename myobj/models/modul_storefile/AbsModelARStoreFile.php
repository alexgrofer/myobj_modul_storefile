<?php
/*
 * файлы всегда лежат в массиве вне зависимости одиночно будут хранится или множественно, для сортировок одиночек есть параметр size
 */
class AbsModelARStoreFile extends AbsModel
{
	public function tableName()
	{
		return 'setcms_'.strtolower(get_class($this));
	}

	//дата загрузки
	public $loadDate;
	/* Имет значение когда будет отдельная строка для каждого файла, ONE когда нужно более 10 файлов
	public $sort=null;
	public $size=null;
	*/

	//параметры которых нет в схеме таблицы
	//путь к новому файлу
	public $file;
	//загрузить файл если даже он есть
	public $force_save;
	//рандомно
	public $is_randName;
	//задать ширину
	public $width;
	//задать высоту
	public $height;
	//кропнуть
	public $is_crop;
	//архивация
	public $is_archiv;
	//end
	//conf
	/**
	 * @var DefaultPluginStoreFile Название класса плагина для обработки
	 */
	protected $namePluginLoader;
	protected $pluginConstructLoaderParamsConf;
	protected $objInitPlugin;

	public function init() {
		parent::init();
		//плагин может управлять моделью к примеру relation
		$this->objfile = yii::app()->storeFile->obj($this->pluginConstructLoaderParamsConf,$this);
	}
	protected function beforeDelete() {
		parent::beforeDelete();
		//плагин обозначенный при init знает что делать дальше в методе del
		$this->objfile->del();
		return true;
	}

	protected function beforeSave() {
		if(parent::beforeSave()!==false) {
			//плагин обозначенный при init знает что делать дальше в методе save
			$this->objfile->save();
			return true;
		}
		else return parent::beforeSave();
	}
}
