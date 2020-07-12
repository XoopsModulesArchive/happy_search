$Id: readme_jp.txt,v 1.14 2008/07/09 07:51:54 ohwada Exp $

=================================================
Version: 0.60
Date:   2008-07-01
Author: Kenichi OHWADA
URL:    http://linux.ohwada.jp/
Email:  webmaster@ohwada.jp
=================================================

サイト内とGoogleを検索するモジュールです。
suinさんの searchモジュールと xoogleモジュールを 統合したものです。

● 変更内容
1. アルバム・モジュールは、サムネイル画像を表示する
対応モジュール
- myalbum (happy_search プラグイン 要)
- webphoto 

2. プラグインの追加
(1) myalbum 2.88


=================================================
Version: 0.53
Date:   2008-02-16
=================================================

サイト内とGoogleを検索するモジュールです。
suinさんの searchモジュールと xoogleモジュールを 統合したものです。

● 変更内容
1. インストール処理を変更した
http://linux.ohwada.jp/modules/newbb/viewtopic.php?topic_id=767&forum=8

2. テンプレート変数 xoops_module_header を使用した
http://linux.ohwada.jp/modules/newbb/viewtopic.php?topic_id=776&forum=5


=================================================
Version: 0.52
Date:   2008-01-18
=================================================

サイト内とGoogleを検索するモジュールです。
suinさんの searchモジュールと xoogleモジュールを 統合したものです。

● 変更内容
1. バグ対策
(1) Only variables should be assigned by reference


=================================================
Version: 0.51
Date:   2007-12-29
=================================================

サイト内とGoogleを検索するモジュールです。
suinさんの searchモジュールと xoogleモジュールを 統合したものです。

● 変更内容
1. バグ対策
(1) モジュール名が表示されない
http://linux2.ohwada.net/modules/newbb/viewtopic.php?topic_id=372&forum=7


=================================================
Version: 0.50
Date:   2007-11-24
=================================================

サイト内とGoogleを検索するモジュールです。
suinさんの searchモジュールと xoogleモジュールを 統合したものです。

● 変更内容
1. onInstall onUpdate に対応した

2. モジュール毎の実行時間とメモリ使用量を表示した

3. DBテーブル管理を追加した
config テーブルの検査

4. モジュール管理を追加した

5. PHP 5 対応
(1) PHP 5 の SoapClient クラスとの衝突を回避した
http://linux.ohwada.jp/modules/newbb/viewtopic.php?forum=10&topic_id=668
http://linux2.ohwada.net/modules/newbb/viewtopic.php?forum=7&topic_id=357

6. プラグイン
(1) wordpress 追加
BBコードを変換した
(2) smartsection 変更
v2.13 対応

7. バグ対策
(1) Only variables should be assigned by reference
http://linux2.ohwada.net/modules/newbb/viewtopic.php?forum=7&topic_id=348


=================================================
Version: 0.40
Date:   2007-07-01
=================================================

サイト内とGoogleを検索するモジュールです。
suinさんの searchモジュールと xoogleモジュールを 統合したものです。

● 変更内容
1. Google Ajax 検索に対応した
利用する場合は 下記よりAPI Key を取得してください
http://code.google.com/apis/ajaxsearch/signup.html

2. モジュール複製に対応した
weblinks モジュールなどと同様の方式です

3. 管理者画面のブロック管理など
XOOPS のメジャー・バージョンによる違いの吸収
XOOPS 2.0 / 2.1 / 2.2 に対応したメニューを表示する
バージョン判定を自動的に行い、10秒後の自動的にページを移動する

4. 下記の変数を管理者画面から設定可能にした
(1) メインページの設定
(2) ブロックの設定

5. プラグインの選択
１つのモジュールに複数のプラグインがあるとき、選択できるようにした

6. プラグインの追加
(1) blusbb 1.04
(2) wfdownloads 3.10
(3) newbb 3.08

7. バグ対策
(1) Undefined variable: XOOPS_LANGUAGE in block_search.php

8. 多言語
(1) 日本語 UTF-8 ファイルを追加した


● テーブル構造
(1) module テーブルを一新した
 first_notshow, second_show, plugin_file, plugin_func フィールドを追加した

● テンプレート
下記のテンプレートを追加した
- search_form
- google_soap
- google_ajax

● 要求事項
happy_linux v0.90 が必要です


=================================================
Version: 0.30
Date:   2007-05-20
=================================================

サイト内とGoogleを検索するモジュールです。
suinさんの searchモジュールと xoogleモジュールを 統合したものです。

● 変更内容
1. XoopsCube 2.1 に対応した
XC 2.1 では、system モジュールをインストールしなくとも、動作します

2. myblocksadmin を happy_linux へ移設した

3. バグ対応
(1) テーブル名が間違っていた

