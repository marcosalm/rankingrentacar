<?php
/**
 * GD
 * @author gabrielgomes
 */
class GD {

    public static function normalize($filename, $final_width = false, $final_height = false, $outputMode = 'landscape', $final_path = false) {
        $image = false;

        if (file_exists($filename)) {
            list($original_width, $original_height) = getimagesize($filename);

            $file_width = $original_width;
            $file_height = $original_height;

            $width_diference = abs($original_width - $final_width);
            $height_diference = abs($original_height - $final_height);

            $width_diference_percentual = (($width_diference * 100) / $original_width);
            $height_diference_percentual = (($height_diference * 100) / $original_height);

            $percent_parameter = $width_diference_percentual;
            $mode = 'vertical';
            if ($width_diference_percentual > $height_diference_percentual) {
                $mode = 'horizontal';
                $percent_parameter = $height_diference_percentual;
            }

            if ($outputMode == 'picture') {
                $mode = 'horizontal';
                $percent_parameter = $height_diference_percentual;
                if ($width_diference_percentual > $height_diference_percentual) {
                    $percent_parameter = $width_diference_percentual;
                    $mode = 'vertical';
                }
            }

            if (($file_width > $final_width) || ($file_height > $final_height)) {
                $file_width = ($original_width - ($original_width * $percent_parameter / 100));
                $file_height = ($original_height - ($original_height * $percent_parameter / 100));
            }

            if ($file_width < $final_width)
                $final_width = $file_width;

            if ($file_height < $final_height)
                $final_height = $file_height;

            $image = self::cut($filename, $file_width, $file_height, $final_width, $final_height, $mode);

            return $image;
        } else {
            die('Imagem não encontrada');
        }

        if ($image && $final_path) {
            imagejpeg($image, $final_path);
        }
        return $image;
    }

    public static function cut($filename, $file_width, $file_height, $final_width, $final_height, $mode = 'vertical') {

        $original_image = imagecreatefromjpeg($filename);

        list($original_width, $original_height) = getimagesize($filename);

        $file_image = imagecreatetruecolor($file_width, $file_height);
        $final_image = imagecreatetruecolor($final_width, $final_height);

        imagecopyresampled($file_image, $original_image, 0, 0, 0, 0, $file_width, $file_height, $original_width, $original_height);

        //return $file_image;

        $startX = $startY = 0;

        if ($mode == 'vertical') {
            $parameter = ($file_height - $final_height) / 2;
            $startY = $parameter;
        } else {
            $parameter = ($file_width - $final_width) / 2;
            $startX = $parameter;
        }

        imagecopy($final_image, $file_image, 0, 0, $startX, $startY, $final_width, $final_height);

        return $final_image;
    }

    public static function check() {
        if (Request::hasParameter(GD_KEY)) {
            $image = GD_Utils::decodePath(Request::getParameter('image'));

            $width = Request::getParameter('width');
            $height = Request::getParameter('height');
            $outputMode = Request::getParameter('outputMode');

            if (empty($outputMode))
                $outputMode = 'landscape';

            if (empty($width))
                $width = 9999;
            if (empty($height))
                $height = 9999;

            $basedir = GD_BASE_PATH;
            $filename = $basedir . $image;

            $image = self::normalize($filename, $width, $height, $outputMode);

            header('Content-Type: image/jpeg');
            imagejpeg($image, null, 100);
            die();
        }
    }

    public static function getDefaultSrc($width, $height, $outputMode = 'landscape') {
        return self::mountSrc(GD_DEFAULT_FILE, $width, $height, $outputMode);
    }

    public function mountSrc($pathURI, $width, $height, $outputMode = 'landscape') {
        $blogUrl = App::getBlogUrl();
        $encodedPathURI = GD_Utils::encodePath($pathURI);

        $return = $blogUrl . "/?image={$encodedPathURI}";
        if ($width)
            $return .= "&width={$width}";
        if ($height)
            $return .= "&height={$height}";

        if (!empty($outputMode))
            $return .= "&outputMode={$outputMode}";

        return $return;
    }

}