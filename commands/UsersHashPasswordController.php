<?php

namespace app\commands;

use app\models\Usuario;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Transaction;

/**
 * Hash password all users. Check if hash password is invalid and process
 * @author Julian Murphy
 */
class UsersHashPasswordController extends Controller
{
    public function actionIndex()
    {
            echo "Initialize command \n";
            $batchSize = 100;
            echo "Batch size $batchSize \n";

            $totalUsers = Usuario::find()->count();
            $totalBatches = ceil($totalUsers / $batchSize);
            
            $transaction = \Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {
                $userProcessed = 0;
                for ($i = 0; $i < $totalBatches; $i++) {
                    $users = Usuario::find()
                        ->limit($batchSize)
                        ->offset($i * $batchSize)
                        ->all();

                    foreach ($users as $user) {
                        if (password_needs_rehash($user->clave, PASSWORD_BCRYPT, ['cost' => 13])) {
                            $user->clave = $user->clave;
                            $user->save(false);

                            $userProcessed++;
                            echo "Processed user: $user->nombreUsuario (ID: $user->id).\n";
                        }
                    }

                }

                $transaction->commit();
                echo "Finish - processed: $userProcessed. \n";
                return ExitCode::OK;

            } catch (\Exception $e) {
                $transaction->rollBack();
                echo "Error to hash password: " . $e->getMessage() . "\n";
                return ExitCode::UNSPECIFIED_ERROR;
            }

    }
}
