<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;

class ReportsController extends BaseController
{
    public function actionIndex()
    {
		
//		$dataProvider = new ActiveDataProvider([
//			'query' => Post::find(),
//			'pagination' => [
//				'pageSize' => 20,
//			],
//		]);

		$count = Yii::$app->db->createCommand('Select count(*) from (SELECT substring(code, 1, 2) as model_code
											FROM `cat_models` group by model_code) as a')->queryScalar();

		$sql = 'SELECT substring(code, 1, 2) as model_code, max(name) as name, count(id) as cnt
				FROM `cat_models` group by model_code';
			
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			//    'params' => [':status' => 1],
			'totalCount' => $count,
			'sort' => [
				'attributes' => [
					'model_code',
					'cnt',
					'name' => [
			//                'asc' => ['name_m' => SORT_ASC, 'name_m' => SORT_ASC],
			//                'desc' => ['name_m' => SORT_DESC, 'name_m' => SORT_DESC],
						'default' => SORT_ASC,
			//                'label' => 'sdfds',
					],
				],
			],
			'pagination' => [
				'pageSize' => 40,
			],
		]);		
		return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionPostavki()
    {
		$sqlHead = "SELECT distinct `date_shipping` FROM `dat_imports_plant` WHERE date_shipping LIKE '2015%' ORDER BY date_shipping";
        
		$arrShipDate = Yii::$app->db->createCommand($sqlHead)->queryColumn();
//		return $this->render('/site/debug', ['debug' => $arrShipDate]);
        
        $sql = "SELECT c.id, c.`model_id`, m.name, m.code  FROM cat_cars c, cat_models m  WHERE c.model_id = m.id";

        $sql = "SELECT c.id, c.`model_id`, m.name, m.code, p.* 
        FROM cat_cars c, cat_models m, dat_imports_plant p  
        WHERE c.model_id = m.id AND p.car_id = c.id";
			
        $sql = "SELECT c.id, c.`model_id`, m.name, m.code, p.* 
        FROM cat_cars c, cat_models m, dat_imports_plant p  
        WHERE c.model_id = m.id AND p.car_id = c.id";
        $sqlWhere = '';
        $sqlWhere = ' AND date_shipping in (' . implode(',', $arrShipDate) . ')';
        
        $groupSql = ", SUM(IF(date_shipping = '20150119', 1, NULL)) AS _20150119";
        $groupSql = '';
        
        foreach ($arrShipDate as $shipDate) {
            $prnShipDate = date('M d', strtotime($shipDate));
//            $prnShipDate =Yii::$app->formatter->asDate(strtotime($shipDate), 'd LLL');
            $groupSql .= ", SUM(IF(date_shipping = '{$shipDate}', 1, 0)) AS '{$prnShipDate}' ";
        }
        
        $sql = "SELECT *, mc.name FROM (  
            SELECT substring(code, 1, 2) as model_code, max(name) as 'Модель', count(id) as _'in total' {$groupSql} FROM 
                (SELECT c.id, c.model_id, m.name, m.code, p.date_shipping 
                FROM cat_cars c, cat_models m, dat_imports_plant p
                WHERE c.model_id = m.id AND p.car_id = c.id {$sqlWhere}) as low
            group by model_code ORDER BY name
            ) as hhh
            LEFT JOIN cat_models_base mc ON model_code = code
            UNION ALL
            SELECT '',  'Итого', count(id) {$groupSql} FROM dat_imports_plant WHERE 1=1 {$sqlWhere}
        ";
			
        $sql = "SELECT * FROM (  
            SELECT name as model, count(id) as 'in total' {$groupSql} FROM 
                (SELECT c.id, mc.name, p.date_shipping 
                FROM cat_cars c
                INNER JOIN cat_models m ON c.model_id = m.id
                INNER JOIN dat_imports_plant p ON p.car_id = c.id
                left join cat_models_base mc ON substring(m.code, 1, 2)= mc.code
                WHERE 1=1 {$sqlWhere}) as low
            group by model ORDER BY model
            ) as hhh
            UNION ALL
            SELECT 'in total', count(id) {$groupSql} FROM dat_imports_plant WHERE 1=1 {$sqlWhere}
        ";
			
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => false,
			'pagination' => false,
		]);		
		return $this->render('postavki', ['dataProvider' => $dataProvider, 'reportTitle' => 'Поставки по датам']);
    }

    public function actionSvod()
    {
		$sqlHead = "SELECT distinct `date_shipping` FROM `dat_imports_plant` WHERE date_shipping LIKE '2015%' ORDER BY date_shipping";
        
		$arrShipDate = Yii::$app->db->createCommand($sqlHead)->queryColumn();
        
			
        $sql = "SELECT c.id, c.`model_id`, m.name, m.code, p.* 
        FROM cat_cars c, cat_models m, dat_imports_plant p  
        WHERE c.model_id = m.id AND p.car_id = c.id";
        $sqlWhere = '';
        $sqlWhere = ' AND date_shipping in (' . implode(',', $arrShipDate) . ')';
        
        $groupSql = ", SUM(IF(date_shipping = '20150119', 1, NULL)) AS _20150119";
        $groupSql = '';
        
        foreach ($arrShipDate as $shipDate) {
            $prnShipDate = date('M d', strtotime($shipDate));
//            $prnShipDate =Yii::$app->formatter->asDate(strtotime($shipDate), 'd LLL');
            $groupSql .= ", SUM(IF(date_shipping = '{$shipDate}', 1, 0)) AS '{$prnShipDate}' ";
        }
        
			
        $sql = "SELECT * FROM (  
            SELECT name as model, count(id) as 'in total' {$groupSql} FROM 
                (SELECT c.id, mc.name, p.date_shipping 
                FROM cat_cars c
                INNER JOIN cat_models m ON c.model_id = m.id
                INNER JOIN dat_imports_plant p ON p.car_id = c.id
                left join cat_models_base mc ON substring(m.code, 1, 2)= mc.code
                WHERE 1=1 {$sqlWhere}) as low
            group by model ORDER BY model
            ) as hhh
            UNION ALL
            SELECT 'in total', count(id) {$groupSql} FROM dat_imports_plant WHERE 1=1 {$sqlWhere}
        ";
			
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => false,
			'pagination' => false,
		]);		
		return $this->render('svod', ['dataProvider' => $dataProvider, 'reportTitle' => 'Поставки по датам']);
    }

}
