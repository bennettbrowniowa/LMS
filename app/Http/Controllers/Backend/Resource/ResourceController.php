<?php

namespace App\Http\Controllers\Backend\Resource;

use App\Http\Controllers\Controller;
use App\Models\PedagogyTag;
use App\Models\ResourceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ResourceController extends Controller
{
    public function index(){;
        return view('Backend.ResourceType.All');
    }

    public function datatable()
    {
        $query = ResourceType::select('id', 'title');

        return DataTables::eloquent($query)
            ->addColumn('action', function ($data)  {
                $url_update = route('editResource', ['id' => $data->id]);
                $url_delete = route('deleteResource', ['id' => $data->id]);
                $edit = '<a class="label label-primary" data-title="Edit ResourceType" data-act="ajax-modal" data-append-id="AjaxModelContent" data-action-url="' . $url_update . '" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>';
                $edit .= '&nbsp<a href="' . $url_delete . '" class="label label-danger" data-confirm="Are you sure to delete ResourceType: <span class=&#034;label label-primary&#034;>' . $data->title . '</span>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>';

                return $edit;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function add(){

        return view('Backend.ResourceType.Add');
    }

    public function save(Request $request){
        $this->validate($request, [
            'title'=> 'required',

        ]);

        $title = $request->get('title');

        $pedagogy = new ResourceType();
        $pedagogy->title = $title;
        $pedagogy->save();
        Session::flash('success', "Resource Type has been created successfully");
        return redirect()->back();
    }

    public function edit($id)
    {
        try {
            $records = ResourceType::findOrFail($id);
            return view('Backend.ResourceType.Edit',['records'=>$records]);
        } catch (\Exception $e) {
            return view('Backend.InvalidModalOperation');
        }
    }

    public function update(Request $request,$id){
        $this->validate($request, [
            'title'=> 'required',

        ]);

        $title = $request->get('title');

        $pedagogy=  ResourceType::findOrFail($id);

        $pedagogy->title = $title;

        $pedagogy->save();

        Session::flash('success', "ResourceType has been updated");
        return redirect()->back();
    }

    public function delete($id=null){
        $Remove = ResourceType::findOrFail($id);
        $Remove->delete();
        Session::flash('success', "ResourceType has been deleted");
        return redirect()->back();
    }
}
