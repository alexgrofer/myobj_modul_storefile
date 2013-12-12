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

	public function customRules()
	{
		return array(

			//build

		);
	}

	public function customAttributeLabels() {
		return array(
			//переводы?
			'set_name'=>'name',
			'set_folder'=>'folder'
		);
	}

	public function customElementsForm() {
		return array(
			'file'=>array(
				'type'=>'CMultiFileUpload',
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
			$objAR = $this->isNewRecord?$this:null;
			$this->objfile = yii::app()->storeFile->obj($this->pluginConstructLoaderParamsConf,$objAR);
		}
	}
	protected function beforeDelete() {
		parent::beforeDelete();
		//build
		if(static::$adminEdit) {
			$this->objfile->del();
		}
		return true;
	}

	protected function beforeSave() {
		if(parent::beforeSave()!==false) {
			//build
			if(static::$adminEdit) {
				$this->objfile->save();
			}
			return true;
		}
		else return parent::beforeSave();
	}
}
