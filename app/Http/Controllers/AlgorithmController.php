<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Illuminate\Cache\forever;

class AlgorithmController extends Controller
{
    public function reading(Request $request)
    {
        $result = [];
        $data = $request->all();
        $giaThiet = [];
        $nganh = 'all';
        $input = [];
        if (isset($data['nganh'])) {
            $nganh = $data['nganh'];
            array_push($input, $nganh);
        }
        $diaPhuong = 'all';
        if (isset($data['diaPhuong'])) {
            $diaPhuong = $data['diaPhuong'];
            array_push($input, $diaPhuong);
        }
        isset($data['khoiThi']) && array_push($giaThiet, $data['khoiThi']);
        isset($data['soThich']) && array_push($giaThiet, $data['soThich']);
        isset($data['hocLuc']) && array_push($giaThiet, $data['hocLuc']);
        $tbLuat = DB::table('tapLuat')->get('NoiDung')->toArray();

        // get theo nganh va dia phuong
        $goiY = [];
        if (count($input) > 0) {
            $goiY = $this->thuatToan([
                'left' => $input,
                'right' => []
            ], $tbLuat);
        }
        $listTruong = DB::table('suKien')->where('LoaiSuKien', 'Truong')->whereIn('ID_SuKien', $goiY)->get('MoTaSuKien')->toArray();
        $listGoiY = [];
        foreach ($listTruong as $key => $value) {
            array_push($listGoiY, $value->MoTaSuKien);
        }
        $result['goiY'] = $listGoiY;


        //goi y them theo so thich ca nhan
        if (count($giaThiet) > 0) {
            $listTruongGoiY = [];
            $nganhGoiY = $this->thuatToan([
                'left' => $giaThiet,
                'right' => []
            ], $tbLuat);
            $veTrai = [];
            foreach ($nganhGoiY as $key => $n) {
                if ($diaPhuong != 'all') {
                    array_push($veTrai, [$diaPhuong, $n]);
                } else array_push($veTrai, [$n]);
            }

            foreach ($veTrai as $key => $value) {
                $truongGoiYThem = $this->thuatToan([
                    'left' => $value,
                    'right' => []
                ], $tbLuat);
                $listTruongGoiY = array_merge($listTruongGoiY, $truongGoiYThem);
            }
            $listTruongGoiYThem = DB::table('suKien')->where('LoaiSuKien', 'Truong')->whereIn('ID_SuKien', $listTruongGoiY)->get('MoTaSuKien')->toArray();
            $listGoiYThem = [];
            foreach ($listTruongGoiYThem as $key => $value) {
                array_push($listGoiYThem, $value->MoTaSuKien);
            }

            $result['goiYThem'] = array_diff($listGoiYThem, $listGoiY);
            return successResponse($result);
        } else {
            return errorResponse('Bạn cần nhập đầy đủ thông tin!');
        }
    }

    public function thuatToan($data, $tbLuat)
    {
        $result = [];
        foreach ($tbLuat as $key => $rule) {
            $ruleDefined = [
                'left' => [],
                'right' => [],
            ];
            $tg = explode('>', $rule->NoiDung);
            // left:
            $ruleDefined['left'] = explode('^', $tg[0]);

            $ruleDefined['right'] = explode(',', $tg[1]);
            $isSave = $this->KiemTra($data['left'], $ruleDefined['left']);
            if ($isSave && !in_array($ruleDefined['right'][0], $result)) {
                array_push($result, $ruleDefined['right'][0]);
            }
        }
        return $result;
    }

    public function KiemTra($a, $b)
    {
        foreach ($a as $key => $field) {
            if (!in_array($field, $b)) return false;
        }
        return true;
    }

    public function TimTapSAT($L, $tapluat) //
    {
        $SAT = [];
        foreach ($tapluat as $lTG) {
            //kiểm tra từng luật xem có thỏa mãn với sự kiện nhập vào ban đầu không - có thì add vào tập SAT
            if ($this->KiemTra($lTG['VeTrai'], $L) == true && in_array($lTG, $SAT)) {
                array_push($SAT, $lTG);
            }
        }
        return $SAT;
    }
}
