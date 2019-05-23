<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ログインページ</title>
        <link rel="stylesheet" href="style.css">
    <head>
    <body>
        <header>
            <div class="all_width flex_head page_center">
                <div class="center"><a href="./top.php" class="title">CodeCanpSHOP</a></div>
                <ul class="flex">
                    <li class="no_style inlign center"><a href="./cart.php"><img src="./icon/cart.jpeg" width="50px" height="50px"></a></li>
                </ul>
            </div>
            
        </header>
        <article>
            <div class="page_center all_width center">
                <?php if (count($err_msg) !== 0) {
                    foreach($err_msg as $value) { ?>
                        <p><?php print $value; ?></p>
                    <?php }
                } ?>
                <p><?php print $message; ?></p>
                <form method="post">
                    <p>ユーザー名:<input type="text" name="user_name" placeholder="ユーザー名"></p>
                    <p>パスワード:<input type="password" name="passwd" placeholder="パスワード"></p>
                    <p><input type="submit" value="ユーザーを新規追加作成する"></p>
                </form>
                <p><a href="login_customer.php">ログインページに戻る</a></p>
            </div>
        </article>
    </body>
<html>
