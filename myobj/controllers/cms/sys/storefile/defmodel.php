<?php
$objPlugin = new $modelAD->namePluginLoader();
$modelAD::$thiObjFile = yii::app()->storeFile->obj($objPlugin,$modelAD);

$paramsQueryPostModel = yii::app()->getRequest()->getPost(get_class($modelAD));
if($paramsQueryPostModel) {
	$modelAD->attributes = $paramsQueryPostModel;
	//важный фактор только после этой конструкции форма $form начинает обрабатывать ошибки
	$isValidate = $modelAD->validate();
}

//если добавил файл или файлы,все остальные действия перекладываем на плагин и модель
if((isset($isValidate) && $isValidate) && $this->dicturls['action']=='edit') {
	$files = CUploadedFile::getInstancesByName(get_class($modelAD).'[fileAdd]');
	if($files) {
		//заливка множества файлов
		if($modelAD->indexEdit=='' && count($files)>1) {
			/* ФАЙЛЫ */
			$modelAD::$thiObjFile->filesMany = $files;
			/* РАНДОМНЫЕ ИМЕНА */
			if($modelAD->is_randName) {
				static::$thiObjFile->isRandMany = true;
			}
			/* ... */
		}
		//в случае с отдельным файлом или редактировании отдельного элемента
		elseif(count($files)==1 || $modelAD->indexEdit!='') {
			if($modelAD->indexEdit!='') {
				$indexEdit = $modelAD->indexEdit;
			}
			else {
				$indexEdit = $modelAD::$thiObjFile->objPlugin->getNextIndex();
			}
			/* ФАЙЛ */
			$modelAD::$thiObjFile->setFile($files[0],$indexEdit);
			/* ИМЯ ФАЙЛА */
			if($modelAD->is_randName) {
				static::$thiObjFile->is($indexEdit);
			}
			elseif($modelAD->nameFile!='') {
				static::$thiObjFile->setName($indexEdit);
			}
			/* ... */
		}
	}
}


