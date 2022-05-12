<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'phpmailer/src/Exception.php';
  require 'phpmailer/src/PHPMailer.php';

  $mail = new PHPMailer(true);
  $mail->CharSet = 'UTF-8';
  $mail->setLanguage('ru','phpmailer/language/');
  $mail->IsHTML(true);

//От кого письмо
 $mail->setForm('info@fls.guru', 'Yarochyk M K');
 //Кому отпраить
 $mail->addAddress('mishayar123@gmail.com');
 //Тело письма
 $mail->Subject = 'Hello! I am Misha';

 //Рука
 $hand = "Right"
 if($_POST['hand'] == "left"){
     $hand = "Left";
 }

 //Тело письма
 $body = '<h1>Let me introduce!</h1>';

if(trim(!empty($_POST['name']))){
    $body.='<p><strong>Name:</strong>'.$_POST['name'].'</p>';
}
if(trim(!empty($_POST['email']))){
    $body.='<p><strong>E-mail:</strong>'.$_POST['email'].'</p>';
}
if(trim(!empty($_POST['hand']))){
    $body.='<p><strong>Hand:</strong>'.$hand.'</p>';
}
if(trim(!empty($_POST['age']))){
    $body.='<p><strong>Age:</strong>'.$_POST['age'].'</p>';
}
if(trim(!empty($_POST['message']))){
    $body.='<p><strong>Message:</strong>'.$_POST['message'].'</p>';
}

//Прикрепить файл
if (!empty($_FILES['image']['tmp_name'])){
    //Путь к загрузки файла
    $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
    //Грузим файл
    if (copy($_FILES['image']['tmp_name'], $filePath)){
        $fileAttach = $filePath;
        $body.='<p><strong>Photo add</strong></p>';
        $mail->addAttachment($fileAttach);
    }
}

$mail->Body = $body;

//Отправка
if (!$mail->send()){
    $message = 'error';
} else {
    $message = 'Data sent!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
?>