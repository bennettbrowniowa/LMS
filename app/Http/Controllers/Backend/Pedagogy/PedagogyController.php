<?php

namespace App\Http\Controllers\Backend\Pedagogy;

use App\Http\Controllers\Controller;
use App\Models\PedagogyTag;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Zizaco\Entrust\EntrustFacade as Entrust;

class PedagogyController extends Controller
{

    public function index(){;
        return view('Backend.Pedagogy.All');
    }

    public function datatable()
    {

        $query = PedagogyTag::select('id', 'title');

        return DataTables::eloquent($query)
            ->addColumn('action', function ($data)  {
                $url_update = route('editPedagogy', ['id' => $data->id]);
                $url_delete = route('deletePedagogy', ['id' => $data->id]);
                $edit = '<a class="label label-primary" data-title="Edit PedagogyTools" data-act="ajax-modal" data-append-id="AjaxModelContent" data-action-url="' . $url_update . '" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>';
                $edit .= '&nbsp<a href="' . $url_delete . '" class="label label-danger" data-confirm="Are you sure to delete Pedagogy: <span class=&#034;label label-primary&#034;>' . $data->title . '</span>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>';

                return $edit;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function add(){

        return view('Backend.Pedagogy.Add');
    }

    public function save(Request $request){
        $this->validate($request, [
            'title'=> 'required',

        ]);

        $title = $request->get('title');

        $pedagogy = new PedagogyTag();
        $pedagogy->title = $title;
        $pedagogy->save();
        Session::flash('success', "Peadgogy has been created successfully");
        return redirect()->back();
    }

    public function edit($id)
    {
        try {
            $records = PedagogyTag::findOrFail($id);
            return view('Backend.Pedagogy.Edit',['records'=>$records]);
        } catch (\Exception $e) {
            return view('Backend.InvalidModalOperation');
        }
    }

    public function update(Request $request,$id){
        $this->validate($request, [
            'title'=> 'required',

        ]);

        $title = $request->get('title');

        $pedagogy=  PedagogyTag::findOrFail($id);

        $pedagogy->title = $title;

        $pedagogy->save();

        Session::flash('success', "Pedagogy has been updated");
        return redirect()->back();
    }

    public function delete($id=null){
        $Remove = PedagogyTag::findOrFail($id);
        $Remove->delete();
        Session::flash('success', "Pedagogy has been deleted");
        return redirect()->back();
    }


}
