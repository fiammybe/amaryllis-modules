<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /language/portuguesebr/modinfo.php
 * 
 * portuguesebr modinfo language file
 * Tradutor: Everton Lopes 05-07-2012
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: modinfo.php 646 2012-06-30 19:47:27Z st.flohrer $
 * @package		icmspoll
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

define("_MI_ICMSPOLL_MD_NAME", "Enquetes");
define("_MI_ICMSPOLL_MD_DSC", "'Icmspoll' é um módulo para ImpressCMS e iforum. Isto significa, que pode funcionar como um módulo de enquete independente ou pode ser integrado em iForum para realizar enquetes em fóruns.");
/**
 * module preferences
 */
define("_MI_ICMSPOLL_AUTHORIZED_CREATOR", "Selecione os grupos que podem adicionar");
define("_MI_ICMSPOLL_AUTHORIZED_CREATOR_DSC", "");
define("_MI_ICMSPOLL_CONFIG_DATE_FORMAT", "Formatar Data");
define("_MI_ICMSPOLL_CONFIG_DATE_FORMAT_DSC", "permite alterar o formato de exibição da data");
define("_MI_ICMSPOLL_CONFIG_LIMITBYIP", "Restringir por IP");
define("_MI_ICMSPOLL_CONFIG_LIMITBYIP_DSC", "Permite apenas um voto de um mesmo endereço IP");
define("_MI_ICMSPOLL_CONFIG_LIMITBYSESSION", "Restringir por Sessão");
define("_MI_ICMSPOLL_CONFIG_LIMITBYSESSION_DSC", "Permite apenas um voto por sessão");
define("_MI_ICMSPOLL_CONFIG_LIMITBYUID", "Restringir por usuário");
define("_MI_ICMSPOLL_CONFIG_LIMITBYUID_DSC", "Permite apenas um voto por usuário cadastrado");
define("_MI_ICMSPOLL_CONFIG_SHOW_BREADCRUMBS", "Exibir breadcrumb?");
define("_MI_ICMSPOLL_CONFIG_SHOW_BREADCRUMBS_DSC", "Selecione 'SIM' para exibir breadcrumb no cabeçalho da página");
define("_MI_ICMSPOLL_CONFIG_SHOW_POLLS", "Limite de enquetes a ser exibidas no index");
define("_MI_ICMSPOLL_CONFIG_SHOW_POLLS_DSC", "Define o limite de enquetes a ser exibida no indice antes da página ser reinderizada");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER", "Ordem Padrão");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_DSC", "Ordenar pesquisas como padrão por:");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_WEIGHT", "Peso");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_CREATIONDATE", "Data de criação");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_STARTDATE", "Data Inicio");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_ENDDATE", "Data Fim");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT", "Ordem Padrão");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT_DSC", "Classificação de enquete no index como padrão por:");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT_ASC", "ASC");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT_DESC", "DESC");
define("_MI_ICMSPOLL_CONFIG_ALLOW_INIT_VALUE", "Permitir Valor Inicial?");
define("_MI_ICMSPOLL_CONFIG_ALLOW_INIT_VALUE_DSC", "Defina 'SIM' se você gostaria de inserir valor inicial nas opções.");
define("_MI_ICMSPOLL_CONFIG_PRINT_FOOTER", "Imprimir Rodapé");
define("_MI_ICMSPOLL_CONFIG_PRINT_FOOTER_DSC", "O radapé será utilizado no layout de impressão");
define("_MI_ICMSPOLL_CONFIG_PRINT_LOGO", "Imprimir Logo");
define("_MI_ICMSPOLL_CONFIG_PRINT_LOGO_DSC", "Digite o caminho para logotipo para a ser impresso. Ex.: themes/example/images/logo.gif");
define("_MI_ICMSPOLL_CONFIG_USE_RSS", "Use RSS-Feeds?");
define("_MI_ICMSPOLL_CONFIG_USE_RSS_DSC", "Defina 'SIM' para fornecer um link rss.");
define("_MI_ICMSPOLL_CONFIG_RSS_LIMIT", "RSS Limite");
define("_MI_ICMSPOLL_CONFIG_RSS_LIMIT_DSC", "Limite de enquetes para o link RSS");
/**
 * module Templates
 */
