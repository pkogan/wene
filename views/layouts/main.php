<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <link rel="shortcut icon" type="img/png" href="<?= yii\helpers\Url::home();?>img/logocortonegro.png"/>

        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => "<img height='28px' src='".yii\helpers\Url::home()."img/logolargo.png' alt='".Yii::$app->name."'>",
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                        ['label' => 'Inicio', 'url' => ['/site/index']],
                        ['label' => 'Acerca de', 'url' => ['/site/about']],
                        ['label' => 'Mis Certificados', 'url'=>['/certificado/mis'],'visible'=>!Yii::$app->user->isGuest],
                        ['label' => 'Hacedor',
                        'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_HACEDOR,
                        'items' => [
                                ['label' => 'Actividades', 'url' => ['/actividad'],
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_HACEDOR
                            ]
                                
                        ]],
                        ['label' => 'Gestión',
                        'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_GESTOR,
                        'items' => [
                                ['label' => 'Actividades', 'url' => ['/actividad'],
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_GESTOR
                            ],
                            ['label' => 'Personas', 'url' => ['/persona'],
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_GESTOR
                            ],
                            ['label' => 'Certificados', 'url' => ['/certificado'],
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_GESTOR
                            ],
                                
                        ]],
                        ['label' => 'Admin',
                        'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_ADMIN,
                        'items' => [
                                ['label' => 'Usuarios', 'url' => ['/usuario'],
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_ADMIN
                            ],
                                ['label' => 'Dependencias', 'url' => ['/dependencia'],
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_ADMIN
                            ],
                                ['label' => 'Template', 'url' => ['/template'],
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_ADMIN
                            ],
                                ['label' => 'Tipos Certificdos', 'url' => ['/tipo-certificado'],
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == \app\models\Rol::ROL_ADMIN
                            ],
                            
                        ]],
                    //['label' => 'Contact', 'url' => ['/site/contact']],
                    Yii::$app->user->isGuest ? (
                                ['label' => 'Login', 'url' => ['/site/login']]
                            ) : (
                            '<li>'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm()
                            . '</li>'
                            )
                ],
            ]);
            NavBar::end();
            ?>

            <div class="container">
            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])
            ?>
            <?= Alert::widget() ?>
            <?= $content ?>
            </div>
        </div>

        <footer class="footer">

            <div class="container">
                <p class="pull-left">Licencia GPL-3.0  <span class="copyleft"> &copy;</span> Es una bifurcación de Wene - Facultad de Informática - Universidad Nacional del Comahue</p>

                <p class="pull-right"><?= Yii::powered() ?> - Lab. Informática CURZA</p>
            </div>



        </footer>


<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
