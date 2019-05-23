<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>CodeCanpSHOP</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <div class="all_width flex_head page_center">
                <div class="center"><a href="./top.php" class="title">CodeCanpSHOP</a></div>
                <ul class="flex">
                    <li class="no_style inlign center">ユーザー名:<?php print $user_name; ?></li>
                    <li class="no_style inlign center"><a href="./cart.php"><img src="./icon/cart.jpeg" width="50px" height="50px"></a></li>
                    <li class="no_style inlign center"><a href="./logout.php">ログアウト</a></li>
                </ul>
            </div>
        </header>
        <article>
            <div class="page_center all_width">
                <?php if (count($err_msg) !== 0) {
                      foreach ($err_msg as $value) { ?>
                          <p><?php print entity_str($value); ?></p>
                    <?php } 
                } ?>
                <?php if ($message !== '') { ?>
                    <p><?php print $message; ?></p>
                <?php } ?>
                <h1>ショッピングカート</h1>
                <table class="none" class="all_width">
                    <tr class="up-bottom">
                        <th class="none"></th>
                        <th class="none"></th>
                        <th class="none"></th>
                        <th class="none">価格</th>
                        <th class="none">数量</th>
                    </tr>
                    <?php if (count($data) !== 0) {
                        foreach($data as $value) { ?>
                            <tr class="up-bottom">
                                <td class="none">
                                    <img src="<?php print $file_place . $value['img']; ?>"  width="80px" height="80px">
                                </td>
                                <td class="none">
                                    <p><?php print entity_str($value['name']); ?></p>
                                </td>
                                <td class="none">
                                    <form method="post">
                                        <input type="submit" value="削除">
                                        <input type="hidden" name="cart_id" value="<?php print $value['cart_id']; ?>">
                                        <input type="hidden" name="delete" value="delete">
                                    </form>
                                </td>
                                <td class="none">
                                    <p><?php print '&yen;' . $value['price']; ?></p>
                                </td>
                                <td class="none">
                                    <form method="post">
                                        <p>
                                            <input type="text" name="amount" value="<?php print $value['amount']; ?>">
                                            <input type="hidden" name="fix_amount" value="fix_amount">
                                            <input type="hidden" name="cart_id" value="<?php print $value['cart_id']; ?>">
                                            <input type="submit" value="変更する">
                                        </p>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <tr class="none">
                        <th class="none"></th>
                        <th class="none"></th>
                        <th class="none">合計</th>
                        <th class="none"><?php print '&yen;' . $total; ?></th>
                        <th class="none"></th>
                    </tr>
                </table>
                <form method="post" class="all_width">
                    <input type="submit" value="購入する" class="all_width">
                    <input type="hidden" name="buy" value="buy">
                </form>
                <p>
                    <a href="./shop_home.php">買い物に戻る</a>
                </p>
            </div>
        </article>
    </body>
</html>