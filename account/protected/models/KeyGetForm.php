<?php

class KeyGetForm extends CFormModel
{
	public $answer1;
	public $answer2;
	public $answer3;
	public $answer4;
	public $answer5;

	public $questions;

	public $key;

	public function __construct() {
		parent::__construct();
		$this->questions = array();
		$questions_db = $this->getQuestions();
		$selected_keys = array_rand($questions_db, 5);
		$count = 0;

		foreach($selected_keys as $key) {
			$count = $count + 1;
			$question = $questions_db[$key];
			$ans_keys = array(0, 1, 2, 3);
			shuffle($ans_keys);

			$answers = array();
			foreach($ans_keys as $akey) {
				$answers[$question[1][$akey]] = $question[1][$akey];
			}
			array_push($this->questions,
				array("desc"=>$question[0],
					"correct"=>$question[1][0],
					"answers"=>$answers,
					"no"=>$count,
				)
			);
		}
	}

	public function getQuestions()
	{
		return array(
			array(
				"《拍拍富》的游戏画面是___？",
				array(
					"2D",
					"2.5D",
					"3D",
					"4D",
				),
			),
			array(
				"《拍拍富》是什么类型的游戏？",
				array(
					"回合制",
					"射击",
					"格斗",
					"竞技",
				),
			),
			array(
				"郭啸天的儿子是谁？",
				array(
					"郭靖",
					"杨康",
					"张无忌",
				   	"西门吹雪",
				),
			),
			array(
				"东方不败喜欢的人是谁？",
				array(
					"杨莲亭",
					"杨幂",
					"郭小四",
					"方舟子",
				),
			),
			array(
				"《拍拍富》的官网地址是:",
				array(
					"www.dxqzol.com",
					"www.dxqzol123.com",
					"www.dxqzol2.com",
					"www.dxqzol3.com",
				),
			),
		);
	}

	public function attributeLabels()
	{
		return array(
			'answer1'=>'A1',
			'answer2'=>'A2',
			'answer3'=>'A3',
			'answer4'=>'A4',
			'answer5'=>'A5',
		);
	}

	public function rules()
	{
		return array(
			array('answer1, answer2, answer3, answer4, answer5', 'required'),
		);
	}

	public function genActivationKey()
	{
		$counter = Counter::model()->findByPk("ABoK");
		if (!$counter) {
			$counter = new Counter();
			$counter->name = "ABoK";
			$counter->value = 0;
		}
		require_once("CardGenerator.php");
		$card_id = GenCode("ABoK", $counter->value);
		$counter->value++;
		$counter->save();
		return $card_id;
	}

	public function fetch()
	{
		$count = 0;
		foreach ($this->questions as $question) {
			$count = $count+1;
			if ($question['correct'] !== $this->{'answer'.$count}) {
				$this->addError('answer'.$count, "这题回答错误了哦");
				return false;
			}
		}
		$key = $this->genActivationKey();
		if ($key === null) {
			return true;		//没有激活码放到keydeliver的视图中处理
		}
		$this->key = $key;
		return true;
	}
}

