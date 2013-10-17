<?php
final class DefaultPluginStoreFile extends AbsPluginStoreFile implements IPluginStoreFileARModel
{
	const PATH_LOAD = 'media/upload/storefile'; //главная дирректория плагина, не можем изменять
	const NAME_CLASS_FILE= 'CStoreFile';
    /**
     * @var array Ключи для модели для редактирования типа CEIArray
     */
    protected $arrayKeysElem = array('name','url','sort');
    public function getArrayKeysElem() {
        return $this->arrayKeysElem;
    }

	public function buildStoreFile($ARObj) {
		//создать объект файла
		$classStoreFile = self::NAME_CLASS_FILE;
		$objStoreFile = new $classStoreFile($this,$ARObj);
		echo $ARObj->isSelfEdit();
		echo 'тут нужно собрать объект класса что бы можно было читать его параметры<br/>';
		return $objStoreFile;
	}

	public function factoryInit($arrIdObj=null) {
		$nameClassARModel = $this->_params['ar_model_store_file'];
		$objModelStoreFile = $nameClassARModel::model();
		$objModelStoreFile->setSelfEdit($this->_params['isSelfEdit']);
		if(!$arrIdObj) {
			return $this->buildStoreFile($objModelStoreFile);
		}
		elseif(count($arrIdObj)) {
			$objModelStoreFile->dbCriteria->addInCondition('id', $arrIdObj);
			$arrayObjARStoreFile = $objModelStoreFile->findAll();
			$arrayObjStoreFile = array();
			foreach($arrayObjARStoreFile as $ARObj) {
				$arrayObjStoreFile[] = $this->buildStoreFile($ARObj);
			}
			return $arrayObjStoreFile;
		}
	}
	public function save($objFile,$ARObj) {
		echo 'у нас есть и объект файла и ar объект теперь нужно сохранить в базу данных';
		//и как тут сохранять ?
		//exit;
	}
	public function del($objFile,$ARObj) {

	}
}