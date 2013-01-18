<?php
/**
 * "Downloads" is a light weight download handling module for ImpressCMS
 *
 * File: /language/english/main.php
 *
 * English language constants used in the user side of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: main.php 619 2012-06-28 08:34:35Z st.flohrer $
 * @package		downloads
 * 
 */

// general used constants
define("_MD_DOWNLOADS_PUBLISHED_BY", "発行");
define("_MD_DOWNLOADS_PUBLISHED_ON", "上で公開");
define("_MD_DOWNLOADS_UPDATED_ON", "更新");
define("_MD_DOWNLOADS_SECURITY_CHECK_FAILED", "Security check failed.");
define("_MD_DOWNLOADS_ADMIN_PAGE", ":: Admin page ::");
define("_MD_DOWNLOADS_SUBMIT", "Submit");
// constants on index view
define("_MD_DOWNLOADS_DOWNLOAD_FILELIST", "このカテゴリのファイル");
define("_MD_DOWNLOADS_CATEGORY_SUBCATLIST", "サブカテゴリ");
define("_MD_DOWNLOADS_FILES", "ファイル");
define("_MD_DOWNLOADS_SUBCATS", "サブカテゴリ");
define("_MD_DOWNLOADS_SUBMIT_CAT", "Submit a new category");
define("_MD_DOWNLOADS_UPLOAD", "Upload a new File");
define("_MD_DOWNLOADS_NOFILES", "Sorry, currently there are no files in this category.");
define("_MD_DOWNLOADS_READ_MORE", "情報＆ダウンロード");
define("_MD_DOWNLOADS_NO_CATEGORY_DSC", "Sorry, no category Description available yet.");
define("_MD_DOWNLOADS_NO_TEASER_TEXT", "Sorry, no short summary available");

// constants on single file view
define("_MD_DOWNLOADS_DOWNLOAD", "ダウンロード");
define("_MD_DOWNLOADS_GOTO_ITEM", "Go to buy");
define("_MD_DOWNLOADS_DOWNLOAD_USE_MIRROR", "Or use our download mirror:");
define("_MD_DOWNLOADS_FILE_KEYFEATURES", "主な特徴:");
define("_MD_DOWNLOADS_FILE_REQUIREMENTS", "必要条件:");
define("_MD_DOWNLOADS_FILE_RELATED", "関連ファイル:");
define("_MD_DOWNLOADS_FILE_DEV", "開発者:");
define("_MD_DOWNLOADS_FILE_DEV_HP", "開発者のホームページ:");
define("_MD_DOWNLOADS_FILE_VERSION", "バージョン:");
define("_MD_DOWNLOADS_FILE_VERSION_STATUS", "バージョンステータス:");
define("_MD_DOWNLOADS_FILE_PLATFORM", "プラットフォーム:");
define("_MD_DOWNLOADS_FILE_LICENSE", "ライセンス:");
define("_MD_DOWNLOADS_FILE_LIMITS", "制限事項:");
define("_MD_DOWNLOADS_FILE_LANGUAGE", "言語:");
define("_MD_DOWNLOADS_SURE_BROKEN", "あなたは確信して、ダウンロードリンクが壊れているのですか？");
define("_MD_DOWNLOADS_REPORT_BROKEN", "リンク切れ報告");
define("_MD_DOWNLOADS_FILE_UPDATED", "更新した");
define("_MD_DOWNLOADS_FILE_NEW", "新しい");
define("_MD_DOWNLOADS_DOWNLOAD_INPROGRESS", "進行中のダウンロード...");
define("_MD_DOWNLOADS_DOWNLOAD_START_IN", "あなたのダウンロードは3秒で起動します...<b>しばらくお待ちください</b>.");
define("_MD_DOWNLOADS_DOWNLOAD_START_NOT", "あなたのダウンロードが開始しない場合は、");
define("_MD_DOWNLOADS_CLICK_HERE", "ここをクリックしてください");
define("_MD_DOWNLOADS_MAILTO", "アドヴァイザ");
define("_MD_DOWNLOADS_MAILTO_SBJ", "I%20found%20a%20nice%20File%20to%20download");
define("_MD_DOWNLOADS_MAILTO_BDY", "I%20found%20a%20nice%20File%20to%20download"); // @DAVID Please have a look for Mail body
define("_MD_DOWNLOADS_REVIEW", "レビュー送信");
define("_MD_DOWNLOADS_REVIEW_PERM", "あなたがレビューを提出する権限がありません。ログインまたはレビューを投稿するには登録してください。");
define("_MD_DOWNLOADS_REV_PERM", "申し訳ありませんが、アクセス許可がない");
define("_MD_DOWNLOADS_VOTE_PERM", "あなたがファイルを投票する権限がありません。ログインまたは、このファイルを投票には登録を行ってください。");
define("_MD_DOWNLOADS_FILE_DOWNLOADED", "ファイルダウンロード");
define("_MD_DOWNLOADS_TAG_ADD", "Submit a new tag");
define("_MD_DOWNLOADS_TAGS_PERM", "本当に全てのタグを提出する権限がありません。ログインまたは新規タグの提出には登録を行ってください。");
define("_MD_DOWNLOADS_TAG_PERM", "申し訳ありませんが、アクセス許可がない");
define("_MD_DOWNLOADS_DOWNLOAD_DEMO", "DEMO");

