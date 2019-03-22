<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Box;
use App\Model\SpaceSmall;
use App\Model\Shelves;
use App\Model\TypeSize;
use Carbon\Carbon;
use DB;

class InsertController extends Controller
{
    
    protected $space, $shelves, $box;
    
    public function __construct()
    {
       $this->space   = 'SPACE.csv';
       $this->box     = 'Box.csv';
       $this->shelves = 'SHELVES.csv';
      //  $file = public_path('assets/namafile.csv');
    }

    public function insert(Request $request)
    {
      $bool = [];
      switch ($request->name) {
        case 'box':
        $file = public_path('assets\\' . $this->box);
        return response()->json($file, 200);
        $bool = self::insertBox($file);
          break;
          
        case 'space':
        $file = public_path('assets\\' . $this->space);
        return response()->json($file, 200);
        $bool = self::insertSpace($file);
          break;

        case 'shelves':
        $file = public_path('assets\\' . $this->shelves);
        return response()->json($file, 200);
        $bool = self::insertShelves($file);
          break;
        
        default:

          break;
      }

      if (!$bool) {
        return response()->json(['success' => 'true'], 200);
      }
      return response()->json(['error' => $bool], 422);
    }

    public function insertBox($filename)
    {
      // {
      //   "Shelves_name": "Shelf A",
      //   "Types_of_size_id": "1",
      //   "Code_box": "0101A010101",
      //   "Name": "0101A010101",
      //   "Barcode": "0101A010101",
      //   "Location": "Shelf A",
      //   "Status_id": "10"
      // }
      $msg = null;
      $data = self::csvToArray($filename);
      // return $data;
      // $sh = Shelves::where('name', $data[0]['Shelves_name'])->first();
      // return $sh;

      DB::beginTransaction();
      try {
        foreach ($data as $key => $value) {
          $sh = Shelves::where('name', $value['Shelves_name'])->first();
          if (!$sh) throw new Exception("Error Processing Request");
          
          $shelves_id = $sh->id;
          Box::create([
            'shelves_id'       => $shelves_id,
            'types_of_size_id' => $value['Types_of_size_id'],
            'name'             => $value['Name'],
            'barcode'          => $value['Barcode'],
            'location'         => $value['Location'],
            'status_id'        => $value['Status_id'],
            'code_box'         => $value['Code_box']
          ]);
        }
        DB::commit();
      } catch (\Exception $th) {
        DB::rollback();
        $msg = $th->getMessage();
      }
      return $msg;
    }

    public function insertSpace($filename)
    {
      // {
      //   "code_space_small": "0101AS01",
      //   "Shelves_name": "Shelf A", change to shelves id
      //   "Types_of_size_id": "4",
      //   "Name": "0101AS01",
      //   "Barcode": "0101AS01",
      //   "Location": "Shelf A",
      //   "Status ID": "10"
      // }
      $msg = null;
      $data = self::csvToArray($filename);
      // $sh = Shelves::where('name', $data[0]['Shelves_name'])->first();
      // return $sh;

      DB::beginTransaction();
      try {
        foreach ($data as $key => $value) {
          $sh = Shelves::where('name', $value['Shelves_name'])->first();
          if (!$sh) throw new Exception("Error Processing Request");
          
          $shelves_id = $sh->id;
          SpaceSmall::create([
            'code_space_small' => $value['code_space_small'],
            'shelves_id'       => $shelves_id,
            'types_of_size_id' => $value['Types_of_size_id'],
            'name'             => $value['Name'],
            'barcode'          => $value['Barcode'],
            'location'         => $value['Location'],
            'status_id'        => $value['Status ID']
          ]);
        }
        DB::commit();
      } catch (\Exception $th) {
        DB::rollback();
        $msg = $th->getMessage();
      }
      return $msg;
    }

    public function insertShelves($filename)
    {
      // {
      //   "Name": "Shelf A",
      //   "Area": "34",
      //   "Code shelves": "0101A"
      // }
      $msg = null;
      $data = self::csvToArray($filename);

      DB::beginTransaction();
      try {
        foreach ($data as $key => $value) {
          $ids = Shelves::create([
            'name'         => $value['Name'],
            'area_id'      => $value['Area'],
            'code_shelves' => $value['Code shelves']
          ]);
        }
        DB::commit();
      } catch (\Exception $th) {
        DB::rollback();
        $msg = $th->getMessage();
      }
      return $msg;
    }

    protected function csvToArray($filename = '', $delimiter = ',')
    {
      if (!file_exists($filename) || !is_readable($filename)) return false;
      $header = null;
      $data = array();
      if (($handle = fopen($filename, 'r')) !== false) {
          while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
              if (!$header) $header = $row;
              else $data[] = array_combine($header, $row);
              // $arrs = array();
              // $arrs[0] = $row[0];
              // $arrs[1] = $row[1];
              // $arrs[2] = $row[2];
              // $arrs[3] = $row[3];
              // $arrs[4] = $row[4];
              // $arrs[5] = $row[5];
              // $url = $row[6];
              // $url = "https://www.tavest.com/uploads/960-17121userProfPic-Verification-IDCard.jpg";
              // $img = substr($url, strrpos($url, '/') + 1);
              // $arrs[6] = $img;
              // $data[] = $arrs;
          }
          fclose($handle);
      }
      return $data;
    }

}
