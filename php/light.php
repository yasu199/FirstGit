<?php
    $input_lines = fgets(STDIN);
    $input_lines = explode(' ', $input_lines);
    // 高さ
    $h_all = (int) $input_lines[0];
    $w_all = (int) $input_lines[1];
    // 様子内
    while ($data = trim(fgets(STDIN))) {
        $data_line[] = $data;
    }
    foreach ($data_line as $value) {
        $inline_data[] = str_split($value);
    }
    foreach ($inline_data as $value) {
        $box_data[] = $value;
    }
    for ($i = 0; $i < $h_all; $i++) {
        $box_count_inside = array();
        for ($h = 0; $h < $w_all; $h++) {
            $box_count_inside[] = 0;
        }
        $box_count[] = $box_count_inside;
    }
    // 方向について関数
    function to_right($i,$h,$data) {
        if ($data === "\\") {
            $h++;
            $i--;
            $return = array($i, $h, '下');
        } elseif ($data === '/') {
            $h--;
            $i--;
            $return = array($i, $h, '上');
        } else {
            $return = array($i, $h, '右');
        }
        return $return;
    }
    function to_left($i, $h, $data) {
        if ($data === "\\") {
            $h--;
            $i--;
            $return = array($i, $h, '上');
        } elseif ($data === '/') {
            $h++;
            $i--;
            $return = array($i, $h, '下');
        } else {
            $i = $i - 2;
            $return = array($i, $h, '左');
        }
        return $return;
    }
    function to_upside($i, $h, $data) {
        if ($data === "\\") {
            $i = $i - 2;
            $return = array($i, $h, '左');
        } elseif ($data === '/') {
            $return = array($i, $h, '右');
        } else {
            $h--;
            $i--;
            $return = array($i, $h, '上');
        }
        return $return;
    }
    function to_downside($i, $h, $data) {
        if ($data === "\\") {
            $return = array($i, $h, '右');
        } elseif ($data === '/') {
            $i = $i - 2;
            $return = array($i, $h, '左');
        } else {
            $h++;
            $i--;
            $return = array($i, $h, '下');
        }
        return $return;
    }
    // 初期値設定
    $flag = '右';
    $h = 0;
    for ($i = 0; $i < $w_all; $i++) {
        $box_count[$h][$i] = $box_count[$h][$i] + 1;
        // 右のとき
        if ($flag === '右') {
            $light_data = to_right($i, $h, $box_data[$h][$i]);
            $i = $light_data[0];
            $h = $light_data[1];
            $flag = $light_data[2];
        } elseif ($flag === '左') {
            // 左のとき
            $light_data = to_left($i, $h, $box_data[$h][$i]);
            $i = $light_data[0];
            $h = $light_data[1];
            $flag = $light_data[2];
        } elseif ($flag === '上') {
            // 上のとき
            $light_data = to_upside($i, $h, $box_data[$h][$i]);
            $i = $light_data[0];
            $h = $light_data[1];
            $flag = $light_data[2];
        } else {
            // 下のとき
            $light_data = to_downside($i, $h, $box_data[$h][$i]);
            $i = $light_data[0];
            $h = $light_data[1];
            $flag = $light_data[2];
        }
        if ($h < 0 || $h >= $h_all) {
            break;
        }
        if ($i < -1) {
            break;
        }
    }
    $sum = 0;
    foreach ($box_count as $value) {
        $sum = $sum + array_sum($value);
    }
    echo $sum;
?>
