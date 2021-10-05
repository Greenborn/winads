<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

use app\models\Participants;
use app\models\User;


class NumbersController extends BaseController {

    public function actionAdd($s, $t){
        header('Content-type: application/json;charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        if (User::findOne(['access_token' => $t]) == Null){
            return false;
        }

        $arr   = explode('|',$s);
        $arr_u = explode(':', $arr[0]);

        //se verifica si tiene ya el mismo numero asignado
        $numbers = Participants::find()
            ->where(['usuario' => $arr_u[0] ])
            ->where(['>','fecha_hora',self::getInicioSemana()])
            ->where(['numero'=>intval($arr_u[1])])->all();

        if (count($numbers) > 0){
            return false;
        }
                
        $participant = new Participants();
        $participant->string_completo = $s;
        $participant->fecha_hora      = date("Y-m-d H:i:s");
        $participant->id_usuario      = $arr[1];
        $participant->ref_historia    = $arr[2];
        $participant->usuario         = $arr_u[0];
        $participant->numero          = intval($arr_u[1]);
        return  $participant->save(false);
    }

}
