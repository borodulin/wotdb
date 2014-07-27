<div class="clearfix">
	<div class="btn-toolbar margin-bottom-10">
		<div class="btn-group">
			<?php 
				$level=0;
				while ($level<10) {
					$level++;
					if((isset($_GET['level']) && ($_GET['level']==$level))||(!isset($_GET['level'])&&($level==10)))
						$class=' active';
					else
						$class='';
					echo CHtml::link($level,array('hangars', 'level'=>$level), array('class'=>'btn btn-default'.$class));
				;
			} ?>
		</div>
	</div>
</div>