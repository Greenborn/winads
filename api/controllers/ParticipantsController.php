<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

use app\models\Participants;



class ParticipantsController extends BaseController {

    public function actionNumbers($nombreUser){
        header('Content-type: application/json;charset=utf-8');
        header('Access-Control-Allow-Origin: *');
                
        $nombreUser = strip_tags($nombreUser);

        $numbers = Participants::find()
            ->where([
                'usuario' => $nombreUser
            ])
            ->where(['>','fecha_hora',self::getInicioSemana()])
            ->orderBy([
                'numero' => SORT_ASC
            ])->all();
            
        return $numbers;
    }

}
