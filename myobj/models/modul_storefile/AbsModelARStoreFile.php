<?php
class AbsModelARStoreFile extends AbsModel
{
	/**
	 * @var bool Уплавление загрузкой из админки, при работе из компонента CCStoreFile эти события не должны выполняться
	 */
	protected static $adminEdit=true;
	public function setSelfEdit($bool) {
		static::$adminEdit = $bool;
	}
	public function isSelfEdit() {
		return static::$adminEdit;
	}
	/**
	 * @var string Хранит сериализованный массив c ключами
	 * обязательные:
	 * path => 'folder1/folder2', - папка может быть пустым
	 * name => 'file.pdf', - название файла
	 * sort => '0', - сортировка
	 * и любые другие:
	 *
	 */
	public $file;
	//build
	public $set_name;
	public $set_folder;
	public $file_conf;
	public $force_save;
	public $is_randName;
	public $width;
	public $height;
	public $is_crop;
	//conf
	/**
	 * @var DefaultPluginStoreFile Название класса плагина для обработки
	 */
	protected $namePluginLoader;
	protected $pluginConstructLoaderParamsConf;
	protected $objInitPlugin;

	public function tableName()
	{
		return 'setcms_'.strtolower(get_class($this));
	}

	public function rules()
	{
		return array(

			//build

		);
	}

	public function attributeLabels() {
		return array(
			//переводы?
			'set_name'=>'name',
			'set_folder'=>'folder'
		);
	}

	public function ElementsForm() {
		return array(
			'file'=>array(
				'type'=>'CMultiFileUpload',
			),
            'file_conf'=>array(
                'type'=>'CEIArray',
                'confKeys'=>$this->objInitPlugin->arrayKeysElem,
                'file'=>$this->file
            ),
			//может резать файлы при необходимости? архивировать?
			'set_name'=>array(
				'type'=>'text',
			),
			'set_folder'=>array(
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
		);
	}
	public function init() {
		parent::init();
		if(static::$adminEdit) {
			$this->objInitPlugin = new $this->namePluginLoader($this->pluginConstructLoaderParamsConf);
		}
	}
	protected function beforeDelete() {
		parent::beforeDelete();
		//build
		if(static::$adminEdit) {
			$file = $this->objInitPlugin->buildStoreFile($this);
			$file->del();
		}
		return true;
	}

	protected function beforeSave() {
		if(parent::beforeSave()!==false) {
			//build
			if(static::$adminEdit) {
				$file = $this->objInitPlugin->buildStoreFile($this);
				$file->save();
			}
			return true;
		}
		else return parent::beforeSave();
	}
}
