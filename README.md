# Sistema de login com recuperação de senha por email
Sistema de login e cadastro de usuários com recuperação de senha utilizando php

## 🚀 Começando

Essas instruções permitirão que você consiga rodar o projeto na sua máquina ou num servidor web.

### 📋 Pré-requisitos

Ter um servidor **PHP** (apache) instalado Xampp ou Wampserver no **Windows** ou Lamp no **Linux** com **PHP** 7.3.2 ou superior.

```
Servidor Local 
Windows: Xampp ou Wampserver.
Linux: Lamp.
```

### 🔧 Instalação 

Importar as tabelas do banco de dados **sistema_login.sql** para o Mysql.

Configure o arquivo inicial do sistema.
<br>
Arquivo config/**config.php**

```
    // Url base do sistema
    const BASE_URL = 'http://localhost/email-reset/';
    
    // Email do Sistema -> email responsavel por enviar o email  de recupeção de senha
    const EMAIL_SISTEMA = 'teste@email.com';

    // Database Settings ->  configurações de acesso ao banco de dados
    const HOST = 'localhost';
    const USER = 'root';
    const PASSWORD = '';
    const DB_NAME = 'email_reset';
```

Sistema pronto para ser usado.

## 📦 Desenvolvimento

Sistema desenvolvido utilizando MVC e POO seguindo as boas praticas de programação utilizando PSR-4 e autoload composer PHP. 

- HTML5
- CSS3
- PHP 7

## 🎁 Detalhes

---

⌨️ Sistema desenvolvido por por [Bruno Lopes Silva](https://github.com/brunosilvabrn) 
