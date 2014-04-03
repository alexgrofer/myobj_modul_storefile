<?php
/*
 * файлы всегда лежат в массиве вне зависимости одиночно будут хранится или множественно, для сортировок одиночек есть параметр size
 */
abstract class AbsModelARStoreFile extends AbsModel
{
	/**
	 * Экземпляр объекта файла может быть полезен в моделе
	 * @var CStoreFile
	 */
	public $thisObjFile;

	public function tableName()
	{
		return 'setcms_modelarstorefile';
	}

	//дата создания
	public $createDate;
	/* Имет значение когда будет отдельная строка для каждого файла, ONE когда нужно более 10 файлов
	public $name;
	public $title;
	public $path;
	public $sort;
	public $size;

	public $top; //к примеру категория программы или фото-альбом при создании новой модели придумать название колонки или даже сделать внешний ключ
	*/

	//параметры которых нет в схеме таблицы

	//индекс(начиная с 0 earray) элемента который будет редактироваться, если пусто то новый
	public $indexEdit;
	//название для файла - если не указать то оригинальное название
	public $nameFile;
	//описание файла
	public $title;
	//сортировка
	public $file_sort;
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
	//удалить элемент
	public $is_del;
	//----------------------дополнительные параметры все зависит от плагина т.к он будет их проверять при сохранении объекта
	//end
	//conf

	public function customRules() {
		return array(
			array($this->getNameColEArray(), 'safe'),
			array('indexEdit', 'numerical', 'integerOnly'=>true),
			array('createDate', 'default',
				'value'=>new CDbExpression('NOW()'),
				'on'=>'insert', //еще бывают update,search http://www.yiiframework.com/wiki/266/understanding-scenarios
			),
			//not real elem
			array('indexEdit','safe'),
			array('nameFile','safe'),
			array('title','safe'),
			array('file_sort','safe'),
			array('path','safe'),
			array('force_save','safe'),
			array('is_randName','safe'),
			array('width','safe'),
			array('height','safe'),
			array('is_crop','safe'),
			array('is_archiv','safe'),
			array('is_del','safe'),
		);
	}

	public function customAttributeLabels() {
		return array(

		);
	}

	public function customElementsForm() {
		return array(
			'indexEdit'=>array(
				'type'=>'text',
			),
			'fileAdd'=>array(
				'type'=>'CMultiFileUpload',
			),
			'nameFile'=>array(
				'type'=>'text',
			),
			'title'=>array(
				'type'=>'textarea',
			),
			'file_sort'=>array(
				'type'=>'text',
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
			'is_del'=>array(
				'type'=>'checkbox',
			),
			'<hr/>files: <span style="color: red">not edit element IF want edit file!! only DB saves</span><hr/>'
		);
	}

	//protected function beforeValidate()
	//{
	//кастомно может поменять правила проверки для модели
	//$this->thisObjFile->objPlugin->validateModel();
	//return parent::beforeValidate();
	//}
}
