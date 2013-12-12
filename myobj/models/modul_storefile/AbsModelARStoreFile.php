<?php
class AbsModelARStoreFile extends AbsModel
{
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

	public function init() {
		parent::init();
		$objAR = $this->isNewRecord?$this:null;
		$this->objfile = yii::app()->storeFile->obj($this->pluginConstructLoaderParamsConf,$objAR);
	}
	protected function beforeDelete() {
		parent::beforeDelete();
		$this->objfile->del();
		return true;
	}

	protected function beforeSave() {
		if(parent::beforeSave()!==false) {
			//build
			$this->objfile->save();
			return true;
		}
		else return parent::beforeSave();
	}
}
