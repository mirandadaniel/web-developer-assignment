<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function exportCsv()
    {
        $books = Book::all(); 
        $data = [
            ['Title', 'Author'],
        ];

        foreach ($books as $book) {
            $data[] = [$book->title, $book->author];
        }

        $csvFileName = 'books.csv';
        $csvFileContents = implode(PHP_EOL, array_map(function ($row) {
            return implode(',', $row);
        }, $data));

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        return Response::make($csvFileContents, 200, $headers);
    }

    public function exportXml()
    {
        $books = Book::all();
        $data = [];

        foreach ($books as $book) {
            $data[] = [
                'Title' => $book->title,
                'Author' => $book->author,
            ];
        }


        $xmlFileName = 'books.xml';

        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('books');

        foreach ($data as $row) {
            $xml->startElement('book');
            foreach ($row as $key => $value) {
                $xml->writeElement($key, $value);
            }
            $xml->endElement();
        }

        $xml->endElement();
        $xml->endDocument();

        $headers = [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="' . $xmlFileName . '"',
        ];

        return Response::make($xml->outputMemory(), 200, $headers);
    }
}