4. 要求事項
happy_linux v0.80 が必要です


=================================================
Version: 0.20
Date:   2007-02-18
=================================================

サイト内とGoogleを検索するモジュールです。
suinさんの searchモジュールと xoogleモジュールを 統合したものです。

● 変更内容
(1) コメントを検索対象にした

(2) バグ対応
(2-1) Fatal error: Call to undefined method happy_search_google::googleLangRestrictions()
(2-2) Notice [PHP]: Use of undefined constant _HAPPY_SEARCH_KEY_ERROR
(2-3) Warning: array_merge()
(2-4) Warning: usort()


=================================================
Version: 0.10
Date:   2006-12-01
=================================================

サイト内とGoogleを検索するモジュールです。
suinさんの searchモジュールと xoogleモジュールを 統合したものです。

これはアルファ版です。
今後、大幅に仕様や実装が変わる可能性があります。
何か問題が出ても、自分でなんとか出来る人のみお使いください。
バグ報告やバグ解決などは歓迎します。

● 拡張した機能
1. searchモジュール
(1) ゆらぎ検索 を強化した（日本語環境のみ）
searchモジュールでは、いづれか１つに該当すると、それのみを対象としていた。
本モジュールでは、下記の全てのケースを対象とした。
- 半角英数のとき 全角英数も検索対象にする
- 全角英数のとき 半角英数も検索対象にする
- 半角カタカナのとき 全角カタカナと全角ひらがなも検索対象にする
- 全角カタカナのとき 半角カタカナと全角ひらがなも検索対象にする
- 全角ひらがなのとき 半角カタカナと全角ひらがなも検索対象にする

(2) newbb 2.01 と SmartSection 2.10 のプラグインを追加した
(3) newbb と news のプラグインにおいて、ショートタグを使っていたので、修正した。
(4) 英語版に対応した

2. xoogleモジュール
(1) googleからの検索結果を盲目的に信頼せずサニタイズした
(2) 管理者画面を日本語化した

3. 全般
(1) キーワードをハイライト表示した
(2) 設定情報の保存時に XoopsGTicket を導入した

● 引き継いでいない機能
(1) モジュール名(ディレクトリ名)を変更可能にする
=> 対応する予定です

● 引き継いだ機能
1. searchモジュール
標準の検索機能を拡張している
(1) テンプレートで出力するので検索結果のレイアウトができる。
(2) テンプレートで出力するのでryus_dateなどのプラグインを自由に使える。
(3) 検索できるモジュールが無い場合、検索できるモジュールがないことを示すように変更。
(4) extract()による展開を止めて変数汚染を予防。
(5) コアの一部から切り離したことで改造することに抵抗がなくなった。
(6) 「検索対象のモジュール」を管理者が自由に設定できる。
(7) 「サイト検索[転送用]」ブロック
http://あなたのサイト/search.phpにリクエストが有った際、このモジュールに自動的に転送するためのブロック。XOOPS付属のsearch.phpを全く使用したく無い場合は、全てのページ、全てのグループで表示されるように設定してください。

(8) 検索結果の本文を表示できる。(プラグインで拡張可能)
happy_search モジュールでも、searchモジュールのプラグインがそのまま利用できます。

以下、日本語環境のみの機能
(9)  最低文字数の表示を半角と全角で示すように変更。
(10) 用語の一般化「検索対象のモジュール」→「検索対象のページ」
(11) 用語の一般化「検索ルール」→「検索上の注意」
(12) 全角スペースでもAND検索できるように変更。
(13) 全角英数でも半角英数にヒットするように変更(要mbstring)。
(14) 全角カナでも半角カナにヒットするように変更(要mbstring)。
(15) 半角英数でも全角英数にヒットするように変更(要mbstring)。
(16) 半角カナでも全角カナにヒットするように変更(要mbstring)。

2. xoogleモジュール
(1) Google SOAP Search API を利用して Google 検索を行う
(2) Google License Key が必要です。
http://code.google.com/apis/soapsearch/

● 要求事項
happy_linux モジュールが必要です。

● TODO
(1) searchモジュールと xoogleモジュールを 統合しただけなので、統一感のないところがある。
- ３つある検索フォームを１つにまとめる
- 管理者画面にて、３つある設定画面を１つにまとめる
(2) Google の OR 検索をサポートする
Google search supports the Boolean I operator. To retrieve pages that include either word A or word B, use an uppercase OR between terms.
(3) ハードコートしている変数を管理者画面から変更可能にする
(4) モジュール名(ディレクトリ名)を変更可能にする

● ひとりごと
searchモジュールと xoogleモジュールに不満なところがあったため、
自分のサイトで使うために作ったモジュールです。
こういう先人の業績にただ乗りするようなモジュールを公開するのはどうかと思ったが、
公開して欲しいという要望があったので。
