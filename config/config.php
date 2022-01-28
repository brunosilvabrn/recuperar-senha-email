<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

// Url base do sistema
const BASE_URL = 'http://localhost/email-reset/';
// Email do Sistema
const EMAIL_SISTEMA = 'teste@email.com';

// Database Settings
const HOST = 'localhost';
const USER = 'root';
const PASSWORD = '';
const DB_NAME = 'email_reset';