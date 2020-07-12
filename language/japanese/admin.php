<?php
// $Id: admin.php,v 1.11 2007/12/02 02:48:04 ohwada Exp $

// 2007-12-01 K.OHWADA
// view
// _WHATSNEW_BLOCK_MODULE => _AM_WHATSNEW_CONF_BLOCK_MODULE_ORDER

// 2007-10-10 K.OHWADA
// banner cache_time

// 2007-05-12 K.OHWADA
// module dupulication
// _WHATSNEW_NOTICE_IMAGE_SIZE
// remove _WHATSNEW_INIT_NOT etc

// 2006-06-25
// _WHATSNEW_PLUGIN and more

// 2006-06-20
// _WHATSNEW_CONFIG_RSS and more

// 2005-10-01
// _WHATSNEW_CONFIG_BLOCK and more

// 2005-06-20
// _WHATSNEW_NEW_IMAGE_WIDTH

// 2005-06-14
// _WHATSNEW_MENU_RDF

// 2005-06-06
// _WHATSNEW_SYSTEM_COMMENT

//=========================================================
// What's New Module
// Language pack for Japanese
// 2004/08/20 K.OHWADA
// 有朋自遠方来
//=========================================================

// --- define language begin ---
if( !defined('WHATSNEW_LANG_AM_LOADED') ) 
{

define('WHATSNEW_LANG_AM_LOADED', 1);

// use $xoopsModule
//define('_WHATSNEW_NAME','新着情報 (What's New)');

// use blocks.php
//define('_WHATSNEW_ADMIN_DESC','複数のモジュールから最新の記事を集めて、新着記事ブロックとRSSとATOMを作成します');
//define('_WHATSNEW_MENU_CONFIG','一般設定');
//define('_WHATSNEW_MENU_PING','Ping 送信');
//define('_WHATSNEW_MENU_RSS','RSS のリフレッシュ');
//define('_WHATSNEW_MENU_ATOM','ATOM のリフレッシュ');
//define('_WHATSNEW_MENU_RDF','RDF のリフレッシュ');
//define('_WHATSNEW_GOTO_WHATNEW','モジュール へ');

// config
define('_WHATSNEW_MID','ID');
define('_WHATSNEW_MNAME','モジュール名');
define('_WHATSNEW_MDIR','デイレクトリ名');
define('_WHATSNEW_NEW','新着記事ブロック');
define('_WHATSNEW_RSS','RSS / ATOM');
define('_WHATSNEW_ITEM','項目');
define('_WHATSNEW_LIMIT_SHOW','全体で表示する最大の記事数');
define('_WHATSNEW_LIMIT_SUMMARY','要約表示する記事数');
define('_WHATSNEW_MAX_SUMMARY','要約の文字数');
define('_WHATSNEW_NEW_IMAGE','画像を表示する');
define('_WHATSNEW_NEW_PING','Pingを送信する');

//define('_WHATSNEW_SITE_NAME','サイト名');
//define('_WHATSNEW_SITE_NAME_DESC','RSS/ATOMの必須項目です');
//define('_WHATSNEW_SITE_URL','サイトURL');
//define('_WHATSNEW_SITE_URL_DESC','RSS/ATOMの必須項目です');
//define('_WHATSNEW_SITE_DESC','サイトの説明');
//define('_WHATSNEW_SITE_DESC_DESC','RSSの必須項目です');
//define('_WHATSNEW_SITE_AUTHOR','サイト管理者');
//define('_WHATSNEW_SITE_AUTHOR_DESC','ATOMの必須項目です');
//define('_WHATSNEW_SITE_EMAIL','サイト管理者のＥメール');
//define('_WHATSNEW_SITE_EMAIL_DESC','RSS/ATOMの任意項目です');
//define('_WHATSNEW_SITE_LOGO','サイトのロゴ画像');
//define('_WHATSNEW_SITE_LOGO_DESC','RSSの任意項目です');

define('_WHATSNEW_PING_SERVERS','Pingサーバーの一覧');
define('_WHATSNEW_PING_PASS','update_ping.php のパスワード');
define('_WHATSNEW_PING_LOG','Ping送信のログ');

//define('_WHATSNEW_SAVE','保存');
//define('_WHATSNEW_DELETE','削除');
//define('_WHATSNEW_CONFIG_SAVED','設定テーブルを保存した');
//define('_WHATSNEW_WARNING_NOT_WRITABLE','cacheデイレクトリの書込み許可がない');

// not use config file
//define('_WHATSNEW_CONFIG_DELETED','設定ファイルを削除した');
//define('_WHATSNEW_WARNING_NOT_EXIST','設定ファイルが存在していない');
//define('_WHATSNEW_ERROR_CONFIG','設定が正しくない');
//define('_WHATSNEW_ERROR_SITE_NAME','サイト名が指定されていない');
//define('_WHATSNEW_ERROR_SITE_URL','サイトURLが指定されていない');
//define('_WHATSNEW_ERROR_SITE_DESC','サイトの説明が指定されていない');
//define('_WHATSNEW_ERROR_SITE_AUTHOR','サイト管理者が指定されていない');
//define('_WHATSNEW_ERROR_NEW_MAX_SUMMARY','新着記事ブロックの要約の文字数が正しくない');
//define('_WHATSNEW_ERROR_RSS_MAX_SUMMARY','RSS/ATOMの要約の文字数が正しくない');

// ping
define('_WHATSNEW_PING_DETAIL','詳細情報を表示する');
define('_WHATSNEW_PING','Ping送信');
define('_WHATSNEW_PING_SENDED','Pingを送信した');

// 2005-06-06
define('_WHATSNEW_SYSTEM_COMMENT','コメント');

// 2005-06-20
define('_WHATSNEW_NEW_IMAGE_WIDTH','画像サイズの横の最大値');
define('_WHATSNEW_NEW_IMAGE_HEIGHT','画像サイズの縦の最大値');
define('_WHATSNEW_NEW_IMAGE_SIZE_NOT_SAVE','画像サイズの最大値が保存されていない');

//define('_WHATSNEW_VIEW_RSS','RSSのデバック表示');
//define('_WHATSNEW_VIEW_RDF','RDFのデバック表示');
//define('_WHATSNEW_VIEW_ATOM','ATOMのデバック表示');
//define('_WHATSNEW_MENU_PDA','PDA の表示');

// 2005-10-01
//define('_WHATSNEW_SYSTEM_GROUPS','グループ管理');
//define('_WHATSNEW_SYSTEM_BLOCKS','ブロック管理');
define('_WHATSNEW_VIEW_DOCS','マニュアル');
define('_WHATSNEW_CONFIG_BLOCK','新着記事ブロックとRSS/ATOMの設定');
define('_WHATSNEW_CONFIG_MAIN','メインページの設定');
define('_WHATSNEW_CONFIG_SITE','サイト情報の設定');
define('_WHATSNEW_CONFIG_PING','Pingの設定');
define('_WHATSNEW_GOTO_MENU_PING','Ping送信 に戻る');

// index
//define('_WHATSNEW_INIT_NOT','設定テーブルが初期化されていない');
//define('_WHATSNEW_INIT_EXEC','設定テーブルを初期化する');
//define('_WHATSNEW_VERSION_NOT','バージョン %s ではない');
//define('_WHATSNEW_UPGRADE_EXEC','設定テーブルをアップグレードする');

define('_WHATSNEW_NOTICE','注意');
define('_WHATSNEW_NOTICE_PERM','この WhatsNew モジュールはゲストに公開されていません。<br />RSSやATOMが表示できません。');
define('_WHATSNEW_NOTICE_BOTH','プラグインがモジュール側と WhatsNew の両方に存在します。<br />プラグインは、モジュール側を優先して使用します。<br />該当するものは、ディレクトリィ名を <span style="color:#ff0000;">赤字</span> で表示します。<br />どちらか古いほうを削除してください。<br />');

//define('_WHATSNEW_NOTE_RSS_MARK','RSS/ATOM欄の <b>#</b> マークは、ゲストにアクセス権限があることを示します。<br />RSS/ATOMはゲスト権限でアクセスしたときにのみ表示されます。<br />');

define('_WHATSNEW_ICON_LIST','アイコン一覧');

// config item
define('_WHATSNEW_WEIGHT','並び順');
define('_WHATSNEW_MIN_SHOW','モジュール毎に表示する最小の記事数');
define('_WHATSNEW_BLOCK_ICON','アイコンのデフォルト');

// conflit to blocks.php
//define('_WHATSNEW_BLOCK_MODULE','モジュールの表示順');

define('_WHATSNEW_BLOCK_MODULE_0','新着順');
define('_WHATSNEW_BLOCK_MODULE_1','並び順');
define('_WHATSNEW_BLOCK_SUMMARY_HTML','要約にHTMLタグを許可する');
define('_WHATSNEW_BLOCK_MAX_TITLE','タイトルの文字数');

//define('_WHATSNEW_SITE_TAG','サイト タグ');
//define('_WHATSNEW_SITE_IMAGE_URL','サイト画像のURL');
//define('_WHATSNEW_SITE_IMAGE_WIDTH','サイト画像の横幅');
//define('_WHATSNEW_SITE_IMAGE_HEIGHT','サイト画像の高さ');

define('_WHATSNEW_MAIN_TPL','メインのテンプレート');
define('_WHATSNEW_MAIN_TPL_0','WhatsNew 風');
define('_WHATSNEW_MAIN_TPL_1','BopCommnets 風');

// --- 2006-06-18 ---
define('_WHATSNEW_CONFIG_RSS', 'RDF/RSS/ATOM 生成の設定');

//define('_WHATSNEW_RSS_PERMIT_USER', '登録ユーザにRSSを表示する');
//define('_WHATSNEW_RSS_PERMIT_USER_DESC', 'ゲストには常にRSSを表示する');

// --- 2006-06-25 ---
define('_WHATSNEW_PLUGIN', 'プラグイン');
define('_WHATSNEW_MOD_VERSION', 'バージョン');
define('_WHATSNEW_NOTICE_PLURAL','１つのモジュールに複数のプラグインが存在します。<br />適切なプラグインを選択してください。<br />');

// --- 2007-05-12 ---
define('_WHATSNEW_NOTICE_IMAGE_SIZE', '画像サイズを規格に従いチェックしたところ、XOOPS logo.gif では警告が表示される。<br />このくらいは許容されるだろう');

// --- 2007-10-10 ---
// banner
define('_WHATSNEW_BANNER_FLAG','バナー画像を表示する');
define('_WHATSNEW_BANNER_WIDTH','バナー画像の横の最大値');
define('_WHATSNEW_BANNER_HEIGHT','バナー画像の縦の最大値');

// --- 2007-11-24 ---
// view
define('_AM_WHATSNEW_CONFIG_VIEW','表示の設定');
define('_AM_WHATSNEW_CONF_NEWDAY_DAYS','「NEW」を表示する日数');
define('_AM_WHATSNEW_CONF_NEWDAY_STRINGS','「NEW」の文字');
define('_AM_WHATSNEW_CONF_NEWDAY_STYLE','「NEW」のスタイル');
define('_AM_WHATSNEW_CONF_TODAY_HOURS','「TODAY」を表示する時間 (Hours)');
define('_AM_WHATSNEW_CONF_TODAY_STRINGS','「TODAY」の文字');
define('_AM_WHATSNEW_CONF_TODAY_STYLE','「TODAY」のスタイル');

// main block
define('_AM_WHATSNEW_CONFIG_MAIN_BLOCK','メイン/ブロック/RSSの設定');
define('_AM_WHATSNEW_MAIN','メインページ');
define('_AM_WHATSNEW_CONF_NEWDAY','「NEW」を表示する');
define('_AM_WHATSNEW_CONF_TODAY','「TODAY」を表示する');
define('_AM_WHATSNEW_CONF_TODAY_DSC', '「いいえ」を指定すると、「NEW」の設定が有効となる');
define('_AM_WHATSNEW_CONF_DATE_STRINGS','日付の書式');
define('_AM_WHATSNEW_CONF_DATE_STRINGS_DSC','参照 <a href="http://www.php.net/manual/ja/function.date.php" target="_blank">PHP date 関数</a>');

// permission
define('_AM_WHATSNEW_CONFIG_PERM','モジュールのアクセス権限の設定');
define('_AM_WHATSNEW_CONFIG_PERM_DSC','アクセス権限のないモジュールについて、表示する項目を設定する');
define('_AM_WHATSNEW_CONF_PERM_MODULE','アクセス権限のないモジュールの表示');
define('_AM_WHATSNEW_CONF_PERM_MODULE_DSC','「表示する」のときに、以降の設定が有効になる');
define('_AM_WHATSNEW_CONF_PERM_NOT_SHOW','表示しない');
define('_AM_WHATSNEW_CONF_PERM_SHOW','表示する');
define('_AM_WHATSNEW_CONF_PERM_DIRNAME','ディレクトリ名');
define('_AM_WHATSNEW_CONF_PERM_MOD_NAME','モジュール名');
define('_AM_WHATSNEW_CONF_PERM_MOD_LINK','モジュールのリンク');
define('_AM_WHATSNEW_CONF_PERM_MOD_ICON','モジュールのアイコン');
define('_AM_WHATSNEW_CONF_PERM_CAT_NAME','カテゴリ名');
define('_AM_WHATSNEW_CONF_PERM_CAT_LINK','カテゴリのリンク');
define('_AM_WHATSNEW_CONF_PERM_TITLE','記事の題名');
define('_AM_WHATSNEW_CONF_PERM_LINK','記事のリンク');
define('_AM_WHATSNEW_CONF_PERM_SUMMARY','要約');
define('_AM_WHATSNEW_CONF_PERM_IMAGE','画像');
define('_AM_WHATSNEW_CONF_PERM_BANNER','バナー');

define('_AM_WHATSNEW_PERM','許可');
define('_AM_WHATSNEW_PERM_DSC','#1 ゲストにアクセス権限のないモジュールの表示を許可する');
define('_AM_WHATSNEW_CONF_BLOCK_MODULE_ORDER','モジュール順ブロックの表示順');

}
// --- define language end ---

?>