// tabs
define("_MD_DOWNLOADS_FILE_GENERAL_INFORMATIONS", "一般的な情報");
define("_MD_DOWNLOADS_FILE_DESCRIPTION", "説明");
define("_MD_DOWNLOADS_FILE_IMAGES", "スクリーンショット");
define("_MD_DOWNLOADS_FILE_INSTRUCTIONS", "関連した");
define("_MD_DOWNLOADS_FILE_HISTORY", "歴史");
define("_MD_DOWNLOADS_FILE_REVIEWS", "レビュー");
define("_MD_DOWNLOADS_COMMENT", "コメント");
define("_MD_DOWNLOADS_COMMENTS", "注釈");

define("_MD_DOWNLOADS_PUBLISHER_MAIL", "メール");
define("_MD_DOWNLOADS_CATS", "カテゴリー");
define("_MD_DOWNLOADS_TAGS", "タグ");
define("_MD_DOWNLOADS_FILESIZE", "ファイルサイズ");
define("_MD_DOWNLOADS_FILETYPE", "ファイルの種類");

// used in ajax.php
define("_MD_DOWNLOADS_BROKEN_REPORTED", "提出していただきありがとうございます！ファイルが壊れているように報告された。");
define("_MD_DOWNLOADS_DOWNLOAD_START", "しばらくお待ちください、そしてまもなくダウンロードが開始されます。");
define("_MD_DOWNLOADS_THANKS_VOTING", "投票していただきありがとうございました");
define("_MD_DOWNLOADS_ALLREADY_VOTED", "あなたはすでに投票しています！");
define('_THANKS_SUBMISSION_TAG', '新しいタグを提出していただきありがとうございます！');
//for new file form
define("_MD_DOWNLOADS_DOWNLOAD_EDIT", "Edit the File");
define("_MD_DOWNLOADS_DOWNLOAD_CREATE", "Upload a new file");
define("_MD_DOWNLOADS_DOWNLOAD_CREATED", "File successfully uploaded. Thanks for submit.");
define("_MD_DOWNLOADS_DOWNLOAD_MODIFIED", "File successfully modified. Thanks for submit");
//for new cat form
define("_MD_DOWNLOADS_CATEGORY_CREATE", "Create a new Category");
define("_MD_DOWNLOADS_CATEGORY_EDIT", "Edit the Category");
define("_MD_DOWNLOADS_CATEGORY_CREATED", "Category successfully created. Thanks for submit.");
define("_MD_DOWNLOADS_CATEGORY_MODIFIED", "Category successfully modified. Thanks for submit");
// for review form
define("_MD_DOWNLOADS_REVIEW_ADD", "レビュー送信");
define('_MD_DOWNLOADS_REVIEW_SUBMITTED', 'Review submitted');
define('_THANKS_SUBMISSION_REV', 'Thank you for submitting your review!');

