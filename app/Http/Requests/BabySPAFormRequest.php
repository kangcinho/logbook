<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BabySPAFormRequest extends FormRequest
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
          'nama' => 'required',
          'tlp' => 'required',
          'tgl_lahir' => 'required',
          'alamat' => 'required',
          'tgl_reservasi' => 'required',
          'pukul_reservasi_awal' => 'required',
          'keterangan' => 'required',
        ];
    }
}
