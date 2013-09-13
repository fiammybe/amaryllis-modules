<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /language/portuguesebr/common.php
 * 
 * portuguesebr common language file
 * Tradutor: Everton Lopes 05/07/2012
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: common.php 644 2012-06-30 12:28:12Z st.flohrer $
 * @package		icmspoll
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
/**
 * constants for poll objects
 */
define("_CO_ICMSPOLL_POLLS_QUESTION", "Questão");
define("_CO_ICMSPOLL_POLLS_DESCRIPTION", "Descrição");
define("_CO_ICMSPOLL_POLLS_DELIMETER", "Selecione o delimitador a ser utilizado");
define("_CO_ICMSPOLL_POLLS_DELIMETER_DSC", "opções de delimitadores");
define("_CO_ICMSPOLL_POLLS_USER_ID", "Author da enquete");
define("_CO_ICMSPOLL_POLLS_START_TIME", "Inicio");
define("_CO_ICMSPOLL_POLLS_END_TIME", "Fim");
define("_CO_ICMSPOLL_POLLS_VOTES", "Total votos");
define("_CO_ICMSPOLL_POLLS_VOTERS", "Total eleitores");
define("_CO_ICMSPOLL_POLLS_DISPLAY", "Exibir em bloco?");
define("_CO_ICMSPOLL_POLLS_WEIGHT", "...");
define("_CO_ICMSPOLL_POLLS_MULTIPLE", "Permite multiplas seleções?");
define("_CO_ICMSPOLL_POLLS_MAIL_STATUS", "Notificar o autor quando expirar?");
define("_CO_ICMSPOLL_POLLS_EXPIRED", "Expirada?");
define("_CO_ICMSPOLL_POLLS_STARTED", "Iniciada?");
define("_CO_ICMSPOLL_POLLS_CREATED_ON", "Criado em");

define("_CO_ICMSPOLL_POLLS_VIEWPERM", "Permissão de Visualização");
define("_CO_ICMSPOLL_POLLS_VIEWPERM_DSC", "Selecionar grupo que pode visualizar a enquete");
define("_CO_ICMSPOLL_POLLS_VOTEPERM", "Permissão Voto");
define("_CO_ICMSPOLL_POLLS_VOTEPERM_DSC", "Selecione o grupo que pode votar");
define("_CO_ICMSPOLL_POLLS_DELIMETER_BRTAG", "BR-Tag (&lt;br /&gt;)");
define("_CO_ICMSPOLL_POLLS_DELIMETER_SPACE", "Space (&amp;nbsp;)");

define("_CO_ICMSPOLL_POLLS_MESSAGE_SUBJECT", "Sua enquete está expirada");
define("_CO_ICMSPOLL_POLLS_MESSAGE_BDY", "Sua enquete %s está expirada, você pode ver o resultado agora.");
define("_CO_ICMSPOLL_POLLS_GET_MORE_BY_USER", "Obter mais sondagens por ");
define("_CO_ICMSPOLL_POLLS_GET_MORE_RESULTS_BY_USER", "Obter mais resultados por");
define("_CO_ICMSPOLL_POLLS_FILTER_ACTIVE", "Enquetes Ativas");
define("_CO_ICMSPOLL_POLLS_FILTER_EXPIRED", "Enquetes Expiradas");
define("_CO_ICMSPOLL_POLLS_ENDTIME_ERROR", "O final da enquete deve ser definido com data maoir que a inicial");
define("_CO_ICMSPOLL_POLLS_FILTER_INACTIVE", "Inativo");
define("_CO_ICMSPOLL_POLLS_FILTER_STARTED", "Iniciado");
define("_CO_ICMSPOLL_RESET", "Reiniciar apuração da Enquete: Esta ação não pode ser desfeita! Uma vez clicado e sua votação será resetada. Todas as entradas de log serão excluídos!");
/**
 * constants for options objects
 */
