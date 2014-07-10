<div class="row-fluid well">
	<div class="span2">
		<img src="/images/upload/<?php echo $data->post_id.'.'.pathinfo($data->image, PATHINFO_EXTENSION); ?>" alt="">
	</div>
	<div class="span8">
		<div class="portfolio-text-info">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->text;
			$this->endWidget();
		?>
		</div>
	</div>
	<div class="span2">
		<?php echo CHtml::link('edit', array('post/update','id'=>$data->post_id)); ?>
	</div>
</div>