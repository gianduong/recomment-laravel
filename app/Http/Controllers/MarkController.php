<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarkController extends Controller
{
    public function mark(Request $request)
    {
        $data = $request->all();
        $result = [];
        try {
            $this->validate($request, $this->validationRules(), $this->validationMessages());
            $diem = ($data['diem_lop10'] + $data['diem_lop10'] + $data['diem_lop10']) / 3;
            foreach ([2017, 2018, 2019, 2020, 2021, 2022, 2023] as $year) {
                $result[$year] = $this->getMark($diem, $year);
            }
            return successResponse($result);
        } catch (ValidationException $validationException) {
            return errorResponse([
                'errors' => $validationException->validator->errors(),
                'exception' => $validationException->getMessage()
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMark($diem, $year)
    {
        $soLuong = DB::table('diem_so')->where('diemTB', '>=', $diem - 1)->where('diemTB', '<', $diem + 1)->where('nam', $year)->count();
        $tongDiem = DB::table('diem_so')->where('diemTB', '>=', $diem - 1)->where('diemTB', '<', $diem + 1)->where('nam', $year)->sum('diemthiDH');
        return round((float) $tongDiem / $soLuong, 2);
    }

    protected function validationRules()
    {
        return [
            'diem_lop10' => 'required',
            'diem_lop11' => 'required',
            'diem_lop12' => 'required',
        ];
    }

    protected function validationMessages()
    {
        return [];
    }
}
