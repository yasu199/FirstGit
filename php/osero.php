<?php
    $input_line = fgets(STDIN);
    // 手数
    $moves = (int) $input_line;
    // 以降の手番を取得
    while ($input = trim(fgets(STDIN))) {
        $data[] = $input;
    }
    foreach ($data as $value) {
        $moves_data[] = explode(' ', $value);
    }
    // 盤面の配列を取得。盤面：何もなし：0、黒：B、白：W
    for ($i = 0; $i < 8; $i++) {
        $inline_data = array();
        for ($h = 0; $h < 8; $h++) {
            $inline_data[] = 0;
        }
        $stage_data[] = $inline_data;
    }
    // 初期値を設定
    $stage_data[3][3] = 'W';
    $stage_data[3][4] = 'B';
    $stage_data[4][3] = 'B';
    $stage_data[4][4] = 'W';
    foreach ($moves_data as $value) {
        // 手番,何もなし:0,黒:B,白:W
        $player = $value[0];
        // 横軸
        $y_stage = (int) $value[1];
        $y_stage = $y_stage -1;
        // 縦軸
        $x_stage = (int) $value[2];
        $x_stage = $x_stage - 1;
        // 打ったところを変える
        $stage_data[$x_stage][$y_stage] = $player;
        // 縦軸の上方向
        $x_up = -1;
        // 縦軸の下方向
        $x_down = 1;
        // 左方向
        $y_left = -1;
        // 右方向
        $y_right = 1;
        // フラグ制御(上、下、左、右、左上、右上、左下、右下)
        $flag = array(false, false, false, false, false, false, false, false);
        // 縦方向に動きを付ける
        for ($i = 1;$i <= 8; $i++) {
            // 左方向に見ていく
            if ($y_stage + $y_left >= 0) {
                // 今見る行を取得
                $left_line = $stage_data[$x_stage];
                // 今見ている部分
                $left_now = $left_line[$y_stage + $y_left];
                // 最初の一つ目かどうかで分岐
                if ($y_left === -1) {
                    if ($left_now !== $player && $left_now !== 0) {
                        $flag[2] = true;
                    }
                } else {
                    if ($flag[2] === true) {
                        if ($left_now === $player) {
                            for ($left = -1; $left > $y_left; $left--) {
                                $stage_data[$x_stage][$y_stage + $left] = $player;
                            }
                            $flag[2] = false;
                        }
                    }
                }
            }
            // 右方向に見ていく
            if ($y_stage + $y_right <= 7) {
                // 今見る行を取得
                $right_line = $stage_data[$x_stage];
                // 今見ている部分
                $right_now = $right_line[$y_stage + $y_right];
                // 最初の一つ目かどうかで分岐
                if ($y_right === 1) {
                    if ($right_now !== $player && $right_now !== 0) {
                        $flag[3] = true;
                    }
                } else {
                    if ($flag[3] === true) {
                        if ($right_now === $player) {
                            for ($right = 1; $right < $y_right; $right++) {
                                $stage_data[$x_stage][$y_stage + $right] = $player;
                            }
                            $flag[3] = false;
                        }
                    }
                }
            }
            // 縦の上方向と斜めを見ていく
            if ($x_stage + $x_up >= 0) {
                // 今見る行を取得
                $up_line = $stage_data[$x_stage + $x_up];
                // 今見ている部分
                $up_now = $up_line[$y_stage];
                // 最初の一つ目かどうかで分岐
                if ($x_up === -1) {
                    if ($up_now !== $player && $up_now !== 0) {
                        $flag[0] = true;
                    }
                }else {
                    if ($flag[0] === true) {
                        if ($up_now === $player) {
                            for ($x = -1; $x > $x_up; $x--) {
                                $stage_data[$x_stage + $x][$y_stage] = $player;
                            }
                            $flag[0] = false;
                        }
                    }
                }
                // 左上の部分
                if ($y_stage + $y_left >= 0) {
                    // 今見てるとこ
                    $up_left_now = $up_line[$y_stage + $y_left];
                    // 一つ目かどうか
                    if ($y_left === -1) {
                        if ($up_left_now !== $player && $up_left_now !== 0) {
                            $flag[4] = true;
                        }
                    } else {
                        if ($flag[4] === true) {
                            if ($up_left_now === $player) {
                                for ($left = -1; $left > $y_left; $left--) {
                                    $stage_data[$x_stage + $left][$y_stage + $left] = $player;
                                }
                                $flag[4] = false;
                            }
                        }
                    }
                }
                 // 右上の部分
                if ($y_stage + $y_right <= 7) {
                    // 今見てるとこ
                    $up_right_now = $up_line[$y_stage + $y_right];
                    // 一つ目かどうか
                    if ($y_right === 1) {
                        if ($up_right_now !== $player && $up_right_now !== 0) {
                            $flag[5] = true;
                        }
                    } else {
                        if ($flag[5] === true) {
                            if ($up_right_now === $player) {
                                for ($right = 1; $right < $y_right; $right++) {
                                    $stage_data[$x_stage - ($right)][$y_stage + $right] = $player;
                                }
                                $flag[5] = false;
                            }
                        }
                    }
                }
            }
            // 下方向の動きを見ていく
            if ($x_stage + $x_down <= 7) {
                // 今見る行を取得
                $down_line = $stage_data[$x_stage + $x_down];
                // 今見ている部分
                $down_now = $down_line[$y_stage];
                // 最初の一つ目かどうかで分岐
                if ($x_down === 1) {
                    if ($down_now !== $player && $down_now !== 0) {
                        $flag[1] = true;
                    }
                } else {
                    if ($flag[1] === true) {
                        if ($down_now === $player) {
                            for ($x = 1; $x < $x_down; $x++) {
                                $stage_data[$x_stage + $x][$y_stage] = $player;
                            }
                            $flag[1] = false;
                        }
                    }
                }
                // 左下の部分
                if ($y_stage + $y_left >= 0) {
                    // 今見てるとこ
                    $down_left_now = $down_line[$y_stage + $y_left];
                    // 一つ目かどうか
                    if ($y_left === -1) {
                        if ($down_left_now !== $player && $down_left_now !== 0) {
                            $flag[6] = true;
                        }
                    } else {
                        if ($flag[6] === true) {
                            if ($down_left_now === $player) {
                                for ($left = -1; $left > $y_left; $left--) {
                                    $stage_data[$x_stage - ($left)][$y_stage + $left] = $player;
                                }
                                $flag[6] = false;
                            }
                        }
                    }
                }
                 // 右下の部分
                if ($y_stage + $y_right <= 7) {
                    // 今見てるとこ
                    $down_right_now = $down_line[$y_stage + $y_right];
                    // 一つ目かどうか
                    if ($y_right === 1) {
                        if ($down_right_now !== $player && $down_right_now !== 0) {
                            $flag[7] = true;
                        }
                    } else {
                        if ($flag[7] === true) {
                            if ($down_right_now === $player) {
                                for ($right = 1; $right < $y_right; $right++) {
                                    $stage_data[$x_stage + $right][$y_stage + $right] = $player;
                                }
                                $flag[7] = false;
                            }
                        }
                    }
                }
            }
            $y_left--;
            $y_right++;
            $x_up--;
            $x_down++;
        // for文のインデント
        }
    // foreach文のインデント
    }
    // 合計変数
    $sum_black = 0;
    $sum_white = 0;
    foreach ($stage_data as $value) {
        foreach ($value as $value_child) {
            if ($value_child === 'B') {
                $sum_black++;
            }
            if ($value_child === 'W') {
                $sum_white++;
            }
        }
    }
    if ($sum_black > $sum_white) {
        echo sprintf('%02d', $sum_black) . '-' . sprintf('%02d', $sum_white) . ' The black won!';
    } elseif ($sum_black < $sum_white) {
        echo sprintf('%02d', $sum_black) . '-' . sprintf('%02d', $sum_white) . ' The white won!';
    } else {
        echo sprintf('%02d', $sum_black) . '-' . sprintf('%02d', $sum_white) . ' Draw!';
    }
?>
