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
	//schema
	//тут хранится файл-лы
	public $content_file_array;
	//дата загрузки
	public $loadDate;
	/* Имет значение когда будет отдельnная строка для каждого файла, ONE когда нужно более 10 файлов
	public $sort=null;
	public $size=null;
	*/

	//параметры которых нет в схеме таблицы
	//путь к новому файлу
	public $file;
	//название для файла - если не указать то оригинальное название
	public $name;
	//описание файла
	public $title;
	//путь относительно базовой папки - базовая папки и работа с дирректориями серверами лежит в логике плагина
	public $path;
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
	//----------------------дополнительные параметры все зависит от плагина т.к он будет их проверять при сохранении объекта
	//end
	//conf
	/**
	 * @var DefaultPluginStoreFile Название класса плагина для обработки
	 */
	protected $namePluginLoader;
	protected $pluginConstructLoaderParamsConf;

	public function init() {
		parent::init();
		//плагин может управлять моделью к примеру relation
		$this->objfile = yii::app()->storeFile->obj($this->namePluginLoader,$this);
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

	public function customRules() {
		return array(
			array('cotent_file_array', 'required'),
		);
	}

	public function customAttributeLabels() {
		return array(

		);
	}

	public function customElementsForm() {
		return array(
			'file'=>array(
				'type'=>'CMultiFileUpload',
			),
			'name'=>array(
				'type'=>'text',
			),
			'title'=>array(
				'type'=>'textarea',
			),
			'path'=>array(
				'type'=>'text',
			),
			'force_save'=>array(
				'type'=>'checkbox',
			),
			'is_randName'=>array(
				'type'=>'checkbox',
			),
			'width'=>array(
				'type'=>'text',
			),
			'height'=>array(
				'type'=>'text',
			),
			'is_crop'=>array(
				'type'=>'checkbox',
			),
			'is_archiv'=>array(
				'type'=>'checkbox',
			),
		);
	}

	public function typesEArray() {
		return array(
			'content_file_array' => array(
				'elements' => array(
					'name',
					'title',
					'path',
					'sort',
				),
				'conf' => array(
					'isMany'=>true,
				),
				'rules'=>array(

				),
				'elementsForm' => array(

				),
			)
		);
	}
}
