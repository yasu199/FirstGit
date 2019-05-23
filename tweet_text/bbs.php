<?php
$filename = './bbs.text';
$data = array();
$name = '';
$tweet = '';
$err_msg = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) === TRUE) {
        $name = $_POST['name'];
    }
    if ( isset($_POST['tweet']) === TRUE) {
        $tweet = $_POST['tweet'];
    }
    if (mb_strlen($name) === 0) {
        $err_msg[] = '名前を入力してください。';
    }
    if (mb_strlen($name) > 20) {
        $err_msg[] = '名前は20文字以内でご記入ください。';
    }
    if (mb_strlen($tweet) === 0) {
        $err_msg[] = 'ひとことください。';
    }
    if (mb_strlen($tweet) > 100) {
        $err_msg[] = 'ひとことは100文字以内です。';
    }
    if (count($err_msg) === 0) {
        if (($fp = fopen($filename, 'a')) !== FALSE) {
            $log = $name . '：'  . $tweet . date("-Y-m-d H:i:s") . "\n";
            if (fwrite($fp, $log) === FALSE) {
                print '書き込み失敗';
            }
            fclose($fp);
        }
    }
}
if (is_readable($filename) === TRUE) {
    if (($fp = fopen($filename, 'r')) !== FALSE) {
        while (($tmp = fgets($fp)) !== FALSE) {
            $data[] = $tmp;
        }
        $data = array_reverse($data);
        fclose($fp);
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ひとこと掲示板</title>
    </head>
    <body>
        <?php foreach($err_msg as $value) { ?>
                <p><?php print $value; ?></p>
        <?php } ?>
        <h1>ひとこと掲示板</h1>
        <form method="post">
            名前：
            <input type="text" name="name">
            ひとこと：
            <input type="text" name="tweet">
            <input type="submit" name="submit" value="送信">
        </form>
        <ul>
            <?php foreach ($data as $read) { ?>
                <li><?php print htmlspecialchars($read, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php } ?>
        </ul>
    </body>
</html>