<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = Label::paginate(15);

        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('labels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Метка с таким именем уже существует',
        ];

        $data = $request->validate([
            'name' => 'required|min:3|max:50|unique:labels,name',
            'description' => 'nullable|string|max:100',
            'color' => 'string',
        ], $messages);

        Label::create($data);

        // new Label()->fill($data)->save();

        return redirect()->route('labels.index')->with('success', 'Метка успешно создана');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        return view('labels.edit', ['label' => $label]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'string',
        ]);
        $label->update($data);

        return redirect()->route('labels.index')->with('success', 'Метка успешно изменена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        if (! $label->canBeDeleted()) {
            return redirect()->route('labels.index')
                ->with('error', ('Не удалось удалить метку'));
        }

        $label->delete();

        return redirect()->route('labels.index')->with('success', 'Метка успешно удалена');
    }
}
