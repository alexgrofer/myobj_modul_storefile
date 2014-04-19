<?php
$idObj = null; //если новый , если нет то передать массив из одного или id Решить
$objFile = yii::app()->storeFile->obj(EnumerationPluginStoreFile::DEF_ADMIN,$modelAD);
//$objFile->activeRObj->thisObjFile = $objFile;
//$modelAD = $objFile->activeRObj;

$paramsQueryPostModel = yii::app()->getRequest()->getPost(get_class($modelAD));
if($paramsQueryPostModel) {
	$modelAD->attributes = $paramsQueryPostModel;
	//важный фактор только после этой конструкции форма $form начинает обрабатывать ошибки
	$isValidate = $modelAD->validate();
}

//можно удалять отдельные элементы
if($modelAD->is_del && $modelAD->indexEdit!='') {
	$objFile->del($modelAD->indexEdit);
}
//если добавил файл или файлы,все остальные действия перекладываем на плагин и модель
if((isset($isValidate) && $isValidate) && $this->dicturls['action']=='edit') {
	$files = CUploadedFile::getInstancesByName(get_class($modelAD).'[fileAdd]');

	if($modelAD->indexEdit!='') {
		//если он сам передает какой элемент будт менять
		$indexEdit = $modelAD->indexEdit;
	}
	else {
		$indexEdit = $objFile->plugin->getNextIndex();
	}

	$lambda_key = function($indexEdit) use($modelAD,$objFile) {
		if($modelAD->nameFile) {
			$objFile->set_Name($modelAD->nameFile,$indexEdit);
		}
		if($modelAD->title) {
			$objFile->set_Title($modelAD->title,$indexEdit);
		}
		if($modelAD->file_sort) {
			$objFile->set_Sort($modelAD->file_sort,$indexEdit);
		}
		if($modelAD->path) {
			$objFile->set_Path($modelAD->path,$indexEdit);
		}
		if($modelAD->is_randName) {
			$objFile->set_IsRand(true,$indexEdit);
		}
		elseif($modelAD->nameFile!='') {
			$objFile->set_Name($modelAD->nameFile,$indexEdit);
		}
		if($modelAD->is_del) {
			$objFile->plugin->del($indexEdit);
		}
	};

	if(count($files)) {
		foreach($files as $file) {
			/* ФАЙЛ */
			$objFile->set_File($file,$indexEdit);
			/* ИМЯ ФАЙЛА */
			$lambda_key($indexEdit);
			$indexEdit++;
		}
	}
	else {
		$lambda_key($indexEdit);
	}

}
/*
 * продолжиться дальнейшее исполнение obj.php контроллера который вызовет метод save
 */


