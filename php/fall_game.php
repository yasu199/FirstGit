<?php
    $input_lines = fgets(STDIN);
    $input_lines = explode(' ', $input_lines);
    // 縦要素MAX
    // ステージの縦の最大値
    $h_max = (int) $input_lines[0];
    // ステージの横フレームの最大値
    $w_max = (int) $input_lines[1];
    // ブロック数
    $n_block = (int) $input_lines[2];
    // ステージ全体の初期状態設置
    $all_points = array();
    for ($i = 1;$i <= $h_max; $i++) {
        $inside_points = array();
        for($h = 1; $h <= $w_max; $h++) {
            $inside_points[] = '.';
        }
        $all_points[] = $inside_points;
    }
    // 落ちてくるブロックの要素情報
    while ($block_line = trim(fgets(STDIN))) {
        $block_box[] = $block_line;
    }
    foreach ($block_box as $value) {
        $block[] = explode(' ', $value);
    }

    // 落下してくるブロックについて、ステージを.→#へ変更
    // ブロックひとつづつについて確認
    foreach ($block as $value) {
        // 要素の縦横
        // ブロックの縦幅
        $h_block = (int) $value[0];
        // ブロックの横幅
        $w_block = (int) $value[1];
        // ブロックの左端の位置
        $x_block = (int) $value[2];
        // ブロックの右端の位置
        $left_side = $x_block + $w_block;
        // ブロックについて、ステージの位置を1行づつ降下
        for ($i = 0; $i < $h_max; $i++) {
            // ブロックの現在行のステージ情報取得
            $line_now = $all_points[$i];
            // ブロックの左端から右端まで、ステージ上に障害物があるか確認
            // あった場合にはブロックの降下処理までをbreak
            for ($h = $x_block; $h < $left_side; $h++) {
                if ($line_now[$h] === '#') {
                    break 2;
                }
            }
            // 障害物がなかった時はブロックがあることをステージに#マークで記載
            for ($h = $x_block; $h < $left_side; $h++) {
                $all_points[$i][$h] = '#';
            }
            // ブロックが完全にステージに入っていた場合、ブロックの上部分を一段下げるため、
            // 上部分があった場所について、ステージの#を.へ書き換え
            if (($i - $h_block) >= 0) {
              // 抜けた上部分のステージ行をpast_topとして記載
                $past_top = $i - $h_block;
                // ブロックが抜けた部分について、ステージの#を.へ書き換え
                for ($h = $x_block; $h < $left_side; $h++) {
                    $all_points[$past_top][$h] = '.';
                }
            }
        }
    }
    foreach ($all_points as $value) {
        foreach ($value as $value_child) {
            echo $value_child;
        }
        echo "\n";
    }
?>
