<div class="container">
	<div class="box-login">
		<?php if (isset($_SESSION['mensagemCodigo'])) {
			echo '<div class="msg-erro-reset">'.
					$_SESSION['mensagemCodigo'].
					'</div>';
			unset($_SESSION['mensagemCodigo']);
		} ?>
		<h2 class="title-login center">Digite o código que foi enviado para:</h2>
		<span class="label-email-reset"><?php echo $_SESSION['emailCodigo'] ?></span>
		<form method="POST" action="" class="form-login">	
			<span class="label-login">codigo</span>
			<input type="text" id="codigo" maxlength="13" class="input-cod" name="codigo">
			<div class="box-submit-login">
				<input type="submit" class="submit-login" name="" value="Enviar">
			</div>
			<a href="reset" title="Recuperar senha" class="link-reset">Voltar</a>
		</form> 
	</div>
</div>
<script type="text/javascript">

	document.addEventListener('keydown', function(event) { 
		if(event.keyCode != 46 && event.keyCode != 8) {
			let i = document.getElementById("codigo").value.length;
			if (i == 1 || i == 5 || i == 9) {
				document.getElementById("codigo").value = document.getElementById("codigo").value + " - ";
			}
		}
	});

</script>