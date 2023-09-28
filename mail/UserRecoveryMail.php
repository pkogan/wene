<?php

namespace app\mail;

use app\models\dto\UserMail;
use Yii;

class UserRecoveryMail
{
    public static function send(UserMail $user)
    {
        Yii::$app->mailer->compose()
            ->setFrom('wene@fi.uncoma.edu.ar')
            ->setTo($user->email)
            ->setSubject('Datos para descargar certificados del sistema wene')
            ->setHtmlBody(
                '<p>Estimadx, ' . $user->fullName.
                ', este correo es enviado por el sistema wene (sistema de Certificados). Ingrese al siguiente ' .
                \yii\helpers\Html::a('link', \yii\helpers\Url::base('https') . '/site/login?LoginForm[username]=' .
                $user->username . '&LoginForm[password]=' . $user->plainPassword) .
                ' para descargar y ver el historial de sus certificados. '.'</p>' .
                '<p><b>Para próximos ingresos, su usuario es: ' . $user->username .
                ' y su clave es: '. $user->plainPassword .'</p> <p>Muchas Gracias.</b><p>'
            )
            ->send();
    }
}
