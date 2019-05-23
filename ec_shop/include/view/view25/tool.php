<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>商品一覧</title>
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
        <header>
            <?php if (count($err_msg) !== 0) {
                foreach($err_msg as $value) { ?>
                    <p><?php print $value; ?></p>
                <?php } ?>
            <?php } ?>
            <?php if ($message !== '') { ?>
                <p><?php print $message; ?></p>
            <?php } ?>
            <h1>CodeSHOP 管理ページ</h1>
            <ul class="flex">
                <li class="no_style"><a href="logout.php">ログアウト</a></li>
                <li class="no_style"><a href="tool_user.php">ユーザー管理ページ</a></li>
            </ul>
        </header>
        <article id="insert">
            <h1>商品の登録</h1>
            <form method="post" enctype="multipart/form-data">
                <p>商品名:<input type="text" name="item_name"></p>
                <p>値段:<input type="text" name="price"></p>
                <p>個数:<input type="text" name="quantity"></p>
                <input type="hidden" name="MAX_FILE_SIZE" value="144000">
                <p>商品画像:<input type="file" name="img" accept="image/*,.jpeg,.png"></p>
                <p>
                    ステータス:
                    <select name="status">
                        <option value="1" selected>公開</option>
                        <option value="2">非公開</option>
                    </select>
                </p>
                <input type="hidden" name="insert" value="insert">
                <p><input type="submit" value="商品を登録する"></p>
            </form>
        </article>
        <article>
            <h1>商品情報の一覧・変更</h1>
            <table>
                <tr>
                  <th>商品画像</th>
                  <th>商品名</th>
                  <th>価格</th>
                  <th>在庫数</th>
                  <th>ステータス</th>
                  <th>操作</th>
                </tr>
                <?php if (count($data) !== 0) {
                    foreach($data as $value) { ?>
                        <tr>
                            <td>
                                <img src="<?php print $file_place . $value['img']; ?>">
                            </td>
                            <td>
                                <p><?php print entity_str($value['name']); ?></p>
                            </td>
                            <td>
                                <p><?php print entity_str($value['price']); ?></p>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="text" name="quantity" value="<?php print $value['quantity']; ?>">
                                    個
                                    <input type="hidden" name="item_id" value="<?php print $value['item_id'];?>">
                                    <input type="hidden" name="fix_quantity" value="fix_quantity">
                                    <input type="submit" value="変更する">
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="submit" value="<?php if ($value['status'] === '1') {
                                        print '公開→非公開';
                                    } else {
                                        print '非公開→公開';
                                    } ?>"> 
                                    <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
                                    <input type="hidden" name="status" value="<?php print $value['status']; ?>">
                                    <input type="hidden" name="fix_status" value="fix_status">
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="submit" value="削除する">
                                    <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
                                    <input type="hidden" name="delete" value="delete">
                                </form>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </table>
        </article>
    </body>
</html>
