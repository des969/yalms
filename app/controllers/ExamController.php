<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\BrowserKit\Response;
use Yalms\Models\Courses\Exam;

class ExamController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /exam
	 *
	 * @return Response
	 */
	public function index()
	{
		$exams = Exam::paginate(10);

		return View::make('pages.exam.index', ['exams'=>$exams]);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /exam/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('pages.exam.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /exam
	 *
	 * @return Response
	 */
	public function store()
	{
		$exam = new Exam;
		$exam->name = Input::get('name');
	}

	/**
	 * Display the specified resource.
	 * GET /exam/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
//		return Exam::find($id);
		$exam = Exam::findOrFail($id);
		$message = Session::get('message');
		if (isset($message))
		{
			return View::make('pages.exam.show', compact('message', 'exam'));
		} else {
			return View::make('pages.exam.show')->with('exam', $exam);
		}

	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /exam/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$url = URL::route('exam.update', ['id' => $id]);
		$examName = Exam::find($id)->name;

		return View::make('pages.exam.edit', compact('examName', 'url'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /exam/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$exam = Exam::findOrFail($id);
		$exam->name = $examName = Input::get('name');
		$exam->save();

		$message = 'Exam ' . $exam->name . 'has been successfully updated';

		return Redirect::action('ExamController@show', array($id))->with('message', $message);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /exam/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$exam = Exam::findOrFail($id);
		$examName = $exam->name;

		$exam->delete();

		$message = 'Exam ' . $examName . ' has been successfully removed';

		return Redirect::action('ExamController@index')->with('message', $message);
	}

}