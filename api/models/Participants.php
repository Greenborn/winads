<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participants".
 *
 * @property int $id
 * @property string $fecha_hora
 * @property string $usuario
 * @property int $numero
 * @property string $id_usuario
 * @property string $ref_historia
 */
class Participants extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          //  [['fecha_hora', 'usuario', 'numero', 'id_usuario', 'ref_historia'], 'required'],
            [['fecha_hora'], 'safe'],
            [['usuario', 'id_usuario', 'ref_historia'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_hora' => 'Fecha Hora',
            'usuario' => 'Usuario',
            'numeros' => 'Numero',
            'id_usuario' => 'Id Usuario',
            'ref_historia' => 'Ref Historia',
        ];
    }
}
