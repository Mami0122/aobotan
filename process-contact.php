<?php
session_start();

$errors = [];

if(!isset($_POST['token']) || $_SESSION['token'] !== $_POST['token'] ){
  $errors[] = 'お問い合わせの送信に失敗しました。';
}

function e(string $str, string $charset = 'UTF-8'): string{
  return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, $charset, false);
}

// ラジオボタンが選択されているかの確認
if (!isset($_POST['fld_inquiry'])) {
  $errors[] = 'お問い合わせの種類を選択してください。';
} else {
  $_SESSION['fld_inquiry'] = e(trim($_POST['fld_inquiry']));

  // 日本語チェック
  if (preg_match('/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u', $_SESSION['fld_inquiry'])) {
    $fld_inquiry = $_SESSION['fld_inquiry'];
  }else{
    $errors[] = 'お問い合わせの種類は日本語で入力してください。';
  }
}

//チェックボックスが選択されているかの確認
if (!isset($_POST['fld_confirm'])) {
  $errors[] = '入力内容の確認チェックボックスにチェックを入れてください。';
}

foreach($_POST as $key => $value){
  if(strpos($key, 'fld_') === 0 && $key !== 'fld_inquiry' && $key !== 'fld_confirm'){
    $_SESSION[$key] = e(trim($value));
    $value = $_SESSION[$key];

    if($key == 'fld_inquiry'){
      if(empty($value)){
        $errors[] = 'お問い合わせの種類を選択してください。';
      }elseif(preg_match('/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u', $value)){
        $$key = $value;
      }else{
          $errors[] = '姓は日本語で入力してください。';
      }
    }elseif($key == 'fld_familyName'){
      if(empty($value)){
        $errors[] = '苗字を入力してください。';
      }elseif(preg_match('/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u', $value)){
        $$key = $value;
      }else{
          $errors[] = '姓は日本語で入力してください。';
      }
    }elseif($key === 'fld_givenName'){
      if(empty($value)){
        $errors[] = 'お名前を入力してください。';
      }elseif(preg_match('/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u', $value)){
        $$key = $value;
      }else{
          $errors[] = '名は日本語で入力してください。';
      }
    }elseif($key === 'fld_email'){
      if (empty($value)){
        $errors[] = 'メールアドレスを入力してください。';
      } else{
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
          $$key = $value;
        }else{
          $errors[] = 'メールアドレスの形式が正しくありません。';
        }
      }
    }elseif($key === 'fld_tel'){
      if(empty($value)){
        $errors[] = '電話番号を入力してください。';
      }elseif(preg_match('/^0[0-9]{1,4}-?[0-9]{1,4}-?[0-9]{4}\z/', $value)){
        $$key = $value;
      }
      else{
        $errors[] = '電話番号の形式が正しくありません。';
      }
    }elseif($key === 'fld_address'){
      if(empty($value)){
        // 入力必須ではないので何もしない
      }elseif(preg_match('/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u', $value)){
        $$key = $value;
      }else{
          $errors[] = '住所は日本語で入力してください。';
      }
    }
  }
}

// バリデーションでエラーが有ったらリダイレクト
if($errors){
  $_SESSION['errors'] = $errors;

  header('Location: ./contact.php');
  exit();  
}

mb_language("uni"); 
mb_internal_encoding("UTF-8"); // 文字エンコーディングをUTF-8に設定


// 管理者宛のメール送信
$admin_email = "mimitoume0122@gmail.com";
$admin_subject = "青牡丹工務店ウェブサイトよりお問い合わせがありました。";

$admin_message =  "";
$admin_message .= "お問い合わせの種類：{$fld_inquiry}\r\n";
$admin_message .= "お名前：{$fld_familyName}　{$fld_givenName}\r\n";
$admin_message .= "メールアドレス：{$fld_email}\r\n";
$admin_message .= "電話番号：{$fld_tel}\r\n";
$admin_message .= "住所：{$fld_address}\r\n";

$admin_headers = "From:" . mb_encode_mimeheader('青牡丹工務店','UTF-8'). "<{$admin_email}>\r\n";
$admin_headers .= "Reply-To:{$admin_email}\r\n";
$admin_headers .= "Content-Type:text/plain; charset=UTF-8\r\n";
$admin_headers .= "Content-Transfer-Encoding: 8bit";


if(mb_send_mail($admin_email, $admin_subject, $admin_message, $admin_headers)){

  // 問い合わせ者宛の自動返信
  $to = $fld_email;
  $subject = "【青牡丹工務店】お問い合わせ有り難うございます";
  $message = "{$fld_familyName}　{$fld_givenName}様\r\n\r\n";
  $message .= "※こちらのメールは自動返信メールになります。\r\n\r\n";
  $message .= "この度は青牡丹工務店へお問い合わせいただき、誠に有り難うございます。\r\n\r\n";
  $message .= "担当者より2営業日以内に別途、メールにてご連絡させていただきます。\r\n\r\n";
  $message .= "よろしくお願いいたします。\r\n";

  $headers = "From:" . mb_encode_mimeheader('青牡丹工務店','UTF-8'). "<{$admin_email}>\r\n";
  $headers .= "Reply-To:{$admin_email}\r\n";
  $headers .= "Content-Type:text/plain;charset=UTF-8\r\n";
  $headers .= "Content-Transfer-Encoding:8bit";
  $mail_check = mb_send_mail($to, $subject, $message, $headers);

  if($mail_check){
    unset($_SESSION);
  }
  header('Location: ./thanks.php');
  exit();

} else {
  $_SESSION['errors'][] = "お問い合わせの送信に失敗しました。\n恐れいりますがもう一度お試しいただきますようお願いいたします。";
  header('Location: ./contact.php');
}