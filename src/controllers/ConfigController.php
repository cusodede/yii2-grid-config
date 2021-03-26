<?php
declare(strict_types = 1);

namespace pozitronik\grid_config\controllers;

use pozitronik\grid_config\GridConfig;
use pozitronik\helpers\ArrayHelper;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class ConfigController
 */
class ConfigController extends Controller {

	/**
	 * @param string $id
	 * @return string
	 */
	public function actionLoad(string $id):string {
		if (Yii::$app->request->isAjax) {
			return $this->renderAjax('modalGridConfig', [
				'model' => new GridConfig(['id' => $id])
			]);
		}
		return $this->render('modalGridConfig', [
			'model' => new GridConfig(['id' => $id])
		]);
	}

	/**
	 * @return string|Response
	 * @throws Throwable
	 * @throws InvalidConfigException
	 */
	public function actionApply() {
		$config = new GridConfig();
		$config->load(Yii::$app->request->post());
		$config->apply();
		return ($config->fromUrl)?$this->redirect($config->fromUrl):ArrayHelper::getValue(Yii::$app->modules, 'gridсonfig.params.defaultRedirect', Url::home());
	}
}