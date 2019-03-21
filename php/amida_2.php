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
            // for文で回している縦線が主線であったとき【ステータス:0】縦線の出てる地点をkeyとして保存しておく
            if ($i === $m_start_line) {
                $inside_line_data[$m_start_point] = array(0, $m_arrive_point);
            }
            // 複線であったとき【ステータス:1】縦線の出てる地点をkeyとして保存しておく
            if (($i - 1) === $m_start_line) {
                $inside_line_data[$m_arrive_point] = array(1, $m_start_point);
            }
        }
        // 各縦線の情報を配列に入れておく
        $line_data[] = $inside_line_data;
    }
  // ゴール地点よりスタートする
    $h = 0;
    $now_key_point = '';
    for ($i = ($l_length - 1); $i >= 0; $i--) {
      // 今いる縦線の情報を取得
        $now_line = $line_data[$h];
        // 縦軸方向について、ゴールから出発地点に向かって動かしている点が、横線をとらえているか確認
        if (isset($now_line[$i])) {
            // ステータスを取得
            $status = $now_line[$i][0];
            // 行先
            $arrive_point = $now_line[$i][1];
            // 主線であるとき、縦線を一つ右(複線)に動かし、縦方向の位置を複線の出発位置に変更
            if ($status === 0) {
                $h++;
                $i = $arrive_point;
            }
            // 複線であるとき縦線を一つ左（主線）に動かし、縦方向の位置を主線の出発位置に変更
            if ($status === 1) {
                $h--;
                $i = $arrive_point;
            }
        }
    }
    // スタート地点を出力
    $h = $h + 1;
    echo $h;
?>
