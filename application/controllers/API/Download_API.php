<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
class Download_API extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Product_Model");
        $this->load->language('product',$this->language);
    }


    public function DownloadSampleFile(){
        if(!empty($this->input->post('type_id'))){
            $type_id = $this->input->post('type_id');
            $result = $this->Product_Model->getSettingProductType(array("type_id"=>$type_id));
            if($result[0]){
                $this->getSampleFile($result[1]);
            }
            else
                echo json_encode($result);
        }
        else
            echo json_encode(array(false,lang('error_info_not_exist')));

    }
    private function getSampleFile($data){


        $spreadsheet = new Spreadsheet();

//Specify the properties for this document
        $spreadsheet->getProperties()
            ->setTitle('Product '.$data->type_name);

//Adding data to the excel sheet
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Code')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Category Code');
        $currentCell = 'C';
        $sets = json_decode(json_decode($data->settings),true);
        foreach($sets as $key=>$value){
            ++$currentCell;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($currentCell.'1', $key);
        }


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment;filename="type_'.$data->type_id.'_sample.csv"');

        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, "Csv"); //Xls is also possible

//    $writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'Csv');

        ob_end_clean();
        $writer->save('php://output');
    }
}
