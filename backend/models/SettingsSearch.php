<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Settings;

/**
 * SettingsSearch represents the model behind the search form about `app\models\Settings`.
 */
class SettingsSearch extends Settings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'smtp_port'], 'integer'],
            [['app_name', 'app_owner', 'admin_email', 'from_email', 'address', 'app_logo', 'footer_logo', 'currency', 'location', 'Geocode', 'telephone', 'copyright_text', 'about', 'meta_title', 'meta_tag', 'meta_tag_description', 'smtp_email', 'smtp_username', 'smtp_password', 'smtp_hash'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Settings::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'smtp_port' => $this->smtp_port,
        ]);

        $query->andFilterWhere(['like', 'app_name', $this->app_name])
            ->andFilterWhere(['like', 'app_owner', $this->app_owner])
            ->andFilterWhere(['like', 'admin_email', $this->admin_email])
            ->andFilterWhere(['like', 'from_email', $this->from_email])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'app_logo', $this->app_logo])
            ->andFilterWhere(['like', 'footer_logo', $this->footer_logo])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'Geocode', $this->Geocode])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'copyright_text', $this->copyright_text])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_tag', $this->meta_tag])
            ->andFilterWhere(['like', 'meta_tag_description', $this->meta_tag_description])
            ->andFilterWhere(['like', 'smtp_email', $this->smtp_email])
            ->andFilterWhere(['like', 'smtp_username', $this->smtp_username])
            ->andFilterWhere(['like', 'smtp_password', $this->smtp_password])
            ->andFilterWhere(['like', 'smtp_hash', $this->smtp_hash]);

        return $dataProvider;
    }
}
