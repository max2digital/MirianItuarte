<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa user o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'max2d748_mirian');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'max2d748_mirian');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'mirian');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'sP&HOPI)zUEJGS2*EV*PVAsWcczD2P^+O?/VE3xOba:flpREvJ&?ZbB#|s.}>J-f');
define('SECURE_AUTH_KEY',  '-{C89<KC2Ivly{Yiz&`kn7lD29ONF|@.hQ]&vQ5L$-WSj}[w(wB6AH;I-vY=Yj39');
define('LOGGED_IN_KEY',    '+V;@5v0e2x54#/ixR^qQ@E#C}#la/kTX.2C{a.h37#U!Q~>x=dz@Oagd~/b>9:FK');
define('NONCE_KEY',        'C,jagVS,N$27(6B|X2ZeH@1OZx@[:efbw^-aB@P}V9d8b:7o9)p >A{+r|E;M+_t');
define('AUTH_SALT',        '&`_9`8B+is^>kn$pde#_>8Wzcxt3{I,-`7 K,1/;#*L +i!iV)Fp B/H18e{s.,r');
define('SECURE_AUTH_SALT', 'n%A^JjnPo__*dYD,tz:O7&EaJY,SmHFl(F@Hi`>6juDS1awUdv9EC~Tmd0ddi^[i');
define('LOGGED_IN_SALT',   'JR~Qmrb=j&zEz{=eD2:{-gQxi3`Yy.Z]Jm:V,CJ$7@/I.6|On8VuF~XVmY/b8L%{');
define('NONCE_SALT',       'heVmXMe&P@J#+U50%<[n#q`H>i19W/4BQW^.0=zYiW;I6:~Ma2nx3@v;O`eJ#=|<');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * para cada um um único prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'mirian_';

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
