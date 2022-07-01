<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "suppliers".
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string $t_status
 */
class Supplier extends \yii\db\ActiveRecord
{

    public $condition_key = '0';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suppliers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['t_status', 'id', 'condition_key'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 3],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            't_status' => 'T Status',
        ];
    }

    /**
     * 根据提交的参数组合条件
     * @param $query
     * @param $params
     * @return mixed
     */
    public function combConditionForGridView($query, $params)
    {
        $where = ['and'];
        if ($this->load($params)) {
            if (!empty($this->id)) {
                $id = str_replace(" ", "", $this->id);
                //拆分成数组
                $formula = preg_split("/([a-zA-Z0-9]+)/", $id, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
                //拆分不成功直接使用
                if (count($formula) == 1) {
                    $where[] = ["id" => $id];
                } else {
                    //合法运算符
                    $legal = ['=', '>', '<', '!=', '<>', '>=', '<='];
                    if (in_array($formula[0], $legal)) {
                        $where[] = [$formula[0], 'id', $formula[1]];
                    } else {
                        //没有合法运算符，直接使用
                        $where[] = ["id" => $id];
                    }
                }

            }
            if (!empty($this->name)) {
                $where[] = ['LIKE', 'name', trim($this->name)];
            }
            if (!empty($this->code)) {
                $where[] = ['LIKE', 'code', trim($this->code)];
            }
            if (!empty($this->t_status)) {
                $where[] = ["t_status" => trim($this->t_status)];
            }
        }

        return $query->andWhere($where);
    }


}
