<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $jobFile;
    
    public function rules()
    {
        return [
            [['jobFile'], 'file', 'skipOnEmpty' => false],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $a=1;
//            $this->jobFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
    
    public function parseJob()
    {
        $filename = $this->jobFile->tempName;
        
        // Проверяем наличие файла
        if (!file_exists($filename) ){
            echo "Файл или директория не существует";
            exit;
        }
        
        // Открываем файл и считываем информацию построчно
        $f = fopen($filename, "r") or die("Не могу открыть файл!");
        // Парсим файл построчно и перекодируем в UTF-8
        $lines = [];
        while ($line = fgets($f)){
            mb_detect_order("cp1251");
            $enc = mb_detect_encoding($line);
            $line = iconv($enc, "UTF-8", $line);
            $lines[] = $line;
        }
        fclose($f);
        $nesting = new Nesting();
        $geos = [];
        // Вытягивание необходимых данных из строк
        for ($i = 0; $i < count($lines); $i++){
            $line = $lines[$i];
            if(stristr($line, 'Имя файла')) {
                $start = strrpos($line, ":")+1;
                $nesting->name = str_replace(" ", "",(substr ($line, $start)));
                continue;
            }
            if(stristr($line, 'Лист')) {
                $start = strrpos($line, ":")+1;
                $end = strpos($line, "S");
                $nesting->material = trim(substr ($line, $start, $end-$start));
                $start = strrpos($line, "S =")+3;
                $end = strpos($line, "X");
                $nesting->s = trim(substr ($line, $start, $end-$start));
                $start = strrpos($line, "X =")+3;
                $end = strpos($line, "Y");
                $nesting->x = (int)trim(substr ($line, $start, $end-$start));
                $start = strrpos($line, "Y =")+3;
                $nesting->y = (int)trim(substr ($line, $start));
                continue;
            }
            if(stristr($line, 'листов')) {
                $start = strpos($line, ":")+1;
                $end = strpos($line, "Д");
                $nesting->count = trim(substr ($line, $start, $end-$start));
                continue;
            }
            // Чтение инструментов
            if(stristr($line, '-----')) {
                $i++;
                $nesting->tools .= $lines[$i];
                while((stristr($lines[$i+1], '-----') == FALSE) and ($i < 50)){
                    $i++;
                    $nesting->tools .= $lines[$i];
                }
                $i++;
                continue;
            }
            
            if(stristr($line, 'Обрабат')) {
                // Формирование массива GEO-файлов
                $i+=2;
                while((stristr($lines[$i+1], 'ЭФФЕК') == FALSE) and ($i < 50)){
                    if ($lines[$i] != '') {
                        $geo = new Geo();
                        // Разбиваем GEO
                        $end = strpos($lines[$i], ":");
                        $geo->name = trim(substr ($lines[$i], 0, $end));
                        $start = strpos($lines[$i], "Size", $end)+4;
                        $end = strpos($lines[$i], "x", $start);
                        $geo->x = trim(substr ($lines[$i], $start, $end-$start));
                        $start = strpos($lines[$i], "x", $end)+1;
                        $end = strpos($lines[$i], ",", $start);
                        $geo->y = trim(substr ($lines[$i], $start, $end-$start));
                        $start = strrpos($lines[$i], "=", $end)+1;
                        $geo->count = (int)trim(substr ($lines[$i], $start));
                        $geos[] = $geo;
                    }
                    $i++;
                }
                $i++;
                continue;
            }
            
            if(stristr($line, 'Всего времени')) {
                $start = strpos($line, "=")+1;
                $end = strpos($line, "min");
                $minutes = (int)trim(substr ($line, $start, $end-$start));
                $start = strpos($line, ",")+1;
                $end = strpos($line, "sec");
                $seconds = (int)trim(substr ($line, $start, $end-$start));
                $hours = (int)($minutes / 60);
                $minutes = $minutes % 60;
                $nesting->time = date("H:i:s", mktime($hours, $minutes, $seconds));
                continue;
            }
        }
        
        $_SESSION['nesting'] = $nesting;
        $_SESSION['geos'] = $geos;
    }
}