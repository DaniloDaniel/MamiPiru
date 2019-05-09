<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property int $id
 * @property string $nombre
 * @property int $stock
 * @property string $detalle
 * @property int $activo
 * @property int $categoria
 * @property string $imagen
 *
 * @property Categoria $categoria0
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'stock', 'detalle', 'activo', 'categoria', 'imagen'], 'required'],
            [['stock', 'activo', 'categoria'], 'integer'],
            [['nombre'], 'string', 'max' => 20],
            [['detalle', 'imagen'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'stock' => Yii::t('app', 'Stock'),
            'detalle' => Yii::t('app', 'Detalle'),
            'activo' => Yii::t('app', 'Activo'),
            'categoria' => Yii::t('app', 'Categoria'),
            'imagen' => Yii::t('app', 'Imagen'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria0()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria']);
    }
}
