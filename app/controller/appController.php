<?php

namespace App\controller;

use Bramus\Router\Router;
use App\model\UsuariosModel;

class AppController extends BaseController {

	public function app() {

		$router = new Router();

		$router->get('/', function() {
			
			if (!isset($_SESSION['authUser']) || empty($_SESSION['authUser'])) {
				$this->redirect('login');
			}

			$this->renderView('layout/header');
		    $this->renderView('painel');
		    $this->renderView('layout/footer');

		});

		$router->get('/login', function() {
			if (isset($_SESSION['authUser']) || !empty($_SESSION['authUser'])) {
				$this->redirect('');
			}
		    $this->renderView('layout/header');
		    $this->renderView('login');
		    $this->renderView('layout/footer');
		});

		$router->post('/login', function() {
			$login = new UsuariosModel();
			$nome = $_POST['usuario'];
			$senha = $_POST['senha'];
			if($login->login($nome, $senha)) {
				$_SESSION['authUser'] = ['nome' => $nome];
			    $this->redirect('');
			}else {
				$_SESSION['mensagemLogin'] = 'Senha e/ou usuário incorreto/s';
				$this->redirect('login');
			}
		});
		
		$router->get('/cadastrar', function() {	
			if (isset($_SESSION['authUser']) || !empty($_SESSION['authUser'])) {
				$this->redirect('');
			}
		    $this->renderView('layout/header');
		    $this->renderView('cadastrar');
		    $this->renderView('layout/footer');
		});

		$router->post('/cadastrar', function() {

		    $user = new UsuariosModel();
		    $nome = $_POST['nome'];
		    $email = $_POST['email'];
		    $senha = $_POST['senha'];
		    $confirmarSenha = $_POST['confirmarSenha'];

		    if($senha == $confirmarSenha) {
			    if ($user->cadastrar($nome, $email, $senha)) {
			    	$_SESSION['authUser'] = ['nome' => $nome];
			    	$this->redirect('');
			    }else {
			    	echo 'erro ao cadastrar';
			    }
		    }else {
		    	$_SESSION['mensagemCodigo'] = 'Senha e confirmar senha não correspondem';
		    	$this->redirect('cadastrar');
		    }	    
		});

		
		$router->get('/reset', function() {
			unset($_SESSION['emailCodigo']);
		    $this->renderView('layout/header');
		    $this->renderView('reset');
		    $this->renderView('layout/footer');
		});

		$router->post('/reset', function() {
			$user = new UsuariosModel();
			$email = $_POST['email'];
			if($user->verificarEmail($email)) {
				
				if($user->sendEmail($email)){
					$_SESSION['emailCodigo'] = $email;
					$this->redirect('codigo');
				}else {
					$_SESSION['mensagemReset'] = 'Erro ao enviar o email';
					$this->redirect('reset');
				}


			}else {
				$_SESSION['mensagemReset'] = 'Esse email não esta atribuido a nenhum usuário cadastrado!';
				$this->redirect('reset');
			}

		});
		
		$router->get('/reset/codigo/{hash}', function($hash) {
			$user = new UsuariosModel();
			if($user->verificarCodigo($hash)){
				$url = $user->getUrl($hash);
				$this->redirect('novasenha/'.$url);
			}else{
				$this->renderView('layout/header');
			    $this->renderView('invalido');
			    $this->renderView('layout/footer');
			}
		});

		$router->get('/codigo', function() {
			if (isset($_SESSION['emailCodigo'])) {
			    $this->renderView('layout/header');
			    $this->renderView('codigo');
			    $this->renderView('layout/footer');
			}else {
				$this->redirect('reset');
			}
		});

		$router->post('/codigo', function() {
			if (isset($_SESSION['emailCodigo'])) {
	
			    $codigo = $_POST['codigo'];
			    $codigo = str_replace('-', '', $codigo);
			    $codigo = str_replace(' ', '', $codigo);
			    
			    $user = new UsuariosModel();

				if($user->verificarCodigo($codigo)){
					$url = $user->getUrl($codigo);
					$this->redirect('novasenha/'.$url);
				}else{
					$_SESSION['mensagemCodigo'] = 'Código Inválido!';
					$this->redirect('codigo');
				}
			}else {
				$this->redirect('reset');
			}
		});
		
		$router->get('/novasenha/{url}', function($url) {
			$user = new UsuariosModel();

			if ($user->verificarUrl($url)) {
			    $this->renderView('layout/header');
			    $this->renderView('novasenha');
			    $this->renderView('layout/footer');
			}else {
				$this->renderView('layout/header');
			    $this->renderView('invalido');
			    $this->renderView('layout/footer');
			}
		});

		$router->post('/novasenha/{url}', function($url) {

			$user = new UsuariosModel();
			$senha = $_POST['senha'];
			
			if (!empty($senha)) {
				if ($user->trocarSenha($url, $senha)) {
					unset($_SESSION['emailCodigo']);
					$_SESSION['mensagemSucesso'] = "Senha alterada com sucesso";
					$user->invalidarReset($url);
					$this->redirect('login/');
				}
			}else {
				$this->redirect('novasenha/'.$url);
			}

		});
		
		$router->get('/painel/logout', function() {
			session_destroy();
			$this->redirect('');
		});

		$router->set404(function() {
		    header('HTTP/1.1 404 Not Found');
		    $this->renderView('layout/header');
		    $this->renderView('404');
		    $this->renderView('layout/footer');
		});

		$router->run();

	}
}

