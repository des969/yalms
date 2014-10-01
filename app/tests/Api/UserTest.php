<?php

namespace Yalms\Tests\Api;


use DB;
use TestCase;
use Yalms\Models\Courses\Course;
use Yalms\Models\Users\User;
use Yalms\Models\Users\UserAdmin;
use Yalms\Models\Users\UserStudent;
use Yalms\Models\Users\UserTeacher;

class UserTest extends TestCase
{

	public function setUp()
	{

		parent::setUp();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		UserAdmin::truncate();
		UserStudent::truncate();
		UserTeacher::truncate();
		User::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

	}

	/**
	 * регистрируется новый человек
	 */
	public function testUserCreate()
	{
		$this->call('POST', 'api/v1/user', [
			'first_name' => 'Стас',
			'last_name'  => 'Михайлов',
			'phone'      => '79100000000',
		]);

		$user = User::first();
		$this->assertEquals(1, $user->id);
		$this->assertEquals(1, $user->student->user_id);
		$this->assertEquals(1, $user->teacher->user_id);

	}

}

class CourseTest extends TestCase
{

    const firstCourseName = 'Астрология';
    const secondCourseName = 'Физика';

    public function setUp()
    {

        parent::setUp();

        //Чистим все
        Course::truncate();


    }

    /**
     * регистрируется новый человек.Функция store()
     */
    public function testCourseCreate()
    {
        $this->call('POST', 'api/v1/course', [
            'name' => CourseTest::firstCourseName,
        ]);

        $course = Course::first();

        //Адекватный ответ
        $expectedResponse = "Course " . CourseTest::firstCourseName . " been successful created";
        $this->assertResponseOk();
        $this->assertEquals(json_decode($this->client->getResponse()->getContent()), $expectedResponse);

        $this->assertEquals(1, $course->id);
        $this->assertEquals(CourseTest::firstCourseName, $course->name);
    }

    public function testCourseUpdate()
    {

        $course = new Course();
        $course->name = CourseTest::firstCourseName;
        $course->save();

        $url = '/api/v1/course/' . $course->id;

        //Отсылка на ресурс с данным айдишником
        $this->call('PUT', $url, [
            'name' => CourseTest::secondCourseName,
        ]);


        $expectedResponse = "Course " . CourseTest::secondCourseName . " been successful updated";
        $this->assertResponseOk();
        $this->assertEquals(json_decode($this->client->getResponse()->getContent()), $expectedResponse);

        //Сменилось ли имя
        $course = Course::first();
        $this->assertEquals(CourseTest::secondCourseName, $course->name);


    }

    public function testCourseList()
    {

        $courseFirst = new Course();
        $courseFirst->name = CourseTest::firstCourseName;
        $courseFirst->save();

        $courseSecond = new Course();
        $courseSecond->name = CourseTest::secondCourseName;
        $courseSecond->save();

        $url = '/api/v1/course/';

        //Запрос списка
        $this->call('GET', $url);
        //Ответ
        $response = json_decode($this->client->getResponse()->getContent());

        //Сверка
        $this->assertEquals($response[0]->name, $courseFirst->name);
        $this->assertEquals($response[1]->name, $courseSecond->name);


    }


}