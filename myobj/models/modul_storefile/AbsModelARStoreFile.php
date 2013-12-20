<?php
/*
 * файлы всегда лежат в массиве вне зависимости одиночно будут хранится или множественно, для сортировок одиночек есть параметр size
 */
class AbsModelARStoreFile extends AbsModel
{
	public function tableName()
	{
		return 'setcms_'.strtolower(get_class($this));
	}
	//schema
	//тут хранится файл-лы
	public $content_file_array;
	//дата создания
	public $createDate;
	/* Имет значение когда будет отдельnная строка для каждого файла, ONE когда нужно более 10 файлов
	public $sort;
	public $size;

	public $top; //к примеру категория программы или фото-альбом при создании новой модели придумать название колонки или даже сделать внешний ключ
	*/
	//end

	//параметры которых нет в схеме таблицы

	//индекс(начиная с 0 earray) элемента который будет редактироваться, если пусто то новый
	public $indexEdit;
	//путь к новому файлу
	public $fileAdd;
	//название для файла - если не указать то оригинальное название
	public $nameFile;
	//описание файла
	public $title;
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

	//название плагина если редактирование из админки
	public $namePluginLoader;

	//тут файл
	public static $thiObjFile;
	protected function beforeDelete() {
		//плагин в файле знает что делать дальше в методе del
		static::$thiObjFile->del();
		return parent::beforeDelete();
	}

	protected function beforeSave() {
		static::$thiObjFile->save();
		return parent::beforeSave();
	}

	protected function beforeValidate()
	{
		//кастомно может поменять правила проверки для модели
		static::$thiObjFile->objPlugin->validateModel();
		return parent::beforeValidate();
	}

	public function customRules() {
		return array(
			array('content_file_array', 'required'),
			array('indexEdit', 'numerical', 'integerOnly'=>true),
			array('createDate', 'default',
				'value'=>new CDbExpression('NOW()'),
				'on'=>'insert', //еще бывают update,search http://www.yiiframework.com/wiki/266/understanding-scenarios
			)
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

	public function typesEArray() {
		return array(
			'content_file_array' => array(
				'elements' => array(
					'name',
					'title',
					'path',
					'sort',//при отдельном хранении файла не нужен ТУТ
				),
				'conf' => array(
					'isMany'=>true,
				),
				'rules'=>array(
					'*'=>array(
						array('safe'),
					),
				),
				'elementsForm' => array(
					'*'=>array(
						'type'=>'text',
					),
				),
			)
		);
	}
}
