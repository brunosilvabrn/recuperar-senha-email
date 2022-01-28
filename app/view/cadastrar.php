<div class="container">
	<div class="box-login">
		<?php if (isset($_SESSION['mensagemCodigo'])) {
			echo '<div class="msg-erro-reset">'.
					$_SESSION['mensagemCodigo'].
					'</div>';
			unset($_SESSION['mensagemCodigo']);
		} ?>
		<h1 class="title-login">Criar conta</h1>
		<form method="POST" action="" class="form-login">	
			<span class="label-login">Usuario</span>
			<input type="text" class="input-login" name="nome" placeholder="Usuário" required>
			<span class="label-login">Email</span>
			<input type="email" class="input-login" name="email" placeholder="Email" required>
			<span class="label-login">Senha</span>
			<input type="password" class="input-login" name="senha" placeholder="Senha" minlength="6" required>
			<span class="label-login">Confirmar Senha</span>
			<input type="password" class="input-login" minlength="6" placeholder="Confirmar senha" name="confirmarSenha">
			<div class="box-submit-login">
				<input type="submit" class="submit-login" name="" value="Cadastrar">
			</div>
			<a href="login/" title="Recuperar senha" class="link-reset">já tem uma conta?</a>
		</form>
	</div>
</div>