define("_MI_ICMSPOLL_TPL_INDEX", "Icmspoll indexview");
define("_MI_ICMSPOLL_TPL_HEADER", "Arquivo de cabeçalho incluido no frontend");
define("_MI_ICMSPOLL_TPL_FOOTER", "Arquivo de rodapé incluido no Frontend");
define("_MI_ICMSPOLL_TPL_POLLS", "Ciclo de exibição no indice");
define("_MI_ICMSPOLL_TPL_SINGLEPOLL", "Exibir uma unica enquete");
define("_MI_ICMSPOLL_TPL_RESULTS", "Exibir resultado da enquete");
define("_MI_ICMSPOLL_TPL_PRINT", "Template de Impressão");
define("_MI_ICMSPOLL_TPL_FORMS", "Formulario para criar/deletar enquetes no frontend");
define("_MI_ICMSPOLL_TPL_ADMIN_FORM", "ACP Templates");
define("_MI_ICMSPOLL_TPL_REQUIREMENTS", "Checar Requirimentos");
/**
 * module blocks
 */
define("_MI_ICMSPOLL_BLOCK_RECENT_POLLS", "Enquetes Recentes");
define("_MI_ICMSPOLL_BLOCK_RECENT_POLLS_DSC", "Exibi uma lista de enquetes recentes");
define("_MI_ICMSPOLL_BLOCK_SINGLE_POLL", "Enquete Unica");
define("_MI_ICMSPOLL_BLOCK_SINGLE_POLL_DSC", "Exibe uma única enquete");
define("_MI_ICMSPOLL_BLOCK_RECENT_RESULTS", "Rsultados Recentes ");
define("_MI_ICMSPOLL_BLOCK_RECENT_RESULTS_DSC", "Exibe resultados recentes ");
define("_MI_ICMSPOLL_BLOCK_SINGLE_RESULT", "Resultado Único");
define("_MI_ICMSPOLL_BLOCK_SINGLE_RESULT_DSC", "Exibe o resultado de uma única enquete");
/**
 * module ACP menu
 */
define("_MI_ICMSPOLL_MENU_INDEX", "Index");
define("_MI_ICMSPOLL_MENU_POLLS", "Enquetes");
define("_MI_ICMSPOLL_MENU_OPTIONS", "Opções");
define("_MI_ICMSPOLL_MENU_LOG", "Log");
define("_MI_ICMSPOLL_MENU_INDEXPAGE", "Indexpage");
define("_MI_ICMSPOLL_MENU_TEMPLATES", "Templates");
define("_MI_ICMSPOLL_MENU_MANUAL", "Manual");
// submenu
define("_MI_ICMSPOLL_MENU_POLLS_EDITING", "Editar Enquete");
define("_MI_ICMSPOLL_MENU_POLLS_CREATINGNEW", "Nova Enquete");
define("_MI_ICMSPOLL_MENU_OPTIONS_EDITING", "Editar Opção");
define("_MI_ICMSPOLL_MENU_OPTIONS_CREATINGNEW", "Criar nova opção");
define("_MI_ICMSPOLL_MENU_INDEXPAGE_EDIT", "Editar Indexpage");
/**
 * Mainmenu
 */
define("_MI_ICMSPOLL_MENUMAIN_ADDPOLL", "Adicionar");
define("_MI_ICMSPOLL_MENUMAIN_VIEW_POLLS_TABLE", "Visualizar Tabela Enquetes");
define("_MI_ICMSPOLL_MENUMAIN_VIEW_OPTIONS_TABLE", "Visualizar Tabela Opções");
define("_MI_ICMSPOLL_MENUMAIN_VIEWRESULTS", "Visualizar Resultados");
/**
 * Notifications
 */
define("_MI_ICMSPOLL_GLOBAL_NOTIFY", "Todas Enquetes");
define("_MI_ICMSPOLL_GLOBAL_NOTIFY_DSC", "Notificações relativas a todas as votações no módulo");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY", "Nova enquete publicada");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_CAP", "Me notificar quando uma nova enquete for publicada");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_DSC", "Receber notificação quando qualquer nova enquete for publicada.");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} notificação automatica : Nova enquete publicada");
