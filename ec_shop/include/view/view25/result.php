<!--結果画面view-->
<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>自動販売機</title>
    </head>
    <body>
        <?php if (count($err_msg) !== 0) {
            foreach($err_msg as $value) { ?>
                <p><?php print $value; ?></p>
            <?php } ?>
            <a href="./index.php">戻る</a>
        <?php } ?>
        <?php if (count($err_msg) === 0 && isset($drink_name) === TRUE) { ?>
            <h1>自動販売機結果</h1>
            <p><img src="<?php print $file_directory . $drink_image; ?>" width="80px" height="80px"></p>
            <p>がっしゃん！【<?php print htmlspecialchars($drink_name, ENT_QUOTES, 'UTF-8'); ?>】が買えました！</p>
            <p>おつりは<?php print $exchange; ?>です</p>
            <a href="./index.php">戻る</a>
        <?php } ?>
    </body>
</html>