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

        //se obtiene el primer dia de la semana
        $inicio_semana = self::getInicioSemana();
        
        //se verifica si tiene ya el mismo numero asignado
        $numbers = Participants::find()
            ->where(['usuario' => $arr_u[0] ])
            ->andWhere(['>','fecha_hora',$inicio_semana])
            ->andWhere(['ref_historia'=>$arr[2]])->all();
            
        //de ser asì se retorna el mismo para hacer control y que el bot pueda registrarlo en la salida
        if (count($numbers) > 0){
            return $numbers[0]->usuario.':'.$numbers[0]->numero.'|'.$numbers[0]->id_usuario.'|'.$numbers[0]->ref_historia.'|'.'participante_ya_resgistrado';
        }

        //Se obtiene el nuevo numero del sorteo
        $numbers = Participants::find() //se obtienen todos los registros posteriores a la fecha indicada, si no existe el num sera 0, caso contrario el numero sera la cantidad de elementos + 1
            ->where(['>','fecha_hora',$inicio_semana])->all();
                
        $participant = new Participants();
        $participant->string_completo = $s;
        $participant->fecha_hora      = date("Y-m-d H:i:s");
        $participant->id_usuario      = $arr[1];
        $participant->ref_historia    = $arr[2];
        $participant->usuario         = $arr_u[0];
        $participant->numero          = count($numbers)+1;

        if ($participant->save(false)){
            return  $participant->usuario.':'.$participant->numero.'|'.$participant->id_usuario.'|'.$participant->ref_historia.'|'.'numero_adjudicado';
        }
        return 'participante_no_guardado';
    }

}
