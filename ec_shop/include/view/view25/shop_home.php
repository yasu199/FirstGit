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
                    foreach($err_msg as $value) { ?>
                        <p><?php print $value; ?></p>
                    <?php }
                } ?>
                <p><?php print $message; ?></p>
                <?php if ($how_many <= 4) { ?>
                    <div class="flex">
                <?php } ?>
                <!--ここから自動複製-->
                <?php foreach($data as $value) {
                    if ($how_many > 4) {
                        $i++;
                        if ($i % 4 === 1) { ?>
                            <div class="flex">
                        <?php }
                    } ?>
                    <div class="child">
                        <p class="center"><img src="<?php print $file_place . $value['img']; ?>" width="80px" , height="80px"></p>
                        <p class="center"><?php print entity_str($value['name']); ?></p>
                        <p class="center"><?php print '&yen;' . entity_str($value['price']); ?></p>
                        <?php if ($value['quantity'] > 0) { ?>
                            <p class="center">
                                <form method="post" class="center">
                                    <input type="submit" value="カートに入れる">
                                    <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
                                </form>
                            </p>
                        <?php } else { ?>
                            <p class="center" class="red">売り切れ</p>
                        <?php } ?>
                    </div>
                    <?php if ($how_many > 4) {
                        if ($i % 4 === 0) { ?>
                            </div>
                        <?php }
                    } ?>
                <?php } ?>
                <?php if ($how_many <= 4 || $how_many % 4 !== 0) { ?>
                    </div>
                <?php } ?>
            </div>
        </article>
    </body>
</html>