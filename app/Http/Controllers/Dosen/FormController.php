<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\ResponseForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    public function index(Request $request)
    {
        $forms = Form::paginate(5);
        // $this->attachUserFormStatus($forms, Auth::id());
        
        return view('dosen.form.index', ['forms' => $forms]);
    }

    public function fillResponse(Request $request, $formId)
    {
        // $this->checkIfUserFilledForm($formId, Auth::id());

        $request->validate($this->validationRules());

        $signaturePath = $this->saveSignature($request->input('tanda_tangan'));

        ResponseForm::create([
            'form_id' => $formId,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'tanda_tangan' => $signaturePath,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Form telah diisi.');
    }

    private function attachUserFormStatus($forms, $userId)
    {
        foreach ($forms as $form) {
            $form->isFilled = $this->hasUserFilledForm($form->id, $userId);
        }
    }

    private function checkIfUserFilledForm($formId, $userId)
    {
        if ($this->hasUserFilledForm($formId, $userId)) {
            return redirect()->back()->with('error', 'Anda sudah mengisi form ini.')->send();
        }
    }

    private function validationRules()
    {
        return [
            'nip' => 'required|string',
            'nama' => 'required|string',
            'tanda_tangan' => 'required|string',
            'status' => 'required|string',
        ];
    }

    public function checkAccessCode(Request $request, $formId)
    {
        try{


                $form = Form::find($formId); // Temukan form berdasarkan ID

                if (!$form) {
                    return response()->json(['success' => false, 'message' => 'Form tidak ditemukan'], 404);
                }

                if ($request->input('access_code') === $form->code) {
                    return response()->json(['success' => true]);
                }

                return response()->json(['success' => false, 'message' => 'Kode akses salah']);
        }
        catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "An unexpected error occurred $e"], 500);
    }
}

    private function saveSignature($signatureData)
    {
        $signatureImage = str_replace('data:image/png;base64,', '', $signatureData);
        $signatureImage = str_replace(' ', '+', $signatureImage);
        $imageName = 'signature_' . time() . '.png';

        Storage::disk('public')->put($imageName, base64_decode($signatureImage));

        return $imageName;
    }

    public function hasUserFilledForm($formId, $userId)
    {
        return ResponseForm::where('form_id', $formId)->where('user_id', $userId)->exists();
    }
}
