<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\CarStatus;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * CarSearch represents the model behind the search form about `app\models\Car`.
 */
class CarStatusSearch extends CarSearch
{
 
	public function search($params)
    {
/*        $query = Car::find();
		$query->joinWith(''); */
		
		$query = CarStatus::find();
//		$query->With('car')->With('car.model');
		$query->joinWith('car'); 
		$query->joinWith('car.model'); 
		$query->joinWith('car.color'); 
		$query->joinWith('car.colorsal'); 
		$query->joinWith('stock'); 
		$query->joinWith('diller'); 
		$query->joinWith('plant'); 
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//			'pagination' => false
/*			'pagination' => new Pagination([
                    'pageSize' => false
                ]),*/
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'model_id' => $this->model_id,
            'color_id' => $this->color_id,
            'color_sal_id' => $this->color_sal_id,
        ]);

        $query->andFilterWhere(['like', 'vin', $this->vin])
            ->andFilterWhere(['like', 'enj_num', $this->enj_num]);

        return $dataProvider;
    }

}
