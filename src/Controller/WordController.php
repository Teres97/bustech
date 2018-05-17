<?php

namespace App\Controller;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WordController extends Controller
{
    /**
     * @route ("/word", name="word")
     */
    public function index(Request $request)
    {
        $phpWord = new PhpWord();

        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);
        $section = $phpWord->addSection();
        $username = $request ->request->get("username");
        $adress = $request ->request->get("adress");
        $text = $request ->request->get("text");
        $fontStyle = array('align'=> 'end');
        // Adding Text element to the Section having font styled by default...
        $section->addText(
            '  В Администрацию города Калининграда 
            '
            . 'Калининград, пл.Победы, 1 
            ', $fontStyle
        );
        $fontStyle = array('align'=>'both');
        $section ->addText(
            "   Я,  , проживаю по адресу: $adress."
            . "$text"
            . " Настоящим прошу рассмотреть обозначенный выше вопрос. Пожалуйста, примите решение по этой информации."
            . " О принятом решении прошу сообщить письменно по указанному мной адресу.",$fontStyle
        );
        $fontStyle = array('align'=>'start');
        $section ->addText(
            "$username",$fontStyle
        );
        // Saving the document as OOXML file...
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $date = date("d-m-y-H-i-s");
        // Create a temporal file in the system
        $fileName = "file_$date.docx";
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Write in the temporal filepath
        $objWriter->save($temp_file);

        // Send the temporal file as response (as an attachment)
        $response = new BinaryFileResponse($temp_file);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );

        return $response;
    }

}
