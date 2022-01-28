<div class="container">
	<div class="box-login">
		<?php if (isset($_SESSION['mensagemLogin'])) {
			echo '<div class="msg-erro-reset">'.
					$_SESSION['mensagemLogin'].
					'</div>';
			unset($_SESSION['mensagemLogin']);
		} ?>
		<?php if (isset($_SESSION['mensagemSucesso'])) {
			echo '<div class="msg-sucess">'.
					$_SESSION['mensagemSucesso'].
					'</div>';
			unset($_SESSION['mensagemSucesso']);
		} ?>
		<h1 class="title-login">Entrar</h1>
		<form method="POST" action="login/" class="form-login">	
			<span class="label-login">Email ou usuário</span>
			<input type="text" class="input-login" name="usuario" placeholder="Usuário ou Email">
			<span class="label-login">Senha</span>
			<input type="password" class="input-login" name="senha" placeholder="Senha">
			<a href="reset/" title="Recuperar senha" class="link-reset">Esqueceu sua senha?</a>
			<div class="box-submit-login">
				<input type="submit" class="submit-login" name="" value="Entrar">
			</div>
			<a href="cadastrar/" title="Clique Aqui" class="link-redirect">Não tem uma conta?</a>
		</form>
	</div>
</div>