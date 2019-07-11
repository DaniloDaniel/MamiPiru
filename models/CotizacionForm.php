<?php

namespace app\models;

use Yii;
use yii\base\Model;
use Mpdf\Tag\Br;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\helpers\VarDumper;

/**
 * ContactForm is the model behind the contact form.
 */
class CotizacionForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'body'], 'required', 'message' => 'Este campo no puede estar vacío'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Nombre',
            'email' => 'Email',
            'subject' => 'Asunto',
            'body' => 'Mensaje',
            'verifyCode' => 'Codigo de Verificación',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function cotizacion($email)
    {
        if ($this->validate()) {

            $session = Yii::$app->session;
            $carrito = $session['carrito'];

            $ids = array_column($carrito, 'id');

            $body2 = "Cotización a nombre de: ".$this->name."\n";

            $body2 .= PHP_EOL;
            $body2 .= "ID"."\t"."Producto"."\t\t\t"."Stock"."\t"."Cantidad";
            $body2 .= PHP_EOL;
            
            foreach($ids as $id){

                $body2 .= $carrito[$id]['id'];
                $body2 .= "\t";
                $body2 .= $carrito[$id]['nombre'];
                $body2 .= "\t\t\t";
                $body2 .= $carrito[$id]['stock'];
                $body2 .= "\t";
                $body2 .= $carrito[$id]['cantidad'];
                $body2 .= PHP_EOL;
            }

            $body2 .= "\n"."Notas Adicionales:"."\n";
            $body2 .= $this->body;

            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject('Cotización')
                ->setTextBody($body2)
                ->send();
            return true;
        }
        return false;
    }
}
