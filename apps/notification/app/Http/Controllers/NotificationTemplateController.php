<?php

namespace App\Http\Controllers;

use App\Models\NotificationTemplate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return NotificationTemplate[]|Collection|Response
     */
    public function index(Request $request)
    {
        $query = NotificationTemplate::query();

        if ($s = $request->input('_search')) {
            $query->whereRaw("code LIKE '%" . $s . "%'")
                ->orWhereRaw("theme_ru LIKE '%" . $s . "%'")
                ->orWhereRaw("body_ru LIKE '%" . $s . "%'");
        }

        if ($sort = $request->input('_sort')) {
            $query->orderBy($sort, $request->input('_order', 'asc'));
        }

        $perPage = $request->input('_limit', 10);
        $page = $request->input('_page', 1);
        $total = $query->count();

        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

        return [
            'data' => $result,
            'total' => $total,
            'page' => $page,
            'last_page' => ceil($total / $perPage)
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return void
     */
    public function show($id)
    {
        return NotificationTemplate::findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $template = NotificationTemplate::create($request->all());

        return response($template, Response::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $template = NotificationTemplate::findOrFail($id);

        $template->update($request->all());

        return response($template, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        NotificationTemplate::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
