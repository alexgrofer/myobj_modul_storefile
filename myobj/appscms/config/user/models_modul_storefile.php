<?php
$models = array(
	//STORE
	'storefile' => array(
		'namemodel' => 'AdminModelARStoreFile',
		'order_by' => array('id DESC'),
		'controller' => array('default'=>'storefile/defmodel.php'),
	),
);
Yii::app()->params['api_conf_models'] =  array_merge(Yii::app()->params['api_conf_models'],$models);
