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

namespace pinoox\app\com_pinoox_insurance\controller\api\panel\v1;

use pinoox\app\com_pinoox_insurance\component\Permission;
use pinoox\app\com_pinoox_insurance\model\QuizItemModel;
use pinoox\app\com_pinoox_insurance\model\QuizJsonModel;
use pinoox\app\com_pinoox_insurance\model\QuizModel;
use pinoox\component\Pagination;
use pinoox\component\Request;
use pinoox\component\Response;
use pinoox\component\Validation;
use pinoox\model\PinooxDatabase;

class QuizController extends LoginConfiguration
{
    private $isFullAccess = false;

    public function __construct()
    {
        parent::__construct();
        $this->isFullAccess = Permission::option('all_quiz');
    }

    public function getById($quiz_id)
    {
        if (!$this->isFullAccess)
            QuizModel::where_user(self::$user_id);
        $quiz = QuizModel::fetch_by_id($quiz_id);
        if (empty($quiz))
            Response::json(null);

        $quiz = QuizModel::build($quiz);

        // questions
        $quiz['questions'] = $this->getQuestionsByQuiz($quiz_id);

        Response::json($quiz);
    }

    private function getQuestionsByQuiz($quiz_id)
    {
        $questions = QuizItemModel::fetch_all_by_quiz_id($quiz_id);
        return !empty($questions) ? $questions : [];
    }

    public function getItems()
    {
        $form = Request::input('keyword,sort,status=all,perPage=10,page=1,quiz_name,category', null, '!empty');

        $this->filterSearch($form);
        $count = QuizModel::fetch_all(null, true);

        // pagination
        $pagination = new Pagination($count, $form['perPage']);
        $pagination->setCurrentPage($form['page']);

        $this->filterSearch($form);
        $items = QuizModel::fetch_all($pagination->getArrayLimit());

        Response::json([
            'items' => $items,
            'pages' => $pagination->getInfoPage()['page']
        ]);
    }

    private function filterSearch($form)
    {
        if (Permission::module('panel/quiz/search')) {
            QuizModel::where_field('quiz_name', $form['quiz_name']);
            QuizModel::where_category($form['category']);
        }

        QuizModel::where_search($form['keyword']);
        QuizModel::where_status($form['status']);
        QuizModel::sort($form['sort']);
    }

    public function save()
    {
        $field = Request::input([
            'quiz_id',
            'quiz_name',
            'quiz_description',
            'category',
            'status',
            'questions' => [],
        ],
            null,
            '!empty');

        $valid = Validation::check($field, [
            'quiz_name' => ['required|length:>=2', rlang('quiz.quiz_name')],
        ]);
        if ($valid->isFail())
            Response::jsonMessage($valid->first(), false);

        $oldQuiz = (!empty($field['quiz_id'])) ? QuizModel::fetch_by_id($field['quiz_id']) : null;

        // manage status for admin
        if (!$this->isFullAccess) {

            if ($oldQuiz) {
                $isCreator = ($oldQuiz['user_id'] === self::$user_id);
                if (!$isCreator) {
                    Response::jsonMessage(rlang('panel.error_happened'), false);
                }

                $this->checkAccessForQuiz($oldQuiz);
            }

            $status = $oldQuiz && !empty($oldQuiz['status']) ? $oldQuiz['status'] : QuizModel::pending;

            if (!$oldQuiz || $oldQuiz['status'] !== $field['status']) {
                if (!in_array($field['status'], [QuizModel::pending, QuizModel::draft])) {
                    $field['status'] = $status;
                }
            }
        }

        if ($field['status'] === QuizModel::publish && !$this->isFullAccess && QuizModel['status'] !== QuizModel::publish) {
            $field['status'] = QuizModel::pending;
        }

        if ($field['status'] == QuizModel::publish || $field['status'] == QuizModel::pending) {
            $this->checkFieldsForPublish($field, $oldQuiz);
        }

        PinooxDatabase::startTransaction();

        $field['user_id'] = self::$user_id;

        $isEdit = !empty($oldQuiz);

        if ($isEdit && !Permission::module('panel/quiz/edit')) {
            $this->errorAccess();
        }

        if (!$isEdit && !Permission::module('panel/quiz/add')) {
            $this->errorAccess();
        }

        if ($isEdit) {
            $status = QuizModel::update($field);
            $quiz_id = $status ? $field['quiz_id'] : false;
        } else {
            $quiz_id = QuizModel::insert($field);
            $field['quiz_id'] = $quiz_id;
        }

        QuizJsonModel::save_data($quiz_id, $field);
        $this->saveQuestions($field);

        PinooxDatabase::commit();

        if ($quiz_id) {
            Response::jsonMessage(rlang('quiz.saved_successfully'), true, $quiz_id);
        } else {
            Response::jsonMessage(rlang('panel.error_happened'), false);
        }

    }

    private function saveQuestions($data)
    {
        QuizItemModel::delete_all_by_quiz_id($data['quiz_id']);

        if (empty($data['questions']) || !is_array($data['questions']))
            return;
        $order = 0;
        foreach ($data['questions'] as $item) {
            if (empty($item))
                continue;

            $order++;

            QuizItemModel::insert([
                'quiz_id' => $data['quiz_id'],
                'question' => @$item['question'],
                'answer' => @$item['answer'],
                'type' => @$item['type'],
                'body' => @$item['body'],
                'sort' => $order,
            ]);
        }
    }

    public function delete()
    {
        $quiz_id = Request::inputOne('quiz_id', null, '!empty');
        $status = QuizModel::delete($quiz_id);
        if ($status) {
            Response::jsonMessage(rlang('panel.delete_successfully'), true);
        }

        Response::jsonMessage(rlang('panel.error_happened'), false);
    }


    private function checkAccessForQuiz($quiz)
    {
        if ($this->isFullAccess)
            return;

        if ($quiz['status'] != QuizModel::pending && $quiz['status'] != QuizModel::draft)
            Response::jsonMessage(rlang('panel.error_happened'), false);
    }

    private function checkFieldsForPublish($field, $oldQuiz)
    {
        $valid = Validation::check($field, [
            'questions' => ['required|!empty', rlang('quiz.questions')],
        ]);
        if ($valid->isFail())
            Response::jsonMessage($valid->first(), false);
    }
}