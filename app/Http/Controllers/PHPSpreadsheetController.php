<?php

namespace App\Http\Controllers;

use App\Models\Asses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PHPSpreadsheetController extends Controller
{
    public function index()
    {
        $exampleExcelFile = asset('docs/data.xlsx');
        return Inertia::render('Excel/Import', [
            'exampleExcelFile' => $exampleExcelFile
        ]);
    }

    public function preview(Request $request)
    {
        // return $request->all();
        if ($request->base64_excel_file) {
            $type = explode('.', $request->base64_excel_file_name);
            $file_name = uniqid().time().".".end($type);
            $path = "docs/" . $file_name;
            $base64 = file_get_contents($request->base64_excel_file);
            Storage::put($path, $base64);
            $name = Storage::url($path);
        }
        else {
            $name = public_path('docs/data.xlsx');
        }

        $reader = IOFactory::createReader("Xlsx");
        $reader->setLoadAllSheets();
        $spreadsheet = $reader->load($name);
        $worksheet = $spreadsheet->getActiveSheet(); //Selecting The Active Sheet
        $highest_row = $worksheet->getHighestRow();
        $highest_col = "H";

        $highest_cell = $highest_col . $highest_row;
        $rang = "A2:" . $highest_cell; // Selecting The Cell Range

        $dataToArray = $spreadsheet->getActiveSheet()->rangeToArray(
            $rang,              // The worksheet range that we want to retrieve
            NULL,       // Value that should be returned for empty cells
            TRUE, // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
            TRUE,      // Should values be formatted (the equivalent of getFormattedValue() for each cell)
            TRUE      // Should the array be indexed by cell row and cell column
        );
        $fields = ["e_tin", "tin_date", "asses_name", "mobile", "address", "police_station", "old_tin", "circle_name"];
        $data = array_map(function ($row) use ($fields) {
            //Combining key value pair;
            return array_combine($fields, $row);
        }, $dataToArray);

        //return $data;
        $data = array_map(function ($item) {
            if (trim($item["tin_date"]) != null) {
                $d = Carbon::createFromFormat("d/m/Y", $item["tin_date"]);
                $item["tin_date"] = $d->format("Y-m-d");
            }
            return $item;
        }, $data);

        ($request->file('file')) && Storage::disk('public')->exists($path) ? Storage::disk('public')->delete($path) : '';
        // return $data;
        return Inertia::render('Excel/Import', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'data' => 'required'
        ]);
        $data = json_decode($request->data, true);
        $asses = array_map(function ($row) {
            $row['created_at'] = now();
            $row['updated_at'] = now();
            return $row;
        }, $data);

        Asses::insert($asses);
        return back()->with("success", "Data Successfully Imported");
    }

    public function show()
    {
        $asses = Asses::all();
        return view('excel-export', compact('asses'));
    }

    public function export(Request $request)
    {

        $data[0] = [
            'sl'              => 'SL',
            'e_tin'           => 'e-TIN',
            'tin_date'        => 'TIN Date',
            'asses_name'      => 'Asses Name',
            'mobile'          => 'Mobile',
            'address'         => 'Address',
            'police_station'  => 'Police Station',
            'old_tin'         => 'Old TIN',
            'circle_name'     => 'Circle Name',
        ];

        $records = Asses::all();

        foreach ($records as $index => $row) {
            $record = [
                'sl'             => $index + 1,
                'e_tin'          => $row->e_tin,
                'tin_date'       => date("d/m/Y", strtotime($row->tin_date)),
                'asses_name'     => $row->asses_name,
                'mobile'         => $row->mobile,
                'address'        => $row->address,
                'police_station' => $row->police_station,
                'old_tin'        => $row->old_tin,
                'circle_name'    => $row->circle_name,
            ];

            $data[$index + 1] = $record;
        }
        // create spreadsheet object
        $spreadsheet = new Spreadsheet();

        // add dataset
        $spreadsheet->getActiveSheet()->fromArray($data);

        // create xlsx file
        $writer = new Xlsx($spreadsheet);
        $path = public_path('data/Assessees-list-' . time().'.xlsx');
        $writer->save($path);
        return response()->download($path);
    }
}
