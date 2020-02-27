<?php

namespace App\Http\Controllers\Backend;

use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql = DB::table('menus')
//            ->leftJoin('role_menu','menus.id','=','role_menu.menu_id')
            ->where('menus.parent_id','=','0')
            ->get(['id', 'title_'.\App::getLocale().' AS title', 'route']);
//        dd($sql);
        return view('backend.menu.index',[
            'menu'=>$sql
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sql = DB::table('roles')->where('id','!=','1')->get();
//        dd($sql);
        return view('backend.menu.create',[
            'group'=>$sql
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

//        dd($request->all());
        try {
            $sql = DB::table('menus')->insertGetId(
                [
                    'title_th' => $request->name,
                    'title_en' =>  $request->nameeng,
                    'route'=> '',
                    'icon'=> $request->icon,
                    'parent_id'=>0,
                    'order'=>0,
                ]
            );
            if ($sql){
                $data = array();
                if (isset($request->group)){
                    for($i=0;$i<count($request->group);$i++){
                        $data[] = array('menu_id'=>$sql,'role_id'=>$request->group[$i]);
                    }
                }
                $data[] = array('menu_id'=>$sql,'role_id'=>"1");
                DB::table('role_menu')->insert($data);
                return redirect()->route('admin.menu.index');

            }
        }catch (QueryException $e){
            dd($e->getMessage());
        }


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
        $sql = DB::table('roles')->where('id','!=','1')->get();
        $dataid = DB::table('menus')->where('id','=',$id)
            ->select('title_th','title_en','icon')
            ->first();
        $role_menu = DB::table('role_menu')->where('menu_id','=',$id)
            ->select('role_id')
            ->get();
        return view('backend.menu.edit',[
            'id'=>$id,
            'group'=>$sql,
            'data' => $dataid,
            'role'=>json_decode($role_menu)
        ]);
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
        dd($request,$id);
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

    public function createSubMenu($id_menu){

        return $id_menu;
    }
    public function getMenus($Language)
    {
        $arr_group_user = array();
        $leng = count(Auth::user()->roles);
        for ($i = 0; $i < $leng; $i++) {
//            dd(Auth::user()->roles[$i]->id);
            array_push($arr_group_user, Auth::user()->roles[$i]->id);
        }
//        dd($arr_group_user);

        $user_role = DB::table('roles')
            ->leftJoin('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select(DB::raw('CAST(roles.id AS integer) As id'))
            ->whereIn('model_has_roles.role_id', $arr_group_user)
            ->get()->toArray();
//        dd($user_role);
        foreach ($user_role as $object) {
            $arrays[] = $object->id;
        }
//        dd($arrays);
        $array = array_values(array_unique($arrays));
//        dd($array);

        $menus_role = DB::table('role_menu')
            ->select('menu_id')
            ->whereIn('role_id', $array)
            ->get()->toArray();
//        dd($menus_role);

        foreach ($menus_role as $index => $menu_role) {
            $permission[$index] = $menu_role->menu_id;
        }
        if (isset($permission)) {
//            dd($permission);
            $menus['lv1'] = DB::table('menus')
                ->where('parent_id', 0)
                ->whereIn('id', $permission)
                ->orderBy('order', 'ASC')
                ->get(['id', 'title_' . $Language . ' AS title', 'route', 'parent_id', 'order', 'icon'])
                ->toArray();

//            dd($menus);

            foreach ($menus['lv1'] as $index => $value) {
                $value->lv2 = DB::table('menus')
                    ->where('parent_id', $value->id)
//                    ->whereIn('id', $permission)
                    ->orderBy('order', 'ASC')
                    ->get(['id', 'title_' . $Language . ' AS title', 'route', 'parent_id', 'order', 'icon'])
                    ->toArray();
            }
            return $menus;
        } else {
            return [];

        }
    }
}
