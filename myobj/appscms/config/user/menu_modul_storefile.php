<?php
$menu_user = array(
	'storefile'=>array(
        'label'=>'store file','url'=>array('#'),
		'items'=>array(
			'store_files_def'=>array('label'=>'files','url'=>array('admin/objects/models/storefile')),
		),
	),
);

Yii::app()->params['api_conf_menu'] =  array_merge(Yii::app()->params['api_conf_menu'],$menu_user);
