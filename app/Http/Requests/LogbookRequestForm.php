<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogbookRequestForm extends FormRequest
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
            'kamar_logbook' => 'required',
            'paket_logbook' => 'required',
            'no_rm' => 'required',
            'nama' => 'required',
            'tlp' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'ppk' => 'required',
            'dokter_perujuk' => 'required',
            'diagnosa' => 'required',
            'nama_dokter' => 'required',
            'keterangan_tindakan' => 'required',
            'check_in' => 'required',
        ];
    }
}
