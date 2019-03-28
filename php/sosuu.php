<?php
    $input_line = fgets(STDIN);
    $input_line = explode(' ', $input_line);
    // $k番目の数値を取得
    $k = (int) $input_line[3];
    // 素数の部分のみにする
    unset($input_line[3]);
    // input_lineを昇順に並び替え
    sort($input_line);
    // それぞれの素数を取得
    $first_input = (int) $input_line[0];
    $second_input = (int) $input_line[1];
    $third_input = (int) $input_line[2];
    // 回答の入力用
    $ans = array();
    $count = count($ans);
    // 数字を位置から、配列数$k番目まで増やす
    for ($i = 1; $count < $k; $i++) {
        if ($i === 1) {
            $ans[] = 1;
        } else {
          // 素因数分解
            $n = $i;
            while ($n % $first_input === 0) {
                $n = $n / $first_input;
                if ($n === 1) {
                    $ans[] = $i;
                    continue 2;
                }
            }
            while ($n % $second_input === 0) {
                $n = $n / $second_input;
                if ($n === 1) {
                    $ans[] = $i;
                    continue 2;
                }
            }
            while ($n % $third_input === 0) {
                $n = $n / $third_input;
                if ($n === 1) {
                    $ans[] = $i;
                    continue;
                }
            }
        }
        $count = count($ans);
    }
    // $K番目の要素を取得
    echo $ans[$k - 1];
?>
