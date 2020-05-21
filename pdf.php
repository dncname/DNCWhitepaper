<?php
class Pdf{
	public $config;

	function __construct() {
		$this->config = require 'config.php';
	}

	/**
	 * @return array 该指定 pdf 路径下的指定文件类型的所有文件
	 */
	function getFile()
	{
		// 可以改 *.pdf 为 **/*.pdf
		return (glob($this->config['pdfPath'] . "*.pdf", GLOB_BRACE));
	}

	/**
	 * @return array 该指定图片路径下的所有 png 图片
	 */
	function getImages()
	{
		return (glob($this->config['imgPath'] . "*.png", GLOB_BRACE));
	}

	/**
	 * PDF2PNG
	 * @param $pdfPath string 待处理的PDF文件
	 * @param int $page string  待导出的页面 -1为全部 0为第一页 1为第二页
	 * @return string 保存好的图片路径和文件名
	 */
	function pdf2png($pdfPath, $page = 0)
	{
		$pdfFileName = basename($pdfPath);
		if (!is_dir($this->config['imgPath'])) {
			mkdir($this->config['imgPath'], true);
		}
		if (!extension_loaded('imagick')) {
			echo '没有找到imagick！';

			return false;
		}
		if (!file_exists($pdfPath)) {
			echo '没有找到pdf:'.$pdfPath;

			return false;
		}

		$im = new Imagick();
		$im->setResolution(300, 300); //设置图像分辨率
		try {
			// 设置读取 pdf 的第一页
			$im->readImage("{$pdfPath}[$page]");
		} catch (Exception $e) {
			echo "<script>console.log('《".$pdfPath."'+'》 还未上传好')</script>";

			return false;
		}

		$srcWH = $im->getImageGeometry(); //获取源图片宽和高

		//图片等比例缩放宽和高设置 ，根据宽度设置等比缩放
		$width = 400;
		if ($srcWH['width'] > $width) {
			$srcW['width']  = $width;
			$srcH['height'] = round($srcW['width'] / $srcWH['width'] * $srcWH['height']);
		} else {
			$srcW['width']  = $srcWH['width'];
			$srcH['height'] = $srcWH['height'];
		}

		$im->thumbnailImage($srcW['width'], $srcH['height'], true); //按照比例进行缩放

		$filename = $this->config['imgPath'] . $pdfFileName . '.png';

		if ($im->writeImage($filename) == true) {
			return $filename;
		} else {
			return false;
		}
	}

}
