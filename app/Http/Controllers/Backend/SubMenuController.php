<?php

namespace App\Http\Controllers\Backend;

use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
class SubMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql = DB::table('menus as m1')
            ->join('menus as m2','m1.id','=','m2.parent_id')
            ->get(['m2.id', 'm2.title_'.\App::getLocale().' AS title', 'm2.route','m1.title_'.\App::getLocale().' AS title_host']);
//        dd($sql);
        return view('backend.submenu.index',[
            'submenu'=>$sql
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($menu_id=null)
    {
        $sql = DB::table('menus')
            ->where('menus.parent_id','=','0')
            ->get(['id', 'title_'.\App::getLocale().' AS title', 'route']);
//dd($sql);
        return view('backend.submenu.create',[
            'menu'=>$sql,
            'menu_select'=>$menu_id
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
        $sql = DB::table('menus')->insertGetId(
            [
                'title_th' => $request->name,
                'title_en' =>  $request->nameeng,
                'route'=> $request->nameroute,
                'icon'=> '',
                'parent_id'=>$request->parent_id,
                'order'=>0,
            ]
        );
        return  redirect()->route('admin.submenu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sql = DB::table('menus')
            ->where('menus.parent_id','=',$id)
            ->get(['id', 'title_'.\App::getLocale().' AS title', 'route']);
//        dd($sql);
        return view('backend.submenu.show',[
            'submenu'=>$sql
        ]);
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
