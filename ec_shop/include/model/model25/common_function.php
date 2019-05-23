<?php

// データベース処理系統
// * DBハンドルを取得
function get_db_connect() {
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }
    mysqli_set_charset($link, DB_CHARACTER_SET);

    return $link;
}

// insert実行
function insert_db($link, $sql) {
   if (mysqli_query($link, $sql) === TRUE) {
       return TRUE;
   } else {
       return FALSE;
   }
}

// updateの実行
function update_db($link, $sql) {
    if (mysqli_query($link, $sql) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// 削除の実行
function delete_db($link, $sql) {
    if (mysqli_query($link, $sql) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// * DBとのコネクション切断
function close_db_connect($link) {
    mysqli_close($link);
}

// クエリ実行ののち、配列を取得
function get_as_array($link, $sql) {
    $data = array();

    if ($result = mysqli_query($link, $sql)) {

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        mysqli_free_result($result);
    }
    return $data;
}

// ====================================================================
// post、getなどの基本処理

// * リクエストメソッドを取得
function get_request_method() {
   return $_SERVER['REQUEST_METHOD'];
}

// getメソッドでデータを取得
function get_get_data($key) {
    $str = '';
    if (isset($_GET[$key]) === TRUE) {
      $str = $_GET[$key];
    }
    return $str;
}


// * POSTデータを取得
function get_post_data($key) {
    $str = '';
    if (isset($_POST[$key]) === TRUE) {
       $str = $_POST[$key];
   }
   return $str;
}

// ファイルデータ確認(img処理)
function get_file_data($key) {
    $file = '';
    if (isset($_FILES[$key]) === TRUE) {
        $file = $_FILES[$key];
    }
    return $file;
}

//  分岐判断-formが複数の場合に判別するため
function get_post_route($key) {
    $str = FALSE;
    if (isset($_POST[$key]) === TRUE) {
       $str = TRUE;
   }
   return $str;
}

// ログイン関係/セッション関係
// セッション変数取得
function get_session_data($key) {
    $str = '';
    if (isset($_POST[$key]) === TRUE) {
       $str = $_POST[$key];
   }
   return $str;
}

// ログイン確認
function check_login($user_id, $home_page) {
    if (isset($_SESSION[$user_id]) === TRUE) {
        header('Location: ' . $home_page);
        exit;
    }
}

// セッション変数からログインエラーフラグ確認
function check_login_err_flag($login_err_flag) {
    if (isset($_SESSION[$login_err_flag]) === TRUE) {
        $flag = $_SESSION[$login_err_flag];
        $_SESSION[$login_err_flag] = FALSE;
    } else {
        $flag = FALSE;
    }
    return $flag;
}

// ログインページにて、ログイン確認
function login_check($calam, $url) {
    if (isset($_SESSION[$calam]) === TRUE) {
        $value = $_SESSION[$calam];
    } else {
        header('Location: ' . $url);
        exit;
    }
    return $value;
}
// データが取得できたか確認
function check_get_user($data, $user_id, $user_name, $enter, $out) {
    if (isset($data[0][$user_id]) && isset($data[0][$user_name])) {
        $_SESSION[$user_id] = $data[0][$user_id];
        $_SESSION[$user_name] = $data[0][$user_name];
        header('Location: ' . $enter);
        exit;
    } else {
        $_SESSION['login_err_flag'] = TRUE;
        header('Location: ' . $out);
        exit;
    }
}
// データが取得できたか確認ショップ
function check_get_user_shop($data, $user_id, $enter, $out) {
    if (isset($data[0][$user_id])) {
        $_SESSION[$user_id] = $data[0][$user_id];
        header('Location: ' . $enter);
        exit;
    } else {
        $_SESSION['login_err_flag'] = TRUE;
        header('Location: ' . $out);
        exit;
    }
}

// ログアウト処理
function session_logout() {
    $session_name = session_name();
    $_SESSION = array();
    if (isset($_COOKIE[$session_name])) {
        $params = session_get_cookie_params();
        setcookie($session_name, '', time() - 42000, 
          $params["path"], $params["domain"], 
          $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

// headerとばす
function header_other_page($url) {
    header('Location: ' . $url);
    exit;
}
// ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
// 特殊文字エンティティ
function entity_str($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}
// 飛ばす
function header_link($url) {
    header('Location: ' . $url);
}