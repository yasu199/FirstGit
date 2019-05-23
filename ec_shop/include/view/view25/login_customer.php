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
                <form action="./login_top_customer.php" method="post">
                    <p><input type="text" name="user_name" placeholder="ユーザー名"></p>
                    <p><input type="password" name="passwd" placeholder="パスワード"></p>
                    <p><input type="submit" value="ログイン"></p>
                </form>
                <?php if ($login_err_flag) { ?>
                    <p><?php print 'ユーザー名もしくはパスワードが間違っています'; ?></p>
                <?php } ?>
                <p><a href="new_customer.php">ユーザーの新規作成</a></p>
            </div>
        </article>
    </body>
<html>