<?php
/**
 *      ****  *  *     *  ****  ****  *    *
 *      *  *  *  * *   *  *  *  *  *   *  *
 *      ****  *  *  *  *  *  *  *  *    *
 *      *     *  *   * *  *  *  *  *   *  *
 *      *     *  *    **  ****  ****  *    *
 * @author   Pinoox
 * @link https://www.pinoox.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace pinoox\app\com_pinoox_insurance\controller\api\v1;


use pinoox\app\com_pinoox_insurance\model\QuizAnswerModel;
use pinoox\app\com_pinoox_insurance\model\QuizItemModel;
use pinoox\app\com_pinoox_insurance\model\QuizJoinModel;
use pinoox\app\com_pinoox_insurance\model\QuizModel;
use pinoox\component\Cookie;
use pinoox\component\Request;
use pinoox\component\Response;

class QuizController extends MasterConfiguration
{

    public function getById()
    {
        $params = Request::input('quiz_id');
        $quiz = QuizModel::fetch_by_id($params['quiz_id']);
        $quiz = QuizModel::build($quiz);

        Response::json($quiz);
    }

    private function validateToken($params, $checkOpen = true)
    {

        $join = QuizJoinModel::fetch_by_token($params['token']);
        if (empty($join))
            Response::json(rlang('quiz.token_not_exists'), false);

        //validate token
        $user_id = Cookie::get('user_id');
        $isValid = QuizJoinModel::validate_token($user_id, $join, $checkOpen);
        if (!$isValid)
            Response::json(rlang('quiz.error_token_invalid'), false);

        return $join;

    }

    public function start()
    {
        $params = Request::input('quiz_id');
        $quiz = QuizModel::fetch_by_id($params['quiz_id']);

        $user_id = Cookie::get('user_id');

        //validate quiz
        if (!$quiz) {
            Response::json(rlang('quiz.quiz_not_exists'), false);
        }

        //check join
        $quizJoin = QuizJoinModel::fetch_by_user_quiz($user_id, $params['quiz_id'], QuizJoinModel::open);
        if (empty($quizJoin)) {

            //join to quiz
            $join_id = QuizJoinModel::insert([
                'guest_id' => $user_id,
                'quiz_id' => $params['quiz_id'],
                'status' => QuizJoinModel::open,
            ]);
            if (!$join_id)
                Response::json(rlang('quiz.error_happened_join_quiz'), false);

            $token = QuizJoinModel::generate_token($user_id, $join_id);
            QuizJoinModel::update_token($join_id, $token);

        } else {
            $token = $quizJoin['token'];
        }

        Response::json(['token' => $token], true);
    }

    public function getQuestion()
    {
        $params = Request::input('token,index=1');
        $join = $this->validateToken($params);

        //fetch questions
        $params['index'] = intval($params['index']) - 1;//because indexes in DB start from 0
        $item = QuizItemModel::fetch_question_by_quiz($join['quiz_id'], $params['index']);
        $item = QuizItemModel::build_item($item, $join['join_id']);

        $count = QuizItemModel::fetch_count($join['quiz_id']);

        Response::json([
            'item' => $item,
            'count' => $count,
        ], true);
    }

    public function answer()
    {
        $params = Request::input('item,answer,token', null, '!empty');
        $join = $this->validateToken($params);
        $answer = null;
        $join_id = $join['join_id'];
        $item_id = $params['item']['item_id'];

        $item = QuizItemModel::fetch_by_id($item_id);

        if (empty($item))
            Response::json(rlang('quiz.error_happened'), false);

        if (!empty($params['answer'])) {
            if ($item['type'] === QuizItemModel::type_descriptive)
                $answer = $params['answer'];
            else
                $answer = json_encode($params['answer']);
        }


        //check exists and next without save new record
        $isExists = QuizAnswerModel::is_exists_answer($join_id, $item_id, $answer);
        if ($isExists)
            Response::json(null, true);

        if (!empty($answer)) {
            $is_correct = QuizAnswerModel::check_is_correct($item_id, json_decode($answer, true));
        }

        $answer_id = QuizAnswerModel::insert([
            'join_id' => $join_id,
            'item_id' => $item_id,
            'answer' => $answer,
            'is_correct' => isset($is_correct) ? $is_correct : 0,
        ]);

        Response::json(null, $answer_id > 0);

    }

    public function finish()
    {
        $params = Request::input('token');
        $join = $this->validateToken($params);

        //close quiz join
        QuizJoinModel::close($join);

        //update stats
        QuizAnswerModel::calculate_update_stats($join['join_id']);

        Response::json(null, true);
    }

    public function getResult()
    {
        $params = Request::input('token');
        $join = $this->validateToken($params, false);
        $result = QuizJoinModel::fetch_by_id($join['join_id']);

        if (!empty($result))
            Response::json(json_decode($result['stats'], true), true);

        Response::json(null, false);


    }

}