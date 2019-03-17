<?php
    $input_lines = fgets(STDIN);
    $input_lines = explode(' ', $input_lines);
    // 線の長さ
    $l_length = (int) $input_lines[0];
    // 線の本数
    $n_number = (int) $input_lines[1];
    // 横線の本数
    $m_number = (int) $input_lines[2];

    // 横線の条件を取得
    // 形式：(ai, bi, ci)
    while ($input = trim(fgets(STDIN))) {
        $data_line[] = $input;
    }
    foreach ($data_line as $value) {
        $data[] = explode(' ', $value);
    }
    // 各線のデータ配列を作成((1),(2),...(n))
    // 中身(ステータス0 or 1,地点x)
    $line_data = array();
    for ($i = 1; $i <= $n_number; $i++) {
        // 中身のarray
        $inside_line_data = array();
        foreach ($data as $value) {
            // 何本目から右に出てる?
            $m_start_line = (int) $value[0];
            // 何センチから出てる?
            $m_start_point = (int) $value[1];
            // 右のラインのどこに着地?
            $m_arrive_point = (int) $value[2];
            // 出てるパターンのとき【ステータス:0】
            if ($i === $m_start_line) {
                $inside_line_data[] = array(0, $m_start_point, $m_arrive_point);
            }
            // 来てるパターンのとき【ステータス:1】
            if (($i - 1) === $m_start_line) {
                $inside_line_data[] = array(1, $m_start_point, $m_arrive_point);
            }
        }
        // 並び替え
        // foreach ($inside_line_data as $key => $value) {
        //     $sort[$key] = $value[1];
        // }
        // array_multisort($sort, SORT_ASC, $inside_line_data);
        $line_data[] = $inside_line_data;
    }
    // 着地地点
    $arrive_point = array();
    for ($i = 0; $i < $n_number; $i++) {
        // 初期値
        $point = 1;
        // 確認するライン
        $h = $i;
        for ($n = $point; $n <= $l_length; $n++) {
            $now_line = $line_data[$h];
            foreach ($now_line as $value) {
                // ステータス
                $status = $value[0];
                // 場所
                $line_start_point = $value[1];
                $line_arrive_point = $value[2];
                if ($n === $line_start_point && $status === 0) {
                    $h++;
                    $n = $line_arrive_point;
                    break;
                }
                if ($n === $line_arrive_point && $status === 1) {
                    $h--;
                    $n = $line_start_point;
                    break;
                }
            }
        }
        $arrive_point[] = $h + 1;
    }
    foreach($arrive_point as $key => $value) {
        if ($value === 1) {
            $key = $key + 1;
            echo $key . "\n";
        }
    }
?>
