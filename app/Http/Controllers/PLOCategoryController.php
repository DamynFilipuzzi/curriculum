<?php

namespace App\Http\Controllers;

use App\Models\PLOCategory;
use Illuminate\Http\Request;

class PLOCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            
            'category'=> 'required',
            ]);

        $c = new PLOCategory;
        $c->plo_category = $request->input('category');
        $c->program_id = $request->input('program_id');
        
        if($c->save()){
            $request->session()->flash('success', 'New plo cateogry added');
        }else{
            $request->session()->flash('error', 'There was an error adding the plo category');
        }
        
        return redirect()->route('programWizard.step2', $request->input('program_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PLOCategory  $pLOCategory
     * @return \Illuminate\Http\Response
     */
    public function show(PLOCategory $pLOCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PLOCategory  $pLOCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(PLOCategory $pLOCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PLOCategory  $pLOCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $plo_category_id)
    {
        //
        $this->validate($request, [
            
            'category'=> 'required',
            ]);

        $c = PLOCategory::where('plo_category_id', $plo_category_id)->first();
        $c->plo_category = $request->input('category');
        
        if($c->save()){
            $request->session()->flash('success', 'Plo cateogry updated');
        }else{
            $request->session()->flash('error', 'There was an error updating the plo category');
        }
        
        return redirect()->route('programWizard.step2', $request->input('program_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PLOCategory  $pLOCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $plo_category_id)
    {
        //
        $c = PLOCategory::where('plo_category_id', $plo_category_id)->first();
        
        if($c->delete()){
            $request->session()->flash('success', 'Plo cateogry deleted');
        }else{
            $request->session()->flash('error', 'There was an error deleting the plo category');
        }
        
        return redirect()->route('programWizard.step2', $request->input('program_id'));
    }

    
}
