<?php

namespace App\model;

class UsuariosModel extends BaseModel {

	public function login($usuario, $senha){

		$pdo = $this->connect();

		$sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :usuario OR nome = :usuario");
		$sql->bindValue(':usuario', $usuario);
		$sql->execute();

		if ($sql->rowCount() > 0) {

			$dados = $sql->fetch();
			$verificar = $dados['senha'];

			if (password_verify($senha, $verificar)) {
				return true;
			}else {
				return false;
			}
		}else {	
			return false;
		}
	}

	public function cadastrar($nome, $email, $senha){

		$pdo = $this->connect();

		$senha = password_hash($senha, PASSWORD_DEFAULT);

		$sql = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
		$sql->bindValue(':nome', $nome);
		$sql->bindValue(':email', $email);
		$sql->bindValue(':senha', $senha);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			return true;
		}else {
			return false;
		}
	}

	public function verificarEmail($email){

		$pdo = $this->connect();

		$sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
		$sql->bindValue(':email', $email);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			return true;
		}else {
			return false;
		}
	}

	public function verificarCodigo($codigo){

		$pdo = $this->connect();

		$sql = $pdo->prepare("SELECT * FROM recuperar WHERE link = :codigo OR codigo = :codigo");
		$sql->bindValue(':codigo', $codigo);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$dados = $sql->fetch();
			$valido = $dados['valido'];
			if ($valido) {
				$horaAtual = (int) $hora = date('Hi');
				$horaMaxima = (int) $dados['limite'];
				if ($horaAtual <= $horaMaxima) {
					return true;
				}
			}
		}

		return false;
		
	}

	public function getUrl($codigo) {

		$pdo = $this->connect();
		$sql = $pdo->prepare("SELECT * FROM recuperar WHERE link = :codigo OR codigo = :codigo");
		$sql->bindValue(':codigo', $codigo);
		$sql->execute();
		$dados = $sql->fetch();
		$url = $dados['auth'];

		return $url;
	}

	public function verificarUrl($url) {
		
		$pdo = $this->connect();

		$sql = $pdo->prepare("SELECT * FROM recuperar WHERE auth = :url");
		$sql->bindValue(':url', $url);
		$sql->execute();

		if ($sql->rowCount() > 0){

			$dados = $sql->fetch();
			$horaLimite = $dados['limite'];
			$dataLimite = $dados['data'];
			$valido = $dados['valido'];
			$horaAtual = date('Hi');
			$dataAtual = date('dmY');

			if ($horaAtual <= $horaLimite && $dataLimite == $dataAtual && $valido) {
				return true;
			}
		}

		return false;

	}

	public function sendEmail($email) {

		$hora = date('Hi');
		$data = date('dmY');

		$codigo = rand(1000, 9999);
		$link = md5($codigo);

		$auth = random_bytes(4);
		$auth = bin2hex($auth);

		$limite = strtotime($hora) + 60*5;
		$limite = (int) strftime('%H%M',$limite);

		if ($this->saveReset($email, $codigo, $link, $auth, $limite, $data, $hora, true)) {
			if ($this->emailSender($email, $codigo, $link)) {
				return true;
			}
		}
	}

	public function saveReset($email, $codigo, $link, $auth, $limite, $data, $hora, $valido) {
		$pdo = $this->connect();
		$sql = $pdo->prepare("INSERT INTO recuperar (email, codigo, link, auth, limite, data, hora, valido) VALUES (:email, :codigo, :link, :auth, :limite, :data, :hora, :valido)");
		$sql->bindValue(':email', $email);
		$sql->bindValue(':codigo', $codigo);
		$sql->bindValue(':link', $link);
		$sql->bindValue(':auth', $auth);
		$sql->bindValue(':limite', $limite);
		$sql->bindValue(':data', $data);
		$sql->bindValue(':hora', $hora);
		$sql->bindValue(':valido', $valido);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			return $auth;
		}
	}

	public function trocarSenha($codigo, $senha) {

		$pdo = $this->connect();
		$sql = $pdo->prepare("SELECT * FROM recuperar WHERE auth = :codigo");
		$sql->bindValue(':codigo', $codigo);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$dados = $sql->fetch();
			$email = $dados['email'];

			if ($this->setSenha($email, $senha)) {
				return true;
			}
		}

	}

	public function invalidarReset($hash) {

		$pdo = $this->connect();
		$sql = $pdo->prepare("UPDATE recuperar SET valido = :comando WHERE auth = :auth");
		$sql->bindValue(':comando', 0);
		$sql->bindValue(':auth', $hash);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			return true;
		}

	}

	public function setSenha($email, $senha) {
		$pdo = $this->connect();
		$sql = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE email = :email");
		$sql->bindValue(':senha', password_hash($senha, PASSWORD_DEFAULT));
		$sql->bindValue(':email', $email);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			return true;
		}
	}

	public function emailSender($email, $codigo, $link) {

		$receber = $email;
		$subtitulo = "Código recuperar senha";
		$body = 'Código: '.$codigo.' ou acesse o link <a href="'.BASE_URL.'reset/codigo/'.$link.'">CLIQUE AQUI</a>';
		$sender = 'from:'.;

		if (mail($receber, $subtitulo, $body, $sender)) {
			return true;
		}else {
			return false;
		}

		
	    $from = EMAIL_SISTEMA;
	    $to = $email;
	    $subject = "Checking PHP mail";
	    $message = 'Código: '.$codigo.' ou acesse o link <a href="'.BASE_URL.'reset/codigo/'.$link.'">CLIQUE AQUI</a>';
	    $headers = "From:" . $from;

	    if(mail($to,$subject,$message, $headers)) {
	    	return true;
	    }else {
	    	return false;
	    }
	}

} 
