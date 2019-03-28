<?php
    $input_line = fgets(STDIN);
    // 検証するすべての日数
    $all_days = (int) $input_line;
    $input = fgets(STDIN);
    // 各日にちのパラメータを取得
    $input_days = explode(' ', $input);
    // $ans_days:続いた日数を格納する。$tmp_days:検証している7日間を抜き出し格納、
    // $sum:検証中に条件を満たした状態が続いている日数を格納、$flag:条件を満たしている状態にいる場合はtrue、そうでない場合はfalse
    $ans_days = array();
    $tmp_days = array();
    $sum = 0;
    $flag = false;
    // 検証する日を、7日区切りで初日から最終日まで動かす
    for ($i = 0; $i <= ($all_days - 7); $i++) {
      // 最初の7日間なのかで条件分岐
        if (count($tmp_days) === 0) {
            // 検証する7日間の抜き出し
            for ($h = 0; $h < 7; $h++) {
                $tmp_days[] = (int) $input_days[$h];
            }
            // 検証中の7日間を合算すると平日：1、休み：0なので、
            // 週休二日以上の場合は7日合計5以下となる
            $number = array_sum($tmp_days);
            // 最後の要素を見ているのか、続いて検証するのかを分岐
            if ($i === ($all_days - 7)) {
                if ($number <= 5) {
                    $ans_days[] = 7;
                }
            } else {
                    if ($number <= 5) {
                      // 週休二日であった場合、条件を満たした7日を$sumに格納し、$flagをtrueへ
                        $sum = 7;
                        $flag = true;
                    }
                }
        } else {
          // ここからは初日から7日後以降の検証
            // 前回のループで検証していた最終日の次の日を$dayで取得
            $plus = $i + 6;
            $day = (int) $input_days[$plus];
            // 前回のループで検証した最初の1日を取得すると同時に今回検証する7日間から除外
            $first = array_shift($tmp_days);
            // 抜き出した$firstと検証する7日間に追加する$dayの差を$gapに
            $gap = $day - $first;
            // 前回のループで週休2日か検証した数値を保持する$numberに$gapを反映
            $number = $number + $gap;
            // 新しく検証する1日を追加し、新たに検証すべき7日間を$tmp_daysに保持
            $tmp_days[] = $day;
            if ($number <= 5) {
              // 以下、上記26から36行目と同義。$flagで分岐し、新たに条件を満たした場合には$sumに7を
              // 続けて条件を満たしている場合には$sumに新しく検証した1日を追加
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
              // 条件を満たさなかった場合、もし前回のループまで条件を満たしていたならば、
              // $sumに7以上の日数を保持しているので$ans_daysに格納。$flagと$sumを初期値に
                if ($flag === true) {
                    $ans_days[] = $sum;
                    $flag = false;
                    $sum = 0;
                }
            }
        }
    }
    // 出力
    if (count($ans_days) === 0) {
        echo 0;
    } else {
        echo max($ans_days);
    }
?>
