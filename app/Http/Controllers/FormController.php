<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index(Request $request)
    {
        $forms = Form::paginate(5);

        // Pass the paginated data to the view
        return view('admin.form.index', ['forms' => $forms]);
    }

    public function create(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',

        ]);

        try {
            // Simpan data ke database
            $data = Form::create([
                'title' => $request->title,
                'description' => $request->description,
                'code' => $request->code,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'active'
            ]);

            Alert::success('Berhasil menambahkan data', 'Selamat berhasil menambahkan data');
            return back();
        } catch (\Exception $e) {
            Alert::error('Opss, gagal!', "Terjadi kesalahan, data tidak berhasil disimpan. $e");
            return back();
        }
    }
    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);
        $form->update($request->all());
        return redirect()->back()->with('success', 'Form berhasil diperbarui');
    }
    public function show($id)
    {
        $form = Form::with(['responses'])->find($id);
        return view('admin.form.detail', ['form' => $form]);
    }

    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();
        return redirect()->back()->with('success', 'Form berhasil dihapus');
    }
}
