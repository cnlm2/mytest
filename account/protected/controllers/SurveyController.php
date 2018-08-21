<?php

class SurveyController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('invalid','vote2'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('vote'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

    public function getOptionValue($option_id)
    {
        $opt = Surveyoption::model()->findByPk($option_id);
        if ($opt) {
            return $opt->desc;
        }
        return "不存在";
    }

    public function actionVote2()
    {
        # 2014.8 名人投票
        $account = Account::model()->findByPk(Yii::app()->user->id);
        if (!$account) {
            $this->renderJSON(array(
                "login"=>true
            ));
            return;
        }

        if (!isset($_REQUEST['option'])) {
            $this->renderJSON(array(
                'error'=>"参数错误！"
            ));
            return;
        }

        # 如果已经投过票
        $exist_vote = Surveyvote::model()->findAllBySql(
            "SELECT * FROM `surveyvote` WHERE account_id=? AND subject_id=2",
            array($account->id));
        if (count($exist_vote) >= 3) {
			$vote_name = array();
			foreach ($exist_vote as $vote) {
				array_push($vote_name, $this->getOptionValue($vote->option_id));
			}
            $all_vote = implode("，", $vote_name);
            $this->renderJSON(array('info'=>"您已经将票投给了{$all_vote}，不能再投票！"));
            return;
        }
        if (count($exist_vote) > 0) {
            foreach($exist_vote as $vote) {
                if ($vote->option_id === $_REQUEST['option']) {
                    $this->renderJSON(array('info'=>"您已经为{$this->getOptionValue($vote->option_id)}投过票了，可以再投给别的名人哦！"));
                }
            }
        }

        if (isset($_REQUEST['option'])) {
            $vote = new Surveyvote();
            $vote->account_id = $account->id;
            $vote->subject_id = 2;
            $vote->option_id = $_REQUEST['option'];
            if($vote->save()) {
                $this->renderJSON(array('info'=>"您成功将票投给了{$this->getOptionValue($vote->option_id)}！"));
            }
            return;
        }
    }

	public function actionVote()
	{
		# 2013.10.25 坐骑投票活动
		$this->layout = "zt131025";

		$account = Account::model()->findByPk(Yii::app()->user->id);
		if (!$account) {
			throw new CHttpException(404, "账户不存在");
		}

		if (!isset($_REQUEST['subject']) || !isset($_REQUEST['option'])) {
			$this->render('vote', array('info'=>""));
			return;
		}

		$id2ride = array(
			1 => "熊猫",
			2 => "虎",
			3 => "鹿",
			4 => "马",
		);

		# 如果已经投过票
		$exist_vote = Surveyvote::model()->findBySql(
			"SELECT * FROM `surveyvote` WHERE account_id=? AND subject_id=1",
			array($account->id));
		if ($exist_vote) {
			$this->render('vote', array('info'=>"您已经将票投给了{$id2ride[$exist_vote->option_id]}，不能再投票！"));
			return;
		}

		$this->render('vote', array('info'=>"投票活动已经截止了"));
		return;

		if (isset($_REQUEST['subject']) && isset($_REQUEST['option'])) {
			$vote = new Surveyvote();
			$vote->account_id = $account->id;
			$vote->subject_id = $_REQUEST['subject'];
			$vote->option_id = $_REQUEST['option'];
			if($vote->save()) {
				$this->render('vote', array('info'=>"您成功将票投给了{$id2ride[$vote->option_id]}！"));
			}
			return;
		}
	}

}
