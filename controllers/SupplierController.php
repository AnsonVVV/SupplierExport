<?php

namespace app\controllers;

use app\models\Supplier;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\web\Controller;

class SupplierController extends Controller
{
    public function actionIndex()
    {
        $gridViewConfig = $this->getGridViewConfig();
        $assign = [
            'gridViewConfig' => $gridViewConfig,
            'total' => $gridViewConfig['dataProvider']->getTotalCount(),
        ];

        return $this->render('index', $assign);
    }

    public function actionExport()
    {
        $params = Yii::$app->request->get();
        $params['columns'] = explode(",", $params['columns']);
        $ids = explode(",", $params['keys']);
        $model_keys = ['id', 'name', 'code', 't_status'];
        //获取交集，过滤无效字段
        $params['columns'] = array_intersect($model_keys, $params['columns']);
        $order = $params['sort'];
        $sort = 'asc';
        if (substr($order, 0, 1) == "-") {
            $sort = 'desc';
            $order = substr($order, 1);
        }
        if (!in_array($order, $model_keys)) {
            $order = 'id';
        }
        $model = new Supplier();
        $labels = $model->attributeLabels();

        $list = $model->find()->select($params['columns'])->where(['in', 'id', $ids])->orderBy($order . " " . $sort)->asArray()->all();

        $rows = [];
        $headers = [];
        foreach ($params['columns'] as $v) {
            $headers[] = '"'.$labels[$v].'"';
        }
        $rows[] = implode(",",$headers);
        foreach ($list as $v){
            foreach ($v as $key=>$item){
                $v[$key] = '"'.$item.'"';
            }
            $rows[] = implode(",",$v);
        }
        header('Content-Encoding: UTF-8');
        header("Content-Type: text/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename=Supplier_Export_".date(Ymd).".csv");
        echo implode("\r\n",$rows);
    }

    /**
     * 组织GridView Config
     * @return array
     */
    private function getGridViewConfig()
    {
        $model = new Supplier();
        $query = $model->find()->select(['id', 'name', 'code', 't_status']);
        $query = $model->combConditionForGridView($query, Yii::$app->request->get());
        $gridViewConfig = [
            'dataProvider' => $this->getDataProvider($query),
            'filterModel' => $model,
            'showFooter' => true,//是否显示tfoot
            'placeFooterAfterBody' => true,
//            'layout' => $this->getLayout(),
            'options' => [
                'class' => 'grid-view',
                'id' => 'grid-view'
            ],
            'columns' => $this->getColumnConfig($model),
        ];

        return $gridViewConfig;
    }


    private function getLayout()
    {
        return "{summary}\n{pager}\n{items}\n{summary}\n{pager}";
    }


    private function getDataProvider($query, $pageSize = 10)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
        return $dataProvider;
    }


    private function getColumnConfig($model)
    {
        return [
            [
                'class' => CheckboxColumn::className(),
                'name' => 'export_id',
                'headerOptions' => ['width' => '30'],
                'footerOptions' => ['colspan' => 5],
                'footer' => Html::a('Export to CSV', 'javascript:void(0);', [
                        'id' => 'export',
                        'data-toggle' => 'modal',
                        'data-target' => '#export-modal',
                        'class' => 'btn btn-success ',
                    ]) . "<span class='seleted_tips tips nothing'>You have not selected any data yet.</span>",
            ],
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '150', 'style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'footerOptions' => ['class' => 'hide'],
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Example:<10'
                ],
            ],
            [
                'attribute' => 'name',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'footerOptions' => ['class' => 'hide'],
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Search Name...'
                ],
            ],
            [
                'attribute' => 'code',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'footerOptions' => ['class' => 'hide'],
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Search Code...'
                ],
            ],
            [
                'attribute' => 't_status',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'footerOptions' => ['class' => 'hide'],
                'filter' => ['ok' => 'ok', 'hold' => 'hold'],
                'filterInputOptions' => ['class' => 'form-control', 'prompt' => 'all']
            ],
        ];
    }

}
