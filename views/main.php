<?php
$pdf = new Pdf;

$allPdfFile = $pdf->getFile();
foreach ($allPdfFile as $pdfFile) {
    $pdfFileName = basename($pdfFile);
    if (!file_exists($config['imgPath'] . $pdfFileName . "png")) {
	    $pdf->pdf2png($pdfFile);
    }
}
$allPdfPng = $pdf->getImages();
?>

<div class="container">
    <div class="row">
        <?php
        foreach ($allPdfPng as $pdfPath) {
            echo "<div class='col-lg-2 col-md-3 col-sm-4 col-xs-6'>";
            echo "<img class='img-responsive' src='{$pdfPath}' style='height:200px'>";
            $pdfName = explode('.pdf.png', explode('/', $pdfPath)[2]);
            echo "{$pdfName[0]}";
            echo "</div>";
        }
        ?>
    </div>
</div>
