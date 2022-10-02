<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Attendance\AttendanceRequest;
use App\Services\Attendance\AttendanceServiceInterface;
use App\Repositories\Attendance\AttendanceRepositoryInterface;

class AttendanceController extends Controller
{
    private $modelService;
    private $modelRepository;

    public function __construct(
        AttendanceServiceInterface $modelService,
        AttendanceRepositoryInterface $modelRepository,
    ) {
        $this->modelService = $modelService;
        $this->modelRepository = $modelRepository;
    }

    public function index()
    {
        return "when i was a y oungboy";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceRequest $request)
    {
        $result = $this->modelService->store($request);
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
