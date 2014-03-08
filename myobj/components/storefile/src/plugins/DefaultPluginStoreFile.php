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

	public function buildStoreFile(CActiveRecord $ARObj) {
		$nameClassStoreFile = $this->getClassFileName();
		//создать плагин
		$objPlugin = new DefaultPluginStoreFile();
		//создать объект класса файла
		$objStoreFile = new $nameClassStoreFile($objPlugin);
		$objStoreFile->setAutoParams($ARObj);

		$ARObj->thisObjFile = $objStoreFile;

		return $objStoreFile;
	}

	/**
	 * Инициализация объектов файлов свойственной для этого планина, каждый плагин может по своему искать, инициализировать файлы
	 * @param mixed $arrIdObj id объектов для инициализации или null если новый
	 * @return array|AbsCStoreFile
	 */
	public function factoryInit($arrIdObj=null) {
		$nameClassARModel = $this::MODEL_AR;
		$objModelStoreFile = new $nameClassARModel();

		if($arrIdObj===null) {
			return $this->buildStoreFile($objModelStoreFile);
		}
		else {
			$objModelStoreFile->dbCriteria->addInCondition('id', $arrIdObj);
			$arrayObjARStoreFile = $objModelStoreFile->findAll();
			$arrayObjStoreFile = array();
			foreach($arrayObjARStoreFile as $ARObj) {
				$arrayObjStoreFile[] = $this->buildStoreFile($ARObj);
			}

			return $arrayObjStoreFile;
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
				$this->arObj->edit_EArray($newSetting['path'],$this->arObj->getNameColEArray(),'path',$keyFile);
				$userPathFile = $newSetting['path'].DIRECTORY_SEPARATOR;
			}

			if(isset($newSetting['title'])) {
				$this->arObj->edit_EArray($newSetting['title'],$this->arObj->getNameColEArray(),'title',$keyFile);
			}

			if(isset($newSetting['sort'])) {
				$this->arObj->edit_EArray($newSetting['sort'],$this->arObj->getNameColEArray(),'sort',$keyFile);
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

				$oldNameFile = $this->arObj->get_EArray($this->arObj->getNameColEArray(), 'name', $keyFile, true);
				$oldPathFile = '';
				if($this->arObj->has_EArray($this->arObj->getNameColEArray(), 'path', $keyFile, true)) {
					$oldPathFile = $this->arObj->get_EArray($this->arObj->getNameColEArray(), 'path', $keyFile, true);
				}

				$loadFile = Yii::app()->CFile->set(self::PATH_LOAD.DIRECTORY_SEPARATOR.$oldPathFile.$oldNameFile, true);
				if($userPathFile) {
					$loadFile->createDir(0754, self::PATH_LOAD.DIRECTORY_SEPARATOR.$userPathFile);
				}
				$loadFile->rename(self::PATH_LOAD.DIRECTORY_SEPARATOR.$userPathFile.$newNameFile);

			}
			//OBJ EDIT
			if(isset($newNameFile)) {
				$this->arObj->edit_EArray($newNameFile,$this->arObj->getNameColEArray(),'name',$keyFile);
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
	public function getNextIndex() {
		return count($this->arObj->get_EArray($this->arObj->getNameColEArray()));
	}

	public static function randName($countSings) {
		$varStr = 'qwertyuiopasdfghjklzxcvbnm1234567890';
		return substr(str_shuffle($varStr.$varStr),0,$countSings);
	}
}