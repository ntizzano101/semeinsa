<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2><?=$titulo?></h2>
			<p><?=$mensaje?></p>
			<button onclick="<?php if(@$url_back!=""){echo "javascript:window.open('".$url_back."','_self')";} else {echo "javascript:history.back(1)";}?>" class="btn btn-primary">Volver atras</button>
		</div>
	</div>
</div>