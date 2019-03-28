<?php
    $input_line = fgets(STDIN);
    // 日数
    $all_days = (int) $input_line;
    // 日にち
    $input = fgets(STDIN);
    $input_days = explode(' ', $input);
    // 回すため引数：始点、残りの日数、7日クリアしてる？中身の配列
    // 日にち入れてく
    $ans_days = array();
    $tmp_days = array();
    $sum = 0;
    $flag = false;
    for ($i = 0; $i <= ($all_days - 7); $i++) {
        if (count($tmp_days) === 0) {
            for ($h = 0; $h < 7; $h++) {
                $tmp_days[] = (int) $input_days[$h];
            }
            // 合計
            $number = array_sum($tmp_days);
            if ($i === ($all_days - 7)) {
                if ($number <= 5) {
                    $ans_days[] = 7;
                }
            } else {
                    if ($number <= 5) {
                        $sum = 7;
                        $flag = true;
                    }
                }
        } else {
            // 今の始点に対する最後
            $plus = $i + 6;
            // 最後の要素
            $day = (int) $input_days[$plus];
            // 最初の要素
            $first = array_shift($tmp_days);
            // 差し引き
            $gap = $day - $first;
            // 出てるやつに追加
            $number = $number + $gap;
            $tmp_days[] = $day;
            if ($number <= 5) {
                if ($i === ($all_days - 7)) {
                    if ($flag === false) {
                        $ans_days[] = 7;
                    } else {
                        $sum = $sum + 1;
                        $ans_days[] = $sum;
                    }
                } else {
                    if ($flag === false) {
                        $sum = 7;
                        $flag = true;
                    } else {
                        $sum = $sum + 1;
                    }
                }
            } else {
                if ($flag === true) {
                    $ans_days[] = $sum;
                    $flag = false;
                    $sum = 0;
                }
            }
        }
    }
    if (count($ans_days) === 0) {
        echo 0;
    } else {
        echo max($ans_days);
    }
?>
