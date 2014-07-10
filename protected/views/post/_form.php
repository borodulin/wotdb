<div class="row-fluid">
	<div class="span12">
		<?php echo CHtml::beginForm('', 'post', array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data')); ?>
			<div class="control-group">
				<label class="control-label">Image Upload</label>
				<div class="controls">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
							<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">
						</div>
						<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
						<div>
							<span class="btn btn-file">
								<span class="fileupload-new">Select image</span>
								<span class="fileupload-exists">Change</span>
								<?php echo CHtml::activeFileField($model, 'image', array('class'=>'default')); ?>
							</span>
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						</div>
					</div>
					<span class="label label-important">NOTE!</span>
					<span>
						Attached image thumbnail is
						supported in Latest Firefox, Chrome, Opera, 
						Safari and Internet Explorer 10 only
					</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">WYSIWYG Editor</label>
				<div class="controls">
					<?php echo CHtml::activeTextArea($model, 'text', array('class'=>'span12 wysihtml5 m-wrap', 'rows'=>'6')); ?>
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="button" class="btn">Cancel</button>
			</div>
		<?php echo CHtml::endForm(); ?>
		<!-- END FORM-->  
	</div>
</div>
		
<?php
	$cs = Yii::app()->clientScript;
	$cs->registerPackage('wysihtml');
	$css=$cs->getPackageBaseUrl('wysihtml').'/wysiwyg-color.css';
	$cs->registerScript($this->getId().'_wysihtml', "$('.wysihtml5').wysihtml5({stylesheets: ['$css']});", CClientScript::POS_READY);
?>