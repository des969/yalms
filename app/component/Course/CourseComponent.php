<?php
/**
 * Created by PhpStorm.
 * User: veesot
 * Date: 9/29/14
 * Time: 1:10 AM
 */

namespace Yalms\Component\Course;

// ох... зачем доктрина то здесь?
use Doctrine\DBAL\Types\BooleanType;
use Input;
use Session;
use Validator;
use Yalms\Models\Courses\Course;

// неправильно импортированы классы, внимательнее с этим и не коммитить код, когда есть варнинги в PhpStorm!

class CourseComponent

{

    public $errors;

    static public function setParamPages()
    {
        /**
         *Распарсиваем то что нам пришло и в зависимости от этого -
         *модифицируем отдаваему страницу и количество объектов в ней
         **/
	    // все немного проще:
	    $perPage = Input::get('per_page', 5);
	    // и почему не использован стандартный параметр page? нехорошо придумывать свои

        if (Input::has('current_page')) {
            $currentPage = Input::get('current_page');
            //Если нужна определеная страница
            Course::resolveConnection()->getPaginator()->setCurrentPage($currentPage);
        }
        //Отдадим обратно параметры
        return array('perPage' => $perPage);
    }

    static public function listCourses()
    {
	    // пхп-доки... пишутся НАД методом
        /**
         * Отдает список курсов
         * Может принимать дополнительные параметры,такие как число курсов на странице.
         * Параметры запроса страниц (не обязательные):
         *      per_page — количество на странице.
         *     *
         * @return \Illuminate\Pagination\Paginator
         */
	    // логическо-дизайнерская ошибка:
	    // по названию метод - сеттер, но он ничего не устанавливает и еще хуже - ведет себя как геттер
        $params = CourseComponent::setParamPages();
        $courses = Course::paginate($params['perPage'], array('id', 'name'));
        return $courses;

    }

    public function storeCourse()
    {
	    // пхп-доки пишутся над методом, а не внутри него
        /**Запись и сохранение курса
         * в случае удачи - возвращаем true,иначе false
         * @return BooleanType
         * */

        //Проверка радостей от пользователя
        $validator = Validator::make(
            array('name' => Input::get('name')),
            array('name' => array('required', 'min:5'))
        );

//	    чуть проще можно
//	    $validator = Validator::make(
//		    Input::only(['name']),
//		    array('name' => array('required', 'min:5'))
//	    );

        if ($validator->passes()) {

            //Прошла валидация

            $course = new Course();
            $course->name = Input::get('name');
            $course->save();

            //т.к у нас тепреь есть новая модель(потенциально есть),
            //но контроллеры о ней ничего еще не знают-
            //положим упоминание о ней,чтоб они смогли прочитать и впоследствии использовать эту инфу
	        // компонент ничего не должен знать о контроллере и не должен сохранять информацию специально для него
	        // получается не самостоятельный компонент, который нельзя больше использовать нигде,
	        // потому что он что-то делает с сессией, а в API сессий не будет (!)
	        // и одна эта строчка, значит что этот компонент нельзя использовать для API
            Session::flash('courseId', $course->id);

            $message = 'Course ' . $course->name . ' been successful created';
            $status = 'success';
	        // еще можно вернуть объект свежесозданного курса
	        // а в случае ошибки вернуть null - это хорошее поведение метода
	        // только не смешивать возврат объекта или false
            $result = true;

        } else {
            //Все немного хуже и данные не валидны
            //Отдадим ошибки обратно клиенту
            $this->errors = $validator->messages();
            $message = 'Course not been successful created';
	        // статусов много? плохо давать названия чему-то несущественному
	        // если можно обойтись true|false, то лучше ими и обойтись
	        // а если нельзя обойтись, то статусы должны быть вынесены в отдельный класс-справочник и быть константами
	        // а не самопроизвольными названиями
            $status = 'fail';
            $result = false;

	        // все что здесь должно быть:
	        // $this->errors = $validator->messages();
	        // return false;
	        // а если сделать валидатор свойством класса
	        // то здесь будет только это:
	        // return false;
        }

        $list = array('message' => $message, 'status' => $status);
	    // то же замечание что и выше
	    // функция тут не нужна (очень усложнено, реально)
	    // и работать с сессией - ни в коем случае не задача компонента
	    // необходимо понять что метод storeCourse называется "сохранить курс"
	    // и он не должен больше ничего делать, категорически (!!!)
        packValueToSession($list);

        return $result;

    }

    public function updateCourse($id)
    {
        //Обновление
        $course = Course::findOrFail($id);
        $oldCourseName = $course->name;
        //Айдишник нам пригодится как в удачном случае,так и в случае провала
	    // то же замечание что и выше
        Session::flash('courseId', $id);

        $validator = Validator::make(
            array('name' => Input::get('name')),
            array('name' => array('required', 'min:5'))
        );

        if ($validator->passes()) {
            $course->name = Input::get('name');
            $course->save();

            $message = 'Course ' . $oldCourseName . ' been successful updated';
            $status = 'success';
            $result = true;

        } else {
            $this->errors = $validator->messages();

            $message = 'Course not been successful updated';
            $status = 'fail';
            $result = false;
        }

        $list = array('message' => $message, 'status' => $status);
	    // аналогично см. выше
        packValueToSession($list);


        return $result;

    }

    static public function showCourse($id)
    {
        //демонстрация
        $course = Course::findOrFail($id, array('name', 'id'));
        return $course;
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

	    // хм. а зачем? если метод delete не отработал, то система в целом глючная
	    // проверять работу нативных фреймворковских методов - чрезвычайно лишнее
	    // это также как сомневаться что пхп дошел до этого места
        if (Course::find($id) == null) {
            //Курса нет более
            $message = 'Course ' . $course->name . ' been successful deleted';
            $status = 'success';
            $result = true;
        } else {
            $message = 'Course not been deleted';
            $status = 'fail';
            $result = false;
        }

	    // мелкий копипаст, повторяется одно и то же во всех методах
        $list = array('message' => $message, 'status' => $status);
        packValueToSession($list);

        return $result;

    }
}