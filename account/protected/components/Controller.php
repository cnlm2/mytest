<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function initMenu()
	{
		$this->menu=array(
			array('label'=>'奖励中心', 'url'=>array('account/giftcenter')),
			array('label'=>'用户信息', 'url'=>array('account/view', 'id'=>Yii::app()->user->id)),
			array('label'=>'账号安全', 'url'=>array('account/update', 'id'=>Yii::app()->user->id)),
			array('label'=>'修改密码', 'url'=>array('account/password', 'id'=>Yii::app()->user->id)),
			array('label'=>'清除口令', 'url'=>array('account/sendcleartoken')),
			//array('label'=>'账户充值', 'url'=>array('charge/create')),
			//array('label'=>'订单列表', 'url'=>array('charge/index')),
			array('label'=>'开通论坛', 'url'=>array('account/openbbs')),
		);
	}

	protected function beforeAction($event)
	{
		if (Yii::app()->controller->action->id == "captcha")
			return true;
		//stat_log($_SERVER['REQUEST_METHOD']);
		return true;
	}

    protected function renderJSON($data)
    {
        header('Content-type: application/json');
        echo CJSON::encode($data);
        //foreach (Yii::app()->log->routes as $route) {
        //    if ($route instanceof CWebLogRoute) {
        //        $route->enabled = false;
        //    }
        //}
        Yii::app()->end();
    }
}
