<?php
    $input_lines = fgets(STDIN);
    $input_lines = explode(' ', $input_lines);
    // 縦要素MAX
    $h_max = (int) $input_lines[0];
    $w_max = (int) $input_lines[1];
    $n_block = (int) $input_lines[2];
    // 初期状態設置
    $all_points = array();
    for ($i = 1;$i <= $h_max; $i++) {
        $inside_points = array();
        for($h = 1; $h <= $w_max; $h++) {
            $inside_points[] = 0;
        }
        $all_points[] = $inside_points;
    }
    // ブロックの落ちてくる要素情報
    while ($block_line = trim(fgets(STDIN))) {
        $block_box[] = $block_line;
    }
    // ブロック要素点検関数
    // function zero_check($i, $x_block, $left_side, $all_points) {
    //     $err_check = array();
    //     $flag = TRUE;
    //     $line_now = $all_points[$i];
    //     for ($h = $x_block; $h < $left_side; $h++) {
    //         if ($line_now[$h] !== 0) {
    //             $err_check[] = 'err_ブロックがあります';
    //         }
    //     }
    //     if (count($err_check) !== 0) {
    //         $flag = FALSE;
    //     }
    //     return $flag;
    // }
    foreach ($block_box as $value) {
        $block[] = explode(' ', $value);
    }
    foreach ($block as $value) {
        // 要素の縦横
        $h_block = (int) $value[0];
        $w_block = (int) $value[1];
        $x_block = (int) $value[2];

        $left_side = $x_block + $w_block;
        $flag = TRUE;
        for ($i = 0; $i < $h_max; $i++) {
            // 現在行の配列取得
            if ($flag === TRUE) {
                $line_now = $all_points[$i];
                // ================================================
                $err_check = array();
                for ($h = $x_block; $h < $left_side; $h++) {
                    if ($line_now[$h] !== 0) {
                        $err_check[] = 'err_ブロックがあります';
                    }
                }
                if (count($err_check) === 0) {
                    for ($h = $x_block; $h < $left_side; $h++) {
                        $all_points[$i][$h] = 1;
                    }
                } else {
                    $flag = FALSE;
                }
                // ===================================================

                // 上部分チェック
                if ($flag === TRUE) {
                    if (($i - $h_block) >= 0) {
                        $past_top = $i - $h_block;
                        for ($h = $x_block; $h < $left_side; $h++) {
                            $all_points[$past_top][$h] = 0;
                        }
                    }
                }
            }
        }
    }
    foreach ($all_points as $value) {
        foreach ($value as $value_child) {
            if ($value_child === 1) {
                echo '#';
            } else {
                echo '.';
            }
        }
        echo "\n";
    }
?>
