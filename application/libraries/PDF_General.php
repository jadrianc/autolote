<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'third_party/fpdf/fpdf.php');

class PDF_General extends FPDF
{
    public $widths;
    public $aligns;
    public $title;
    public $cCosto;
    public $userPrint;
    public $ONIUser;

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

    public function WaterMark()
    {
        $this->SetFont('Arial', 'B', 195);
        $this->SetTextColor(212, 212, 212);
        if(strlen($this->ONIUser)<= 5){
            $this->SetFont('Arial', 'B', 275);
            $this->RotatedText(45, 220, $this->ONIUser, 35);
        } else {
            $this->RotatedText(30, 218, $this->ONIUser, 35);
        }

    }

    public function Header()
    {
        $this->WaterMark();
        $logo =  base_url()."theme/dist/img/logo_pnc_alter.png";
        $this->Image($logo, 7, 5, 15);

        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 8);
        $this->Text(22, 10, 'PNC');
        $this->Text(22, 14, 'DEPARTAMENTO DE ACTIVO FIJO');
        $this->SetFont('Arial', 'B', 12);
        $this->Text(112, 9, 'POLICIA NACIONAL CIVIL');
        $this->SetFont('Arial', '', 8);
        $this->Text(96, 13, '* * VALORES EXPRESADOS EN DOLARES ESTADOUNIDENSES * * ');
        $this->Text(228, 8, 'Pag. '.$this->PageNo().' de {nb}');
        $this->Text(228, 12, 'FECHA : '.date('d/m/Y'));
        $this->Text(228, 15.5, 'HORA : '.date('H:i:s'));
        $this->Text(228, 19, 'USUARIO : '.$this->userPrint);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, 21, 267, 21);
        $this->SetFont('Arial', 'B', 9);
        $this->Text(10, 25, trim($this->cCosto->CCOSTO).' - '.trim($this->cCosto->NOM_COS));
        $this->Rect(10, 26, 257, 6, 'D');
        $this->SetFont('Arial', '', 7);
        $this->Text(11, 28.5, 'CLASE / SUBC.');
        $this->Text(11, 31.5, 'CORRELATIV.');
        $this->Text(32, 28.5, 'TIPO ADQ.');
        $this->Text(32, 31.5, 'FEC/INGRESO');
        $this->Text(55, 28.5, 'FEC. ASIG');
        $this->Text(55, 31.5, 'MODELO');
        $this->Text(71, 28.5, 'COMPROB.');
        $this->Text(71, 31.5, 'COTBLE.');
        $this->Text(91, 28.5, 'FACTURA');
        $this->Text(91, 31.5, 'OBSERV.');
        $this->Text(111, 28.5, 'MARCA');
        $this->Text(111, 31.5, '');
        $this->Text(128, 28.5, 'NOMBRE DEL PROVEEDOR');
        $this->Text(128, 31.5, 'FECHA DE DESCARGO');
        $this->Text(179, 28.5, 'SERIE');
        $this->Text(179, 31.5, 'FOLIO/ACTA');
        $this->Text(208, 28.5, 'MOTOR');
        $this->Text(208, 31.5, 'CHASIS');
        $this->Text(236, 28.5, 'No.AF1');
        $this->Text(236, 31.5, 'No. EQUIP.');
        $this->Text(252, 28.5, 'V.UNITARIO');
        $this->Text(252, 31.5, 'PLACA');
        $this->Ln(12);
    }

    public function SetUser($u, $o)
    {
        //Set the user to the report
        $this->userPrint=$u;
        $this->ONIUser=$o;
    }

    public function SetTitle($t)
    {
        //Set the title to the report
        $this->title=$t;
    }

    public function SetCCosto($cc)
    {
        //Set the array of column widths
        $this->cCosto=$cc;
    }

    public function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    public function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
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
            $this->MultiCell($w, 2, $data[$i], 0, $a);
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
        $h=3*$nb;
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
            $this->MultiCell($w, 3, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        $this->SetFont('Arial', '', 7);
        //Go to the next line
        $this->Ln($h);
    }


    public function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for ($i=0;$i<count($data);$i++) {
            $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h=2.8*$nb;
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
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 3, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    public function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY()+$h>$this->PageBreakTrigger) {
            $this->AddPage('L', 'Letter');
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
        return new PDF_General();
    }
}
