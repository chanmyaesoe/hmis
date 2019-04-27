<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use App\Models\Role;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use DB;

class RoleController extends Controller
{
    use FormBuilderTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $create_another = false;
        
        $form = $this->form('App\Forms\RoleForm', [
            'method' => 'POST',
            'url'    => route('admin.role.store'),
        ]);
        return view('admin.role.add', [
            'form' => $form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $this->form('App\Forms\RoleForm', [
            'method' => 'POST',
            'url'    => route('admin.role.store'),
        ]);

        $data = $request->except('_token');
        if(!isset($data['description']))
        {
            $data['description'] = "";
        }

        if (!$form->isValid())
        {
            echo 'here';exit;
            $key = array_keys($form->getErrors());
            \Session::flash('error', $form->getErrors()[$key[0]][0]);
            return redirect()->back()
                             ->withErrors($form->getErrors())
                             ->withInput();
        }

        Role::create($data);

        \Session::flash('message', e($data['name']) . " Role has been added.");
       
        return redirect()->route('admin.role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $form = $this->form('App\Forms\RoleForm', [
            'method' => 'PUT',
            'url'    => route('admin.role.update', $role->id),
            'model'  => $role
        ]);
        return view('admin.role.add', [
            'form'     => $form,
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role)
    {
        $rules = [];
        $rules['name'] = 'required';
        $rules['code'] = 'required|unique:roles,code,' . $role->id;
        $this->validate(request(), $rules);

        $role->update(request()->all());
     
        \Session::flash("message", "Role has been updated.");
        return redirect()->route('admin.role.show',$role->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $name = $role->name;
        $role->delete();
        return redirect()->route('admin.role.index');
    }
    /**
     * Return the data from the Role Table.
     */
    public function getData(Request $request)
    {
        $params = $request->all();
        if (
            !array_key_exists('columns', $params) ||
            !array_key_exists('start', $params) ||
            !array_key_exists('length', $params) ||
            !array_key_exists('draw', $params) ||
            !array_key_exists('value', $params['search'])
        ) {
            abort(404);
        }

        $offset = $params['start'];
        $limit = $params['length'];
        $order = $params['order'];
        $search = $params['search']['value'];
        /**
         * Columns
         */
        $columns = [
            'id',
            'name',
            'code',
            'created_at',
        ];

        $result_query = Role::select('roles.*');

        // filter groups
        $filters = [];   

        if($search != '') {
            $result_query->where(function($query) use ($search, $columns) {
                $date_fields = ['created_at'];
                foreach($columns as $s) {
                    if (in_array($s, $date_fields)) {
                        $query->orWhere(DB::raw("DATE_FORMAT({$s},'%b %e, %Y')"), "LIKE", "%{$search}%");
                    }
                    if ($s == 'amount') {
                        $query->orWhere(DB::raw("ROUND({$s},2)"), "LIKE", "%{$search}%");
                    }
                    $query->orWhere($s, 'like', "%{$search}%");
                }
            });
        }

        if(count($filters) > 0) {
            $result_query->where($filters);
        }
        

        if($order) {
            foreach($order as $sorter) 
            {
                $result_query->orderBy($columns[$sorter['column']], $sorter['dir']);
            }
        }

        $total = $result_query->count();
        $all_lists = $result_query->offset($offset)->limit($limit)->get();
        
        $records = [];
        foreach($all_lists as $all_list) {
            $created_at = new Carbon($all_list->created_at);
            $updated_at = new Carbon($all_list->updated_at);
            $checkname = '';
            if ($all_list->active) {
               $checkname = "checked";
            }
            
            $actions = '<a href="'. route('admin.role.show', ['code' => $all_list->id]) .'" class="list-actions" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a> ';
            $actions .= '<a href="'. route('admin.role.edit',$all_list->id) .'" class="list-actions" data-toggle="tooltip" title="View"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
            $actions .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Remove" onclick="confirmDelete(\'' . $all_list->id . '\', \''. $all_list->name .'\')" class="list-actions"><i class="fa fa-trash" aria-hidden="true"></i></a> ';
            $row = [
                'name' => $all_list->name,
                'code' => $all_list->code,
                'created_at' => $created_at->format('M j, Y'),
                'action' => $actions
            ];
            $records[] = $row;
        }

        $data["data"]            = $records;
        $data["draw"]            = $params['draw'];
        $data["recordsFiltered"] = $total;

        return response()->json($data);
    }
}
