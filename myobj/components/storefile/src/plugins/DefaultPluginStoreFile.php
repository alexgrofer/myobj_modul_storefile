<?php
final class DefaultPluginStoreFile extends AbsPluginStoreFile implements IPluginStoreFileARModel
{
	const PATH_LOAD = 'media/upload/storefile'; //главная дирректория плагина, не можем изменять
	const NAME_CLASS_FILE= 'CStoreFile'; //класс самого файла
	/**
	 * Инициализация объектов файлов свойственной для этого планина, каждый плагин может по своему искать, инициализировать файлы
	 * @param null $arrIdObj список файлов
	 * @return mixed может быть массив или один объект типа NAME_CLASS_FILE
	 */
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
	//можно организовать некоторые вспомогательные методы?
}