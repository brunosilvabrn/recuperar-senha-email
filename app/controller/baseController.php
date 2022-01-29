<?php

namespace App\controller;

class BaseController {

	// função renderizar arquivos da view
	public function renderView($arquivo) {
		
		$caminho = 'app/view/'.$arquivo;

		if (is_file($caminho.'.php')) {

			include_once $caminho.'.php';

		}else if (is_file($caminho.'.html')){

			include_once $caminho.'.html';

		}else {
			echo 'Erro view não encontrada';
		}
	}

	public function redirect($url) {

		$uri = BASE_URL.$url;
		header("location: $uri");

	}
}
