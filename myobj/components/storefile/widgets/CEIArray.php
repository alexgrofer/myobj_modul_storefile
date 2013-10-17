<?php
/**
 * CMultiFileUpload class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CMultiFileUpload generates a file input that can allow uploading multiple files at a time.
 *
 * This is based on the {@link http://www.fyneworks.com/jquery/multiple-file-upload/ jQuery Multi File Upload plugin}.
 * The uploaded file information can be accessed via $_FILES[widget-name], which gives an array of the uploaded
 * files. Note, you have to set the enclosing form's 'enctype' attribute to be 'multipart/form-data'.
 *
 * Example:
 * <pre>
 * <?php
 *   $this->widget('CMultiFileUpload', array(
 *      'model'=>$model,
 *      'attribute'=>'files',
 *      'accept'=>'jpg|gif',
 *      'options'=>array(
 *         'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
 *         'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
 *         'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
 *         'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
 *         'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
 *         'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
 *      ),
 *   ));
 * ?>
 * </pre>
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.web.widgets
 * @since 1.0
 */
class CEIArray extends CInputWidget
{
    public $confKeys;
    public $file;

	public function run()
	{
        print_r($this->file);
        //$this->htmlOptions
        echo CHtml::telField('ddfdf',$this->file,$this->htmlOptions);
        echo CHtml::telField('ddfdf',$this->file,$this->htmlOptions);
        echo CHtml::telField('ddfdf',$this->file,$this->htmlOptions);
	}


    //не нужно пока
	public function registerClientScript()
	{
		$id=$this->htmlOptions['id'];

		$options=$this->getClientOptions();
		$options=$options===array()? '' : CJavaScript::encode($options);

		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('multifile');
		$cs->registerScript('Yii.CMultiFileUpload#'.$id,"jQuery(\"#{$id}\").MultiFile({$options});");
	}

	/**
	 * @return array the javascript options
	 */
	protected function getClientOptions()
	{
		$options=$this->options;
		foreach(array('onFileRemove','afterFileRemove','onFileAppend','afterFileAppend','onFileSelect','afterFileSelect') as $event)
		{
			if(isset($options[$event]) && !($options[$event] instanceof CJavaScriptExpression))
				$options[$event]=new CJavaScriptExpression($options[$event]);
		}

		if($this->accept!==null)
			$options['accept']=$this->accept;
		if($this->max>0)
			$options['max']=$this->max;

		$messages=array();
		foreach(array('remove','denied','selected','duplicate','file') as $messageName)
		{
			if($this->$messageName!==null)
				$messages[$messageName]=$this->$messageName;
		}
		if($messages!==array())
			$options['STRING']=$messages;

		return $options;
	}
}
