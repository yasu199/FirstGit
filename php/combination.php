<?php
    $input_line = fgets(STDIN);
    $input_line = explode(' ', $input_line);
    $n = (int) $input_line[0];
    $k = (int) $input_line[1];
    // 総アイテムを格納する配列
    for ($i = 1; $i <= (2 * $n); $i++) {
        $n_all[] = $i;
    }
    // 再起呼び出しにより、組み合わせの配列をすべて列挙
    // origin:元の配列,n:総アイテム数,subset:結果を入れていく配列,begin:for文の開始位置,end:for文の終了位置
    // 配列で入力してある左の数字から固定しておいて、一番最後に選ぶ数字をうごかしていく。
    // 一番最後に来る数字がすべて検証し切れたら、最後から一つ左の数字が1加算され、同様のこと
    // それを一番左の数字に来るまで再帰呼び出しで実行
    function roll($origin, $n, $subset, $begin, $end) {
        $p = array();
        for ($i = $begin; $i < $end; $i++) {
            $tmp = array_merge($subset, (array)$origin[$i]);
            if ($end + 1 <= $n) {
                $p = array_merge($p, roll($origin, $n, $tmp, $i + 1, $end + 1));
            } else {
                array_push($p, $tmp);
            }
        }
        return $p;
    }
    // 結果を入れる配列
    $result = array();
    $result = roll($n_all, 2 * $n, array(), 0, $n + 1);
    // 結果数
    $result_number = count($result);
    // // 絶対値を取得,答えに合う組み合わせの数をansに格納
    $ans = 0;
    for ($i = 0; $i < ($result_number / 2); $i++) {
        // 検証配列を取得
        // A君が持ってる値
        $a_have = $result[$i];
        // B君が持ってる値
        $b_have = $result[$result_number - 1 - $i];
        // 絶対値を加算
        $sum_result = 0;
        for ($h = 0; $h < $n; $h++) {
            $a_sum = $a_have[$h];
            $b_sum = $b_have[$h];
            $ab_sum = abs($a_sum - $b_sum);
            $sum_result = $sum_result + $ab_sum;
        }
        // 値について、条件に合うか検討。合えばansに格納
        if ($sum_result <= $k) {
            $ans++;
        }
    }
    echo $ans * 2;
?>
