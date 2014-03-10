<?php
/**
 * Class DefaultPluginStoreFile
 * Плагин для работы с файлами по умолчанию, работает на AR модели
 */
final class DefaultPluginStoreFile extends AbsPluginStoreFile implements IPluginStoreFileARModel
{
	const PATH_LOAD = 'media/upload/storefile'; //главная дирректория плагина, не можем изменять
	const MODEL_AR = 'ModelARStoreFile'; //модель в которой хранятся хранится файлы
	const COUNT_SING_RAND_NAME = 15;

	//обязательный метод определит название класса файла возвращаемый плагином
	public function getClassFileName() {
		return 'CStoreFile';
	}

	public function buildStoreFile(CActiveRecord $activeRObj) {
		$nameClassStoreFile = $this->getClassFileName();
		//создать плагин
		$objPlugin = new static();
		//создать объект класса файла
		$objStoreFile = new $nameClassStoreFile($objPlugin);
		//файл должен знать о модели
		$objStoreFile->activeRObj = $activeRObj;
		//модель должна знать о файле
		$objStoreFile->activeRObj->thisObjFile = $objStoreFile;

		//файл должен знать о параметрах модели
		$this->initAutoParams($objStoreFile);

		return $objStoreFile;
	}

	/**
	 * @param $arObj Заполнить поля существующего файла, не для нового
	 */
	protected function initAutoParams($objStoreFile) {
		$array = $objStoreFile->activeRObj->get_EArray($objStoreFile->activeRObj->getNameColEArray());
		foreach($array as $index => $arrayConf) {
			foreach($arrayConf as $keyName => $val) {
				$objStoreFile->autoArrayConfObj[$index][$keyName] = $val;
			}
		}
	}

	/**
	 * Инициализация объектов файлов свойственной для этого планина, каждый плагин может по своему искать, инициализировать файлы
	 * @param mixed $arrIdObj id объектов для инициализации или null если новый
	 * @return array|AbsCStoreFile
	 */
	public function factoryInit($arrIdObj=null) {
		$nameClassARModel = $this::MODEL_AR;

		if($arrIdObj===null) {
			$objModelStoreFile = new $nameClassARModel;
			$objModelStoreFile->declareObj();
			return $this->buildStoreFile($objModelStoreFile);
		}
		elseif(is_object($arrIdObj)) {
			return $this->buildStoreFile($arrIdObj);
		}
		elseif(is_int($arrIdObj)) {
			return $this->buildStoreFile($nameClassARModel::model()->findbyPk($arrIdObj));
		}
		elseif(is_array($arrIdObj)) {
			//тут сделать через model()
			//$objModelStoreFile->dbCriteria->addInCondition('id', $arrIdObj);
			//$arrayObjARStoreFile = $objModelStoreFile->findAll();
			//$arrayObjStoreFile = array();
			//foreach($arrayObjARStoreFile as $activeRObj) {
				//$arrayObjStoreFile[] = $this->buildStoreFile($activeRObj);
			//}

			//return $arrayObjStoreFile;
		}
	}

	/**
	 * описывает что делать с объектом при сохранении
	 * @param $objFile
	 */
	public function save($objFile) {
		foreach($objFile->realArrayConfObj as $keyFile => $newSetting) {
			//DATA EDIT
			$userPathFile = '';
			if(isset($newSetting['path'])) {
				$objFile->activeRObj->edit_EArray($newSetting['path'],$objFile->activeRObj->getNameColEArray(),'path',$keyFile);
				$userPathFile = $newSetting['path'].DIRECTORY_SEPARATOR;
			}

			if(isset($newSetting['title'])) {
				$objFile->activeRObj->edit_EArray($newSetting['title'],$objFile->activeRObj->getNameColEArray(),'title',$keyFile);
			}

			if(isset($newSetting['sort'])) {
				$objFile->activeRObj->edit_EArray($newSetting['sort'],$objFile->activeRObj->getNameColEArray(),'sort',$keyFile);
			}
			//МЕНЯЕТ САМ ФАЙЛ
			if(isset($newSetting['file'])) {

				$newFileUploader = $newSetting['file'];
				$loadFile = Yii::app()->CFile->set($newFileUploader->tempName, true);
				$newNameFile = (isset($newSetting['rand']))?
					self::randName(self::COUNT_SING_RAND_NAME).'.'.CFileHelper::getExtension($newFileUploader->name)
					:
					$newFileUploader->name;
				if($userPathFile) {
					$loadFile->createDir(0754, self::PATH_LOAD.DIRECTORY_SEPARATOR.$userPathFile);
				}
				$loadFile->move(self::PATH_LOAD.DIRECTORY_SEPARATOR.$userPathFile.$newNameFile);

			}
			//просто хочет переименовать существующий файл , изменить путь
			elseif(isset($newSetting['rand']) || isset($newSetting['name'])) {
				$newNameFile = (isset($newSetting['rand']))?self::randName(self::COUNT_SING_RAND_NAME):$newSetting['name'];

				$oldNameFile = $objFile->activeRObj->get_EArray($objFile->activeRObj->getNameColEArray(), 'name', $keyFile, true);
				$oldPathFile = '';
				if($objFile->activeRObj->has_EArray($objFile->activeRObj->getNameColEArray(), 'path', $keyFile, true)) {
					$oldPathFile = $objFile->activeRObj->get_EArray($objFile->activeRObj->getNameColEArray(), 'path', $keyFile, true);
				}

				$loadFile = Yii::app()->CFile->set(self::PATH_LOAD.DIRECTORY_SEPARATOR.$oldPathFile.$oldNameFile, true);
				if($userPathFile) {
					$loadFile->createDir(0754, self::PATH_LOAD.DIRECTORY_SEPARATOR.$userPathFile);
				}
				$loadFile->rename(self::PATH_LOAD.DIRECTORY_SEPARATOR.$userPathFile.$newNameFile);

			}
			//OBJ EDIT
			if(isset($newNameFile)) {
				$objFile->activeRObj->edit_EArray($newNameFile,$objFile->activeRObj->getNameColEArray(),'name',$keyFile);
			}
		}

		//создание миниатюр и т.д - вызвать спец метод именно плагина realty нужно будет просто унаследовать parent::
	}

	//описывает что делать с объектом при удалении
	public function del($objFile,$key=null) {

	}

	/**
	 * В модели AR будет в beforeValidate
	 */
	public function validateModel() {
		//можно выделить сюда переменную и менять валидацию
	}

	//методы помошники рандомы, кропы для картинок, архивация

	//индекс следующего нового элемента
	public function getNextIndex($objFile) {
		//но тут надо как то переделать для след элементов task
		return count($objFile->autoArrayConfObj);
	}

	public static function randName($countSings) {
		$varStr = 'qwertyuiopasdfghjklzxcvbnm1234567890';
		return substr(str_shuffle($varStr.$varStr),0,$countSings);
	}
}