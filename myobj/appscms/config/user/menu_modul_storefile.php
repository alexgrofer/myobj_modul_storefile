<?php
$menu_user = array(
	'ui'=>array(
		'items'=>array(
			'store_files'=>array('label'=>'store files','url'=>array('admin/objects/models/storefile')),
		),
	),
);

Yii::app()->params['api_conf_menu'] =  array_merge(Yii::app()->params['api_conf_menu'],$menu_user);