define("_CO_ICMSPOLL_OPTIONS_POLL_ID", "Selecionar Enquete");
define("_CO_ICMSPOLL_OPTIONS_POLL_ID_DSC", "");
define("_CO_ICMSPOLL_OPTIONS_OPTION_TEXT", "Opções");
define("_CO_ICMSPOLL_OPTIONS_OPTION_TEXT_DSC", "Opção a ser exibida");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COLOR", "Cor da Opção");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COLOR_DSC", "Selecione a cor da barra a ser exibida para essa opção");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COUNT", "Quantidades de votos");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COUNT_DSC", "");
define("_CO_ICMSPOLL_OPTIONS_USER_ID", "Criado por");
define("_CO_ICMSPOLL_OPTIONS_OPTION_INIT", "Valor Incial");
define("_CO_ICMSPOLL_OPTIONS_OPTION_INIT_DSC", "Você gostaria de definir um valor inicial. Isso será mostrado em todos os resultados para os usuários, e não nos resultados para os administradores do módulo.");

define("_CO_ICMSPOLL_OPTIONS_VOTES", "Votos");
// colors
define("_CO_ICMSPOLL_OPTIONS_COLORS_AQUA", "Aqua");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BLANK", "Blank");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BLUE", "Blue");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BROWN", "Brown");
define("_CO_ICMSPOLL_OPTIONS_COLORS_DARKGREEN", "Dark green");
define("_CO_ICMSPOLL_OPTIONS_COLORS_GOLD", "Gold");
define("_CO_ICMSPOLL_OPTIONS_COLORS_GREEN", "Green");
define("_CO_ICMSPOLL_OPTIONS_COLORS_GREY", "Grey");
define("_CO_ICMSPOLL_OPTIONS_COLORS_ORANGE", "Orange");
define("_CO_ICMSPOLL_OPTIONS_COLORS_PINK", "Pink");
define("_CO_ICMSPOLL_OPTIONS_COLORS_PURPLE", "Purple");
define("_CO_ICMSPOLL_OPTIONS_COLORS_RED", "Red");
define("_CO_ICMSPOLL_OPTIONS_COLORS_YELLOW", "Yellow");
define("_CO_ICMSPOLL_OPTIONS_COLORS_TRANSPARENT", "Transparent");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BLACK", "Black");
/**
 * constants for log objects
 */
define("_CO_ICMSPOLL_LOG_POLL_ID", "Enquetes votadas");
define("_CO_ICMSPOLL_LOG_POLL_ID_DSC", "");
define("_CO_ICMSPOLL_LOG_OPTION_ID", "Opções votadas");
define("_CO_ICMSPOLL_LOG_OPTION_ID_DSC", "");
define("_CO_ICMSPOLL_LOG_IP", "IP");
define("_CO_ICMSPOLL_LOG_USER_ID", "Usuario");
define("_CO_ICMSPOLL_LOG_TIME", "Horario voto");
define("_CO_ICMSPOLL_LOG_SESSION_ID", "Impressão digital sessão");
/**
 * constants for indexpage objects
 */
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMAGE", "Selecione uma Imagem");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMAGE_DSC", "Selecione uma imagem da lista ou faça upload de uma nova.");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMG_UPLOAD", "Upload de imagem");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMG_UPLOAD_DSC", "");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADER", "Indice Cabeçalho");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADER_DSC", "");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADING", "Indice Titulo");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADING_DSC", "");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_FOOTER", "Indice Rodapé");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_FOOTER_DSC", "");

define("_CO_ICMSPOLL_POLL_HAS_EXPIRED", "Your Poll has Expired");
define("_CO_ICMSPOLL_OPTION_TOTALVOTES", "votes");
define("_CO_ICMSPOLL_ADMIN_SHOW_DETAILS", "Show more informations");
define("_CO_ICMSPOLL_PRESENT_BY_USERPROFILE", "This Poll was created by");
define("_CO_ICMSPOLL_POLLS_VISIT_USERPROFILE", "Visit the profile");
