<div class="container">
	<div class="box-login">
		<?php if (isset($_SESSION['mensagemReset'])) {
			echo '<div class="msg-erro-reset">'.
					$_SESSION['mensagemReset'].
					'</div>';
			unset($_SESSION['mensagemReset']);
		} ?>
		<h3 class="title-login center">Esqueceu sua senha?<br>Digite seu email logo abaixo.</h3>
		<form method="POST" action="" class="form-login">	
			<span class="label-login">Email</span>
			<input type="email" class="input-login" name="email" placeholder="seuemail@email.com" required="">
			<div class="box-submit-login">
				<input type="submit" class="submit-login" name="" value="Enviar">
			</div>
			<a href="login/" title="Recuperar senha" class="link-reset">Voltar</a>
		</form>
	</div>
</div>