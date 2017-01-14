<im-modal>

	<div class="section">

		<form action="/uploadCsv" method="post" enctype="multipart/form-data">

			<?php echo csrf_field(); ?>

			<p class="control">
				<input type="file" name="csv" id="csv">
			</p>

			<button type="submit" class="button is-primary">Upload</button>

		</form>

	</div>

</im-modal>