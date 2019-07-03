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
    public $upload; //TUTORIAL

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
            [['stock', 'activo', 'categoria'], 'integer', 'message' => '{attribute} debe ser un número entero', 'min' => 0],
            [['nombre'], 'string', 'max' => 60],
            [['detalle'], 'string', 'max' => 300],
            [['imagen'], 'string', 'max' => 300], // TUTORIAL
            [['upload'], 'file', 'extensions' => 'png, jpg'], //TUTORIAL
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
            'activo' => Yii::t('app', '¿Producto en Catalogo?'),
            'categoria' => Yii::t('app', 'Categoria'),
            'upload' => Yii::t('app', 'Carga imagen'),
            //'imagen' => Yii::t('app', 'Imagen'),
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
