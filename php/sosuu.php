<?php
    $input_line = fgets(STDIN);
    $input_line = explode(' ', $input_line);
    $k = (int) $input_line[3];
    unset($input_line[3]);
    // input_lineを昇順に並び替え
    sort($input_line);
    // 一つ目の要素
    $first_input = (int) $input_line[0];
    $second_input = (int) $input_line[1];
    $third_input = (int) $input_line[2];
    $ans = array();
    for ($i = 1; count($ans) < 1000; $i++) {
        if ($i = 1) {
            $ans[] = 1;
        } else {
            $n = $i;
            while ($n % $first_input !== 0) {
                $n = $n / $first_input;
                if ($n === 1) {
                    $ans[] = $i;
                    continue 2;
                }
            }
            while ($n % $second_input !== 0) {
                $n = $n / $second_input;
                if ($n === 1) {
                    $ans[] = $i;
                    continue 2;
                }
            }
            while ($n % $third_input !== 0) {
                $n = $n / $third_input;
                if ($n === 1) {
                    $ans[] = $i;
                    continue;
                }
            }
        }
    }
    echo $ans[$k - 1];
?>
