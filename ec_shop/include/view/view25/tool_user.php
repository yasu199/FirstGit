<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ユーザー管理</title>
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
        <header>
            <h1>CodeSHOP 管理ページ</h1>
            <ul class="flex">
                <li class="no_style"><a href="logout.php">ログアウト</a></li>
                <li class="no_style">
                    <a href="<?php print $url; ?>">商品管理ページ</a>
                </li>
            </ul>
        </header>
        <article>
            <h1>ユーザ情報一覧</h1>
            <table>
                <tr>
                    <th>ユーザID</th>
                    <th>登録日</th>
                </tr>
                <?php if (count($data) !== 0) {
                    foreach ($data as $value) { ?>
                        <tr>
                            <td>
                                <p><?php print entity_str($value['user_name']); ?></p>
                            </td>
                            <td>
                                <p><?php print entity_str($value['create_date']); ?></p>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        </article>
    </body>
</html>
