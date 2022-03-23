<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EcnocardiographyRequestForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tgl_ditindak' => 'required',
            'waktu_ditindak' => 'required',
            'nama' => 'required',
            'tlp' => 'required',
            'alamat' => 'required',
            'petugas_poli' => 'required',
            'petugas_fo' => 'required',
            'keterangan' => 'required',
        ];
    }
}
