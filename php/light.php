<?php
    $input_lines = fgets(STDIN);
    $input_lines = explode(' ', $input_lines);
    // 光が入るボックスの高さ
    $h_all = (int) $input_lines[0];
    // 光が入るボックスの横幅
    $w_all = (int) $input_lines[1];
    // ボックス内部の情報を取得
    while ($data = trim(fgets(STDIN))) {
        $data_line[] = $data;
    }
    foreach ($data_line as $value) {
        $box_data[] = str_split($value);
    }
    // ボックス内をブロックごとの行列にして、初期値をすべて0回通過とする
    for ($i = 0; $i < $h_all; $i++) {
        $box_count_inside = array();
        for ($h = 0; $h < $w_all; $h++) {
            $box_count_inside[] = 0;
        }
        $box_count[] = $box_count_inside;
    }
    // 光の来る方向について、行くブロック、光の進行方向を関数で規定
    function to_right($i,$h,$data) {
        if ($data === "\\") {
            $h++;
            $i--;
            $return = array($i, $h, 'down');
        } elseif ($data === '/') {
            $h--;
            $i--;
            $return = array($i, $h, 'up');
        } else {
            $return = array($i, $h, 'right');
        }
        return $return;
    }
    function to_left($i, $h, $data) {
        if ($data === "\\") {
            $h--;
            $i--;
            $return = array($i, $h, 'up');
        } elseif ($data === '/') {
            $h++;
            $i--;
            $return = array($i, $h, 'down');
        } else {
            $i = $i - 2;
            $return = array($i, $h, 'left');
        }
        return $return;
    }
    function to_upside($i, $h, $data) {
        if ($data === "\\") {
            $i = $i - 2;
            $return = array($i, $h, 'left');
        } elseif ($data === '/') {
            $return = array($i, $h, 'right');
        } else {
            $h--;
            $i--;
            $return = array($i, $h, 'up');
        }
        return $return;
    }
    function to_downside($i, $h, $data) {
        if ($data === "\\") {
            $return = array($i, $h, 'right');
        } elseif ($data === '/') {
            $i = $i - 2;
            $return = array($i, $h, 'left');
        } else {
            $h++;
            $i--;
            $return = array($i, $h, 'down');
        }
        return $return;
    }
    // 光の入力について初期値設定
    $flag = 'right';
    $h = 0;
    // 光を入力させた後の処理。まずは横方向の動きを、右に進むと仮定してボックス内のブロックを移動させる
    // 以下において、$i:ボックス内の横方向の位置、$h:ボックス内の縦方向の位置
    for ($i = 0; $i < $w_all; $i++) {
      // 光の通っているブロックについて、通過回数を+1
        $box_count[$h][$i] = $box_count[$h][$i] + 1;
        // 光の進行方向が右のとき
        if ($flag === 'right') {
            $light_data = to_right($i, $h, $box_data[$h][$i]);
            $i = $light_data[0];
            $h = $light_data[1];
            $flag = $light_data[2];
        } elseif ($flag === 'left') {
            // 光の進行方向が左のとき
            $light_data = to_left($i, $h, $box_data[$h][$i]);
            $i = $light_data[0];
            $h = $light_data[1];
            $flag = $light_data[2];
        } elseif ($flag === 'up') {
            // 光の進行方向が上のとき
            $light_data = to_upside($i, $h, $box_data[$h][$i]);
            $i = $light_data[0];
            $h = $light_data[1];
            $flag = $light_data[2];
        } else {
            // 光の進行方向が下のとき
            $light_data = to_downside($i, $h, $box_data[$h][$i]);
            $i = $light_data[0];
            $h = $light_data[1];
            $flag = $light_data[2];
        }
        // 光がボックスの上に抜けた、もしくは下に抜けた場合には処理を終了
        if ($h < 0 || $h >= $h_all) {
            break;
        }
        // 光がボックスの左に抜けた場合には処理を終了
        if ($i < -1) {
            break;
        }
    }
    // 光の通った回数について、各ブロックに格納されている通過回数を合算
    $sum = 0;
    foreach ($box_count as $value) {
        $sum = $sum + array_sum($value);
    }
    // 光の合計通過回数を出力
    echo $sum;
?>
