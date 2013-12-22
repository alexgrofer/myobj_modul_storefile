<?php
$components_user = array(
	'storeFile'=>array(
		'class' =>'MYOBJ.components.storefile.CCStoreFile',
		'test8'=>'texttest'
	),
	'istFile'=>array(
		'class' =>'ext.ist-yii-cfile.CFile',
	),
);

Yii::app()->params['api_conf_components'] =  array_merge_recursive(Yii::app()->params['api_conf_components'],$components_user);
