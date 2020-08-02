<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'third_party/fpdf/fpdf.php');

class PDF_Asignacion_Traslado extends FPDF
{
    public $widths;
    public $aligns;
    public $title;
    public $cCosto;
    public $cCosto2;
    public $userPrint;
    public $ONIUser;
    public $numDocumento;
    public $tipoDocumento;

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
        $this->SetFont('Arial', 'B', 225);
        $this->SetTextColor(212, 212, 212);
        if(strlen($this->ONIUser)<= 5){
            $this->SetFont('Arial', 'B', 310);
            $this->RotatedText(65, 210, $this->ONIUser, 25);
        } else {
            $this->RotatedText(50, 208, $this->ONIUser, 25);
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
        $this->SetFont('Arial', 'B', 10);
        $this->Text(152, 10, 'POLICIA NACIONAL CIVIL');
        $this->Text(153, 15, 'DIVISION DE LOGISTICA');
        $this->Text(145, 20, 'DEPARTAMENTO DE ACTIVO FIJO');
        $this->Text(130, 30, 'FORMULARIO DE '.$this->tipoDocumento.' DE MOBILIARIO Y EQUIPO');

        $this->SetFont('Arial', '', 8);
        $this->Text(12, 37, 'FECHA : '.date('d/m/Y'));

        $this->Text(45, 37,'UNIDAD SOLICITANTE: ');
        $this->Text(78, 37, trim($this->cCosto->NOM_COS));
        $this->Text(175, 37,'TRASLADADO A: ');
        $this->Text(203, 37, $this->cCosto2);

        /*
        $this->SetFont('Arial', '', 8);
        $this->Text(228, 8, 'Pag. '.$this->PageNo().' de {nb}');
        $this->Text(228, 12, 'FECHA : '.date('d/m/Y'));
        $this->Text(228, 15.5, 'HORA : '.date('H:i:s'));
        $this->Text(228, 19, 'USUARIO : '.$this->userPrint);
        $this->SetDrawColor(0, 0, 0);
        $this->Text(10, 25,'Centro de Costo:');
        $this->Text(45, 25, $this->cCosto->CCOSTO);
        $this->Text(10, 29,'Nombre de la Unidad:');
        $this->Text(45, 29, trim($this->cCosto->NOM_COS));*/
        $this->SetFont('Arial', 'B', 10);
        $this->Text(333, 24, 'AF-2');
        $this->Text(297, 29, 'Documento No. ');
        $this->SetFont('Arial', 'B', 9);
        $this->Text(330, 29, $this->numDocumento);
        $this->SetFont('Arial', '', 8);
        //$this->Text(10, 34,utf8_decode('Los bienes que se detallan a continuación los utilizaré exclusivamente para la ejecución de mis atribuciones comprometiendome a darle buen uso; asumiré las responsabilidades en el caso'));
        //$this->Text(10, 38,utf8_decode('de perdida por descuido, daño o uso inadecuado de estos bienes.'));
        $this->SetFont('Arial', '', 7);
        
        $altoEncab = 5;
        $this->SetY(40);
        #$this->ln(30);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10,$altoEncab,'No',1,0,'C');
        $this->Cell(35,$altoEncab,'CODIGO DE INVENTARIO',1,0,'C');
        $this->Cell(55,$altoEncab,'DESCRIPCION DEL BIEN',1,0,'C');
        $this->Cell(30,$altoEncab,'MARCA',1,0,'C');
        $this->Cell(25,$altoEncab,'MODELO',1,0,'C');
        $this->Cell(25,$altoEncab,'No DE SERIE',1,0,'C');
        $this->Cell(25,$altoEncab,'No CHASIS',1,0,'C');
        $this->Cell(25,$altoEncab,'No DE EQUIPO',1,0,'C');
        $this->Cell(25,$altoEncab,'No DE SERIE',1,0,'C');
        $this->Cell(30,$altoEncab,'VALOR',1,0,'C');
        $this->Cell(45,$altoEncab,'OBSERVACIONES',1,1,'C');
        #$this->ln(1);
        $this->SetFont('Arial', '', 8);

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
        return new PDF_Asignacion_Traslado();
    }
}
