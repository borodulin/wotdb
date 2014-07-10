<div class="row-fluid">
	<div class="span12">
<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
		'template'=>"{items}\n{pager}",
)); ?>

	</div>
</div>

