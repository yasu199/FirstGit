<?php
    $input_lines = fgets(STDIN);
    $input_lines = explode(' ', $input_lines);
    // 線の長さ
    $l_length = (int) $input_lines[0];
    // 線の本数
    $n_number = (int) $input_lines[1];
    // 横線の本数
    $m_number = (int) $input_lines[2];

    // 横線の情報を取得
    // 形式：(ai, bi, ci)　横へ延びる線が右方向に出ている縦線を主線、左方向に出ている縦線を複線としたとき、
    // ai:主線、bi:横線が出ている主線の位置、ci:横線がたどり着く複線の位置を示す
    while ($input = trim(fgets(STDIN))) {
        $data_line[] = $input;
    }
    foreach ($data_line as $value) {
        $data[] = explode(' ', $value);
    }
    // 各線のデータ配列を作成((1本目の配列),(2本目の配列),...(n本目の配列))
    // 各線の配列の中身(ステータス0 or 1,主線の地点x、複線の地点y)
    $line_data = array();
    // 一本目の縦線からn本目の縦線まで
    for ($i = 1; $i <= $n_number; $i++) {
        // 各縦線の情報を配列として作成
        $inside_line_data = array();
        foreach ($data as $value) {
            // 主線は何本目?
            $m_start_line = (int) $value[0];
            // 主線のどの位置から横線が出てる?
            $m_start_point = (int) $value[1];
            // 複線のどの位置に着地?
            $m_arrive_point = (int) $value[2];
            // for文で回している縦線が主線であったとき【ステータス:0】
            if ($i === $m_start_line) {
                $inside_line_data[] = array(0, $m_start_point, $m_arrive_point);
            }
            // 複線であったとき【ステータス:1】
            if (($i - 1) === $m_start_line) {
                $inside_line_data[] = array(1, $m_start_point, $m_arrive_point);
            }
        }
        // 並び替え
        // foreach ($inside_line_data as $key => $value) {
        //     $sort[$key] = $value[1];
        // }
        // array_multisort($sort, SORT_ASC, $inside_line_data);

        // 各縦線の情報を配列に入れておく
        $line_data[] = $inside_line_data;
    }
    // 着地地点を保持するための箱を作る
    $arrive_point = array();
  // 　スタートする縦線を1本目からn本目まで動かす
    for ($i = 0; $i < $n_number; $i++) {
        // 初期値：縦線の上から1の部分からスタート
        $point = 1;
        // 確認する縦線
        $h = $i;
        // 縦方向について、ゴール方向に位置を移動
        for ($n = $point; $n <= $l_length; $n++) {
          // 今いる縦線の情報を取得
            $now_line = $line_data[$h];
            // 今いる縦線について、情報処理
            foreach ($now_line as $value) {
           // ステータス情報を取得
                $status = $value[0];
                // 主線、複線の横線が伸びている位置を取得
                $line_start_point = $value[1];
                $line_arrive_point = $value[2];
                // 主線であり、かつ、縦方向の位置が横線の右方向に伸びている始点の位置と同じとき
                // 縦線を一つ右（複線）に動かし、縦方向の位置を複線の到着位置に変更
                if ($n === $line_start_point && $status === 0) {
                    $h++;
                    $n = $line_arrive_point;
                    break;
                }
                // 複線であり、かつ、縦方向の位置が横線の右方向に伸びている終点の位置と同じとき
                // 縦線を一つ左（主線）に動かし、縦方向の位置を主線の出発位置に変更
                if ($n === $line_arrive_point && $status === 1) {
                    $h--;
                    $n = $line_start_point;
                    break;
                }
            }
        }
        // あみだのゴールに到着したとき、到着した場所を配列に格納
        $arrive_point[] = $h + 1;
    }
    // ゴール地点が1本目のあみだのとき、スタートした縦線を出力
    foreach($arrive_point as $key => $value) {
        if ($value === 1) {
            $key = $key + 1;
            echo $key . "\n";
        }
    }
?>
