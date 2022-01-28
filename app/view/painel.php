<?php $dados = $_SESSION['authUser']; ?>
<div class="painel-container">
	<nav>
		<h1 class="title-painel">SEJA BEM VINDO <?php echo $dados['nome'] ?></h1>
		<a href="painel/logout" class="sair">SAIR</a>
	</nav>
</div>