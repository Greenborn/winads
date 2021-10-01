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
        $participant = Participants::findOne(['usuario' => $nombreUser]);
        
        if ($participant != NULL){
            return explode(',',$participant->numeros );
        }
        
        return [];
    }

}
