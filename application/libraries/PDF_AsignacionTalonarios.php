<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'third_party/fpdf/fpdf.php');

class Pdf_AsignacionTalonarios extends FPDF
{
    public $widths;
    public $aligns;
    public $title;
    public $cCosto;
    public $userPrint;
    public $ONIUser;
    public $numDocumento;
    public $tipoDocumento;
    public $fecha;
    public $data = [];
    public $angle=0;

    public function Rotate($angle, $x=-1, $y=-1)
    {
        if ($x==-1) {
            $x=$this->x;
        }
        if ($y==-1) {
            $y=$this->y;
        }
        if ($this->angle!=0) {
            $this->_out('Q');
        }
        $this->angle=$angle;
        if ($angle!=0) {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    public function _endpage()
    {
        if ($this->angle!=0) {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    public function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    

    public function Header()
    {
        //$this->WaterMark();
        
        $this->WaterMark();
        $margenTabla = 100;
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 8);
        $fecha = $this->actual_date();
        $this->Text(15, 15, 'POLICIA NACIONAL CIVIL');
       
        $this->Text(15, 20, 'DIVISION DE CONTROL VEHICULAR');
        $this->Text(15, 25, 'ASIGNACION DE ESQUELAS');
        $this->Text(120, 15, 'BOLETA DE CONTROL "B" ENTREGA DE TALONARIO');
        $this->Text(120, 20, 'DE ESQUELAS DE INFRACCIONES A JEFES DE DIVISIONES');
        $this->Text(120, 25, 'DELEGACIONES, DEPARTAMENTOS U OTRAS UNIDADES.');
        $this->SetFont('Arial', '', 9);
        $this->Text(80, 40, "FECHA: ".$fecha);
        
        $altoEncab = 5;
        $this->SetY(50);
        $this->SetX(15);
        #$this->ln(30);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(180,$altoEncab,'DATOS SOBRE TALONARIO',1,0,'C');
        $this->SetY(55);
        $this->SetX(15);
        $this->Cell(180,$altoEncab,'NUMEROS DE SERIE DE ESQUELAS',1,0,'C');
        $this->SetY(60);
        $this->SetX(15);
        $this->Cell(10,$altoEncab,'n',1,0,'C');
        $this->Cell(40,$altoEncab,'INICIAL',1,0,'C');
        $this->Cell(40,$altoEncab,'FINAL',1,0,'C');
        $this->Cell(10,$altoEncab,'n',1,0,'C');
        $this->Cell(40,$altoEncab,'INICIAL',1,0,'C');
        $this->Cell(40,$altoEncab,'FINAL',1,0,'C');
        

        $this->SetY(65);
        //$this->SetX(15);
        
       
        

    }

    public function WaterMark()
    {
        $this->SetFont('Arial', 'B', 195);
        $this->SetTextColor(212, 212, 212);
        if(strlen($this->data->oniUsuario)<= 5){
            $this->SetFont('Arial', 'B', 275);
            $this->RotatedText(40, 270, $this->data->oniUsuario, 45);
        } else {
            $this->RotatedText(30, 270, $this->data->oniUsuario, 45);
        }

    }

    public function nuevaPagina(){
        $this->AddPage('L', 'Letter');
    }

    public function generarTabla1(){
        $sety = 100;
        $setx = 15;
        $corr = 0;
        for($i=0;$i < count($this->data->data); $i++){
            $ancho = 10;
            $sety += 5;
            $setx = 15;
            $this->SetX(15);
            $this->SetY($sety);
                $this->Row($this->data->data[$i],0);
                $this->SetX(25);   
        }
    }

    
    public function generarTabla(){
        $sety = 100;
        $setx = 15;
        for($i=0;$i < count($this->data->data); $i++){
            $ancho = 10;
            $sety += 5;
            $setx = 15;
            $this->SetX(15);
            $this->SetY($sety);
            for($y=0;$y < 3; $y++){
                
                $this->SetX($setx);
                $this->Cell($ancho,5,$this->data->data[$i][$y],1,0,'C');
                $ancho = 40;
                
                
                if($y == 1){
                    $setx = 65;
                }else{
                    $setx = 25;
                }
               
            }
        }
    }

    public function Body(){
        $this->Text(20, 235, utf8_decode("Autorizado:"));
    }

    public function footer(){
        
    }
    
    public function data($datos)
    {
        //Set the title to the report
        $this->data=$datos;
    }
    public function SetOniEntrega($oni)
    {
        //Set the title to the report
        $this->oni_entrega=$oni;
    }

    public function nombreAsignado($nombreAsignado)
    {
        //Set the title to the report
        $this->nombreAsignado = $nombreAsignado;
    }

    
/*
    public function SetTitle($t)
    {
        //Set the title to the report
        $this->title=$t;
    }
*/
    public function SetDocumento($doc){
        $this->numDocumento=$doc;
    }

    public function SetTipoDocumento($tipo){
        $this->tipoDocumento=$tipo;
    }

    public function SetCCosto($cc)
    {
        //Establecer la matriz de anchos de columna
        $this->cCosto=$cc;       
    }

    public function SetCCosto2($cc2)
    {
        //Establecer la matriz de anchos de columna   
        $this->cCosto2=$cc2;      
    }

    public function SetWidths($w)
    {
        //Establecer la matriz de anchos de columna
        $this->widths=$w;
    }

    public function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    public function actual_date ()  
{  
    $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
    $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");  
    $year_now = date ("Y");  
    $month_now = date ("n");  
    $day_now = date ("j");  
    $week_day_now = date ("w");  
    $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;   
    return $date;    
} 

    public function RowHeader($data)
    {
        //Calculate the height of the row
        $nb=0;
        for ($i=0;$i<count($data);$i++) {
            $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h=2*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //$this->SetFont('Arial', 'B', 8);
        //$this->Text($this->GetX(), $this->GetY() - 2, trim($this->title));
        $this->SetFont('Arial', 'B', 7);
        //Draw the cells of the row
        for ($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
           // $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 3, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        $this->SetFont('Arial', '', 7);
        //Go to the next line
        $this->Ln($h);
    }

    public function RowTotal($data)
    {
        //Calculate the height of the row
        $nb=0;
        for ($i=0;$i<count($data);$i++) {
            $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h=(3*$nb);
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //$this->SetFont('Arial', 'B', 8);
        //$this->Text($this->GetX(), $this->GetY() - 2, trim($this->title));
        $this->SetFont('Arial', 'B', 7);
        //Draw the cells of the row
        for ($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        #$this->SetFont('Arial', '', 3);
        //Go to the next line
        $this->Ln($h);
    }


    public function Row($data,$colorear)
    {
        //Calculate the height of the row
        $nb=0;
        for ($i=0;$i<count($data);$i++) {
            $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h=(3*$nb)+1;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Draw the cells of the row
        for ($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h+1);
            //Print the text
            $this->MultiCell($w, 4, $data[$i], 0, $a, $colorear);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h+1);
    }

    public function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY()+$h+1>$this->PageBreakTrigger) {
            $this->AddPage('P', 'Letter');
            $this->Header();
        }
    }

    public function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if ($w==0) {
            $w=$this->w-$this->rMargin-$this->x;
        }
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r", '', $txt);
        $nb=strlen($s);
        if ($nb>0 and $s[$nb-1]=="\n") {
            $nb--;
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while ($i<$nb) {
            $c=$s[$i];
            if ($c=="\n") {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if ($c==' ') {
                $sep=$i;
            }
            $l+=$cw[$c];
            if ($l>$wmax) {
                if ($sep==-1) {
                    if ($i==$j) {
                        $i++;
                    }
                } else {
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    

    public function getInstance()
    {
        return new Pdf_AsignacionTalonarios();
    }
}

