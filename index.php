<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- これがレスポンシブなんたらってヤツか！ -->
<meta name="format-detection" content="telephone=no"> <!-- Tel No.っぽい文字列をリンク扱いしないでよっ -->
<title>「言葉にならないキミの声」生成装置 ～ The Emotional Voice Generator</title>
<link rel="stylesheet" type="text/css" href="KotobaniNaranai.css">
</head>

<body>
<?php

/**
 * htmlspecialcharsとかいうくっそ長い関数名を簡略化する
 */
function sp($str) {
	return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

/**
 * 初回閲覧時など、実行結果を出力しないときも、声の表示場所を告知する
 */
function pre_disp_emo_v() {
	echo "<div class=\"result_s\">";
	echo "「言葉にならないキミの声」は、ここに表示されます。<br>The Emotional Voice comes out here.";
	echo "</div><hr>";
}

// ページのタイトル部分を表示する
echo "<div class=\"bklnk\">";
echo "<a href=\"https://x1gg.com/fullpower-for-nonsense-products/kotobaninaranai/\">".
		"←合同会社ライトスタッフシステムズのページに戻る".
		"(back to the website of The Right Stuff Systems.)</a><br>";
echo "</div>";
echo "<div class=\"title\">";
// ページ上部にアプリの名称を表示する
echo "<h1>「言葉にならないキミの声」生成装置<br>The Emotional Voice Generator</h1>";
echo "<a href=\"#setting\">↓設定一覧へ(jump to the settings.)</a>";
echo "<p>各ブラウザの最新版でのご利用を推奨します。<br>".
		"The LATEST version of each Browsers are recommended.</p>";
echo "</div>";
echo "<hr>";
// 名称の下にアプリの存在理由を表示する
echo "<a id=\"purpose\"></a>";
echo "<div class=\"intro\">";
echo "<input id=\"id_vis_sw\" type=\"checkbox\" />";
echo "<label for=\"id_vis_sw\">"."ナンダコレハ？／What's this?"."</label>";
echo "<div class=\"intro_visible\">";
/* ラジオボタンで日英切り替えは見送る
echo "<p>";
echo "<input id=\"id_intro_jp\" type=\"radio\" name=\"lang_sw\" value=\"jp\" checked=\"checked\" />";
echo "<label for=\"id_intro_jp\">日本語</label>";
echo "<input id=\"id_intro_en\" type=\"radio\" name=\"lang_sw\" value=\"en\" />";
echo "<label for=\"id_intro_en\">English</label>";
echo "</p>";
*/
echo "<p>*English follows after Japanese.</p>";
echo "<div class=\"intro_jp\">";
echo "<p>".
		"このAI(Artificial Idiot)は、意味不明な文字列を生成するのにとっても役立つ装置です。たとえば、マンガとかで登場人物が".
		"足の小指をタンスのカドにぶつけたり、感電したときなど、フキダシの中に記号（◎※△）、もしくはメチャクチャな並びの文字（くぁｗせｄｒｆｔｇｙ".
		"ふじこｌｐ）とかが並んでたりするのを見たことありませんか？それです。".
	"</p>".
	"<p>".
		"「!、?」（感嘆符、疑問符）は、あえて要素文字から外しました。お好みで要素文字の入力欄に追加したり、実行結果の後ろとかに".
		"手作業でくっつけたりしてご利用ください。".
	"</p>".
	"<p>".
		"細かいこというと、「あ゛」とか「ま゛」など、2文字セットで表現せなアカンやつには対応してませんので、そういうのも手作業でお願いします。".
	"</p>";
echo "</div>";
echo "<hr>";
echo "<div class=\"intro_en\">";
echo "<p>".
		"This AI(Artificial Idiot) has been developed for generating an emotional voice ".
		"(a string difficult for the human to read), such as a scream of someone who ".
		"hits his/her little toe against the corner of the cabinet, or someone who got ".
		"an electric shock. (sometimes seen in some comics or something.)".
	"</p>".
	"<p>".
		"\"!\" and \"?\"(exclamation and question) marks are intentionally excluded from the ".
		"elements(letters). They can be added into each text-input-area of the elements(letters) ".
		"of the string to be generated, or inserted into the generated string manually.".
	"</p>".
	"<p>".
		"This AI doesn't support a pair of multi-byte letters, such like \"あ゛\", \"ま゛\", etc. ".
		"If necessary, they should be inserted manually into the generated string.".
	"</p>";
echo "</div>";
echo "<label for=\"id_vis_sw\"></label>";
echo "</div>";
echo "</div>";

// 各文字種の要素文字を宣言、初期化する
$org_symbol_m = "仝々〆＋×≠∞∴♂♀℃￥＄￠￡％＃＊＠".
				"☆★○●◇◆□■△▲▽▼※∀"."≒∵‰♭♪". // SJIS全角記号のうち、普通の文字と見分けやすいモノ
				""; // その他、思いついたり、要望があったら加える
$org_symbol_s = "#$%&'^~\\|@+/*". // ひとまずMS-IMEで環境依存と表示されないモノ
				"";
				// mb_convert_kana関数では全角記号の一部を半角化できなかった
				// "£¡¤¦µ¿"とかも加えたいけど、mb_strwidth=1、strlen=2となる→条件分岐の基準が不明瞭なので見送る
$org_hiragana = "あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわゐゑをん".
				"がぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉゃゅょゎ";
$org_katakana = "アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヰヱヲン".
				"ヴガギグゲゴザジズゼゾダヂヅデドバビブベボパピプペポァィゥェォヵヶャュョヮ";
$org_alpha_std = "abcdefghijklmnopqrstuvwxyz";
$org_alpha_cap = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$org_number = "0123456789";

$c_symbol_m = "";
$c_symbol_s = "";
$c_hiragana = "";
$c_katakana = "";
$c_alphas_m = "";
$c_alphas_s = "";
$c_alphac_m = "";
$c_alphac_s = "";
$c_num_m = "";
$c_num_s = "";

// ロジックの主要変数を宣言、初期化する
$len_max = (int)1000;
$len = filter_input(INPUT_GET, "len_str", FILTER_VALIDATE_INT);

$e_str = "";
$reason_failed_jp = "";
$reason_failed_en = "";
$emo_v = "";

// 読めない文字列生成装置の心臓部
if (isset($_GET['todo'])) {
	if ($_GET['todo'] == "generate") {
		// 文字種の内部変数を、form送信された情報で初期化する
		$symbol_m = $_GET['str_sym_m'];
		$symbol_s = $_GET['str_sym_s'];
		$hiragana = $_GET['str_hira_m'];
		$katakana = $_GET['str_kata_m'];

		$alpha_std = $_GET['str_alphas'];
		$alpha_cap = $_GET['str_alphac'];
		$number = $_GET['str_num'];

		// 文字列の生成を試みる
		if ($len == "" || !is_int($len) || $len < 1 || $len > $len_max) {
			// 声の長さ（文字数）が入力されてなかったり、整数じゃなかったり、適正範囲でないときは、文句を返す
			$reason_failed_jp = "「言葉にならないキミの声」の長さは、<b>1以上".$len_max."以下の整数</b>を入力してください。";
			$reason_failed_en = "The length of voice should be an <b>INTEGER, ".
								"between 0 and ".$len_max."</b>.";
			$len = ""; // 条件式と重複してるけど、こっちはあとでformのテキスト入力欄に表示するためのモノ
		} else {
			// checkされた要素文字を生成元の文字列に取り込む
			if (isset($_GET['chk_sym_m'])) $e_str .= $symbol_m;
			if (isset($_GET['chk_sym_s'])) $e_str .= $symbol_s;
			if (isset($_GET['chk_hira_m'])) $e_str .= $hiragana;
			if (isset($_GET['chk_kata_m'])) $e_str .= $katakana;

			// 全角と半角を両方選択できる文字種のtextareaに全角と半角が混ざって入力されていたら、
			// それらを全角に変換した文字列と、半角に変換した文字列を結合して、生成元の文字列に加える
			if (isset($_GET['chk_alphas_m'])) {
				$tmpstr = mb_convert_kana($alpha_std, "ASKV", "UTF-8");
				$tmpchr = "";
				$addstr = "";
				// 全角化されたはずの文字列（$tmpstr）から全角文字だけ利用する
				for ($i = 0; $i < mb_strlen($tmpstr, "UTF-8"); $i++) {
					$tmpchr = mb_substr($tmpstr, $i, 1, "UTF-8");
					if (strlen($tmpchr) > 1) $addstr .= $tmpchr;
				}
				$e_str .= $addstr;
			}
			if (isset($_GET['chk_alphas_s'])) {
				$tmpstr = mb_convert_kana($alpha_std, "as", "UTF-8");
				$tmpchr = "";
				$addstr = "";
				// 半角化されたはずの文字列（$tmpstr）から半角文字だけ利用する
				for ($i = 0; $i < mb_strlen($tmpstr, "UTF-8"); $i++) {
					$tmpchr = mb_substr($tmpstr, $i, 1, "UTF-8");
					if (strlen($tmpchr) == 1) $addstr .= $tmpchr;
				}
				$e_str .= $addstr;
			}
			if (isset($_GET['chk_alphac_m'])) {
				$tmpstr = mb_convert_kana($alpha_cap, "ASKV", "UTF-8");
				$tmpchr = "";
				$addstr = "";
				for ($i = 0; $i < mb_strlen($tmpstr, "UTF-8"); $i++) {
					$tmpchr = mb_substr($tmpstr, $i, 1, "UTF-8");
					if (strlen($tmpchr) > 1) $addstr .= $tmpchr;
				}
				$e_str .= $addstr;
			}
			if (isset($_GET['chk_alphac_s'])) {
				$tmpstr = mb_convert_kana($alpha_cap, "as", "UTF-8");
				$tmpchr = "";
				$addstr = "";
				for ($i = 0; $i < mb_strlen($tmpstr, "UTF-8"); $i++) {
					$tmpchr = mb_substr($tmpstr, $i, 1, "UTF-8");
					if (strlen($tmpchr) == 1) $addstr .= $tmpchr;
				}
				$e_str .= $addstr;
			}
			if (isset($_GET['chk_num_m'])) {
				$tmpstr = mb_convert_kana($number, "ASKV", "UTF-8");
				$tmpchr = "";
				$addstr = "";
				for ($i = 0; $i < mb_strlen($tmpstr, "UTF-8"); $i++) {
					$tmpchr = mb_substr($tmpstr, $i, 1, "UTF-8");
					if (strlen($tmpchr) > 1) $addstr .= $tmpchr;
				}
				$e_str .= $addstr;
			}
			if (isset($_GET['chk_num_s'])) {
				$tmpstr = mb_convert_kana($number, "as", "UTF-8");
				$tmpchr = "";
				$addstr = "";
				for ($i = 0; $i < mb_strlen($tmpstr, "UTF-8"); $i++) {
					$tmpchr = mb_substr($tmpstr, $i, 1, "UTF-8");
					if (strlen($tmpchr) == 1) $addstr .= $tmpchr;
				}
				$e_str .= $addstr;
			}

			if (strlen($e_str) < 1) {
				// 生成元文字列の文字数がゼロ以下のときは、文句を返す
				$reason_failed_jp = "「言葉にならないキミの声」の文字種は、<b>空欄でない</b>ものを".
						"<b>1つ以上</b>選んでください。";
				$reason_failed_en = "The \"Type of letters\" should be selected ".
						"<b>AT LEAST 1, NOT EMPTY</b>.";
			} else {
				// 生成元の文字列から、表示すべき文字数の分、ランダムに1文字選択してつなげる
				for ($i = 0; $i < $len; $i++) {
					$emo_v .= mb_substr($e_str, random_int(0, mb_strlen($e_str, "UTF-8")-1), 1, "UTF-8");
				}
			}
		}

		// 実行結果を表示する
		if ($reason_failed_jp.$reason_failed_en != "") {
			echo "<div class=\"result_f\">";
			echo "<p>「言葉にならないキミの声」は、以下の理由により<b>生成されませんでした。</b></p>".
					"<p class=\"reason_f\">".$reason_failed_jp."</p><hr>".
					"<p>The string of the emotional voice was <b>NOT CREATED</b>".
					" by the following reason.</p>".
					"<p class=\"reason_f\">".$reason_failed_en."</p>";
			echo "</div>";
		} else {
			echo "<div class=\"result_s\">";
			echo "<p>「言葉にならないキミの声」が生成されました。<br>".
					"The Emotional Voice was generated as follows.<br>";
			// XSS対策のため、実行結果の文字列をエスケープ…しなくてよくない？<input type="text" />の中に表示するから
			// → しなくちゃダメ!!! 閉じタグ + <script>～</script>でXSSできちゃった
			// → textタイプのinput要素も、htmlspecialcharsでエスケープ処理すればOK
			// → ブラウザが"&lt;"とか"&gt;"とかでなく、ちゃんと"<"とか">"って表示してくれる
			echo "<form>".
					"<input type=\"text\" name=\"emoikoe\" value=\"".sp($emo_v)."\" />".
					"</form></p><hr>";
			echo "<p>※ご参考：利用した要素文字<br>FYI: These letters were used for generating ".
					"the Emotional Voice.</p><p class=\"elem_disp\">".sp($e_str)."</p>";
			echo "</div>";
		}
		echo "<hr>";

		// 後処理：各文字種の入力欄を（生成ボタンを押したときの状態に）再設定する
		$symbol_m = $_GET['str_sym_m'];
		$symbol_s = $_GET['str_sym_s'];
		$hiragana = $_GET['str_hira_m'];
		$katakana = $_GET['str_kata_m'];

		$alpha_std = $_GET['str_alphas'];
		$alpha_cap = $_GET['str_alphac'];
		$number = $_GET['str_num'];
	} else {
		// Clear、Resetボタンが押されたとき
		$cmd = explode(",", $_GET['todo'])[0];
		$tgt = explode(",", $_GET['todo'])[1];

		switch ($cmd) {
		case "clear":
			// ボタンに対応する文字種のtextareaを空欄にする
			$symbol_m  = ($tgt == "sym_m")  ? "" : $_GET['str_sym_m'];
			$symbol_s  = ($tgt == "sym_s")  ? "" : $_GET['str_sym_s'];
			$hiragana  = ($tgt == "hira_m") ? "" : $_GET['str_hira_m'];
			$katakana  = ($tgt == "kata_m") ? "" : $_GET['str_kata_m'];

			$alpha_std = ($tgt == "alphas") ? "" : $_GET['str_alphas'];
			$alpha_cap = ($tgt == "alphac") ? "" : $_GET['str_alphac'];
			$number    = ($tgt == "number") ? "" : $_GET['str_num'];
			// 実行結果の表示場所を告知する
			pre_disp_emo_v();
			break;
		case "reset":
			// ボタンに対応する文字種のtextareaをデフォルトに戻す
			$symbol_m  = ($tgt == "sym_m")  ? $org_symbol_m  : $_GET['str_sym_m'];
			$symbol_s  = ($tgt == "sym_s")  ? $org_symbol_s  : $_GET['str_sym_s'];
			$hiragana  = ($tgt == "hira_m") ? $org_hiragana  : $_GET['str_hira_m'];
			$katakana  = ($tgt == "kata_m") ? $org_katakana  : $_GET['str_kata_m'];

			$alpha_std = ($tgt == "alphas") ? $org_alpha_std : $_GET['str_alphas'];
			$alpha_cap = ($tgt == "alphac") ? $org_alpha_cap : $_GET['str_alphac'];
			$number    = ($tgt == "number") ? $org_number    : $_GET['str_num'];
			// 実行結果の表示場所を告知する
			pre_disp_emo_v();
			break;
		default:
			// 特にすべきことはない
			break;
		}
	}
	// 後処理：ボタンの種類にかかわらず、各チェック欄を（ボタンを押したときの状態に）再設定する
	$c_symbol_m = isset($_GET['chk_sym_m'])    ? "checked=\"checked\"" : "";
	$c_symbol_s = isset($_GET['chk_sym_s'])    ? "checked=\"checked\"" : "";
	$c_hiragana = isset($_GET['chk_hira_m'])   ? "checked=\"checked\"" : "";
	$c_katakana = isset($_GET['chk_kata_m'])   ? "checked=\"checked\"" : "";

	$c_alphas_m = isset($_GET['chk_alphas_m']) ? "checked=\"checked\"" : "";
	$c_alphas_s = isset($_GET['chk_alphas_s']) ? "checked=\"checked\"" : "";
	$c_alphac_m = isset($_GET['chk_alphac_m']) ? "checked=\"checked\"" : "";
	$c_alphac_s = isset($_GET['chk_alphac_s']) ? "checked=\"checked\"" : "";
	$c_num_m    = isset($_GET['chk_num_m'])    ? "checked=\"checked\"" : "";
	$c_num_s    = isset($_GET['chk_num_s'])    ? "checked=\"checked\"" : "";
} else {
	// 初回など、ボタンとか押されずに表示されたとき…
	// 声の長さと文字種の入力欄をデフォルトに設定する
	$len = "";
	$symbol_m = $org_symbol_m;
	$symbol_s = $org_symbol_s;
	$hiragana = $org_hiragana;
	$katakana = $org_katakana;
	$alpha_std = $org_alpha_std;
	$alpha_cap = $org_alpha_cap;
	$number = $org_number;
	// チェック欄をデフォルトに設定する
	$c_symbol_m = "";
	$c_symbol_s = "";
	$c_hiragana = "";
	$c_katakana = "";
	$c_alphas_m = "";
	$c_alphas_s = "";
	$c_alphac_m = "";
	$c_alphac_s = "";
	$c_num_m = "";
	$c_num_s = "";
	// 実行結果の表示場所を告知する
	pre_disp_emo_v();
}

?>

<a id="setting"></a>
<div class="tblbg">
	<h2>設定一覧／Settings</h2>

	<form action="./" method="get" enctype="application/x-www-form-urlencoded">
	<p>「声」の長さ（生成したい文字数）は？<br>
	How long(how many letters) will the Voice be required?<br>
	<input class="reqlen" type="text" name="len_str" value="<?php echo sp($len); ?>"/></p>
	<p><b>註:</b> 1以上<?php echo $len_max ?>以下の整数を入力してください。<br>
		<b>NOTE:</b> It must be an integer, between 1 and <?php echo $len_max ?>.</p>
	<?php // 不具合対策 … テキスト入力欄でEnterを押すと、（おそらくform内で最初に、または、入力欄以降で最初に記述されている
			// submitの内容で）フォームが送信されるので、誤動作を抑制する … おそらくもっとスマートな方法があるはず ?>
	<input class="txt_ent" type="submit" name="todo" value="generate" />

	<?php // XSS対策 … textareaに閉じタグ（</textarea>）を入力されると、それ以降は好き勝手されてしまう
			// → 設定一覧の上に出てくる結果表示欄（textタイプのinput要素）と同様、htmlspecialcharsでエスケープ処理する ?>
	<div class="tbl_h">
		<div class="h_type">文字の種類<br>Type of<br>letters</div>
		<div class="h_edit">要素文字（編集可）<br>Element letters(editable)<hr>
							全角・半角選択スイッチ<br>Multi/Single-Byte select switches</div>
	</div>
	<div class="tbl_d">
		<div class="d_type">全角記号<br>Multi-Byte<br>Symbol</div>
		<div class="d_edit">
			<textarea name="str_sym_m"><?php echo sp($symbol_m); ?></textarea></div>
		<div class="d_btns">
			<button type="submit" name="todo" value="clear,sym_m">Clear</button>
			<button type="submit" name="todo" value="reset,sym_m">Reset</button>
		</div>
		<div class="d_sw_m">
			<input id="id_sym_m" type="checkbox" name="chk_sym_m" <?php echo $c_symbol_m; ?> />
			<label for="id_sym_m">全角 Multi-Byte</label></div>
		<div class="d_sw_s">――</div>
	</div>
	<div class="tbl_d">
		<div class="d_type">半角記号<br>Single-Byte<br>Symbol</div>
		<div class="d_edit">
			<textarea name="str_sym_s"><?php echo sp($symbol_s); ?></textarea></div>
		<div class="d_btns">
			<button type="submit" name="todo" value="clear,sym_s">Clear</button>
			<button type="submit" name="todo" value="reset,sym_s">Reset</button>
		</div>
		<div class="d_sw_m">――</div>
		<div class="d_sw_s">
			<input id="id_sym_s" type="checkbox" name="chk_sym_s" <?php echo $c_symbol_s; ?> />
			<label for="id_sym_s">半角 Single-Byte</label></div>
	</div>
	<div class="tbl_d">
		<div class="d_type">ひらがな<br>Hiragana</div>
		<div class="d_edit">
			<textarea name="str_hira_m"><?php echo sp($hiragana); ?></textarea></div>
		<div class="d_btns">
			<button type="submit" name="todo" value="clear,hira_m">Clear</button>
			<button type="submit" name="todo" value="reset,hira_m">Reset</button>
		</div>
		<div class="d_sw_m">
			<input id="id_hira_m" type="checkbox" name="chk_hira_m" <?php echo $c_hiragana; ?> />
			<label for="id_hira_m">全角 Multi-Byte</label></div>
		<div class="d_sw_s">――</div>
	</div>
	<div class="tbl_d">
		<div class="d_type">カタカナ<br>Katakana</div>
		<div class="d_edit">
			<textarea name="str_kata_m"><?php echo sp($katakana); ?></textarea></div>
		<div class="d_btns">
			<button type="submit" name="todo" value="clear,kata_m">Clear</button>
			<button type="submit" name="todo" value="reset,kata_m">Reset</button>
		</div>
		<div class="d_sw_m">
			<input id="id_kata_m" type="checkbox" name="chk_kata_m" <?php echo $c_katakana; ?> />
			<label for="id_kata_m">全角 Multi-Byte</label></div>
		<div class="d_sw_s">――</div>
	</div>
	<div class="tbl_d">
		<div class="d_type">英小文字<br>Alphabet</div>
		<div class="d_edit">
			<textarea name="str_alphas"><?php echo sp($alpha_std); ?></textarea></div>
		<div class="d_btns">
			<button type="submit" name="todo" value="clear,alphas">Clear</button>
			<button type="submit" name="todo" value="reset,alphas">Reset</button>
		</div>
		<div class="d_sw_m">
			<input id="id_alphas_m" type="checkbox" name="chk_alphas_m" <?php echo $c_alphas_m ?> />
			<label for="id_alphas_m">全角 Multi-Byte</label></div>
		<div class="d_sw_s">
			<input id="id_alphas_s" type="checkbox" name="chk_alphas_s" <?php echo $c_alphas_s ?> />
			<label for="id_alphas_s">半角 Single-Byte</label></div>
	</div>
	<div class="tbl_d">
		<div class="d_type">英大文字<br>Capital</div>
		<div class="d_edit">
			<textarea name="str_alphac"><?php echo sp($alpha_cap); ?></textarea></div>
		<div class="d_btns">
			<button type="submit" name="todo" value="clear,alphac">Clear</button>
			<button type="submit" name="todo" value="reset,alphac">Reset</button>
		</div>
		<div class="d_sw_m">
			<input id="id_alphac_m" type="checkbox" name="chk_alphac_m" <?php echo $c_alphac_m ?> />
			<label for="id_alphac_m">全角 Multi-Byte</label></div>
		<div class="d_sw_s">
			<input id="id_alphac_s" type="checkbox" name="chk_alphac_s" <?php echo $c_alphac_s ?> />
			<label for="id_alphac_s">半角 Single-Byte</label></div>
	</div>
	<div class="tbl_d">
		<div class="d_type">数字<br>Number</div>
		<div class="d_edit">
			<textarea name="str_num"><?php echo sp($number); ?></textarea></div>
		<div class="d_btns">
			<button type="submit" name="todo" value="clear,number">Clear</button>
			<button type="submit" name="todo" value="reset,number">Reset</button>
		</div>
		<div class="d_sw_m">
			<input id="id_num_m" type="checkbox" name="chk_num_m" <?php echo $c_num_m ?> />
			<label for="id_num_m">全角 Multi-Byte</label></div>
		<div class="d_sw_s">
			<input id="id_num_s" type="checkbox" name="chk_num_s" <?php echo $c_num_s ?> />
			<label for="id_num_s">半角 Single-Byte</label></div>
	</div>
	<div class="tbl_f">
		<div class="f_edit">
			<p><b>※要素文字編集欄と全角・半角選択スイッチについて</b></p>
			<p><b>註:</b> すべての入力エリアを空欄にしないでください。<br>
				<b>註:</b> 英小文字、大文字、数字の入力欄は、内容が半角文字だけでも、全角をONにすれば全角文字が自動生成
					されます。同様に、内容が全角文字だけでも、半角をONにすれば半角文字が自動生成されます。</p>
			<p><b>NOTE:</b> Should NOT make ALL of the fields EMPTY.<br>
				<b>NOTE:</b> When the "Multi-Byte" select switches of the Alphabet, the Capital,
							 and the Number were "ON", even if there were only Single-Byte-letters
							 in each text-input-area, Multi-Byte-letters are automatically added,
							 and vice-versa.</p>
		</div>
		<div class="f_btn">
			<p><b>※クリア・リセットボタンについて</b></p>
			<p><b>註:</b> 各文字種の編集欄を<br>
						Clear = 空にします。<br>
						Reset = 初期状態に戻します。</p>
			<p><b>NOTE:</b> The "Clear" and "Reset" buttons above make the text-input-area
							 located in the left to them "Clear"...erase all the letters inside,
							 or "Reset"...discard all of customizes and restore the initial state.</p>
		</div>
		<div class="f_gen">
			<p>
			<button type="submit" name="todo" value="generate">Generate Emotional Voice</button>
			</p>
		</div>
	</div>
	</form>
</div>
<div class="ftr">
<p>&copy;<a href="https://x1gg.com">The Right Stuff Systems.</a> All rights reserved.</p>
</div>
</body>
</html>