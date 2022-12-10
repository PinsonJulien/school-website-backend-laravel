<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FormationResource;
use App\Http\Resources\V1\FormationCollection;
use App\Filters\V1\FormationsFilter;

class FormationController extends Controller
{
    function __construct() {}

    /**
    * Display a listing of all formations
     *
     * @param Request $request
     * @return FormationCollection
    */
    public function index(Request $request) {
        $formations = $this->filterRequest(new FormationsFilter(), Formation::query(), $request);

        if ($request->query('includeCourses')) {
            $formations = $formations->with('courses');
        }

        return new FormationCollection($formations->paginate()->appends($request->query()));
    }

    /**
    * Display the specified formation
     *
     * @param Formation $formation
     * @return FormationResource
    */
    public function show(Formation $formation): FormationResource
    {
        return new FormationResource($formation);
    }
}
