<?php

/**
 * Imagettftextgradient v1.0.3
 *
 * Copyright (c) 2017-2018 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the
 * Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN
 * AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * PHP version 5
 *
 * @category  Andrewgjohnson
 * @package   Imagettftextgradient
 * @author    Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @copyright 2017-2018 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @license   https://opensource.org/licenses/mit/ The MIT License
 * @link      https://github.com/andrewgjohnson/imagettftextgradient
 */

if (!function_exists('imagettftextgradient')) {
    /**
     * Imagettftextgradient is a drop in replacement for imagettftext with an added
     * parameter to add gradient coloring effects to your PHP GD images.
     *
     * @param resource $image          <p>An image resource, returned by one of the
     *    image creation functions, such as imagecreatetruecolor().</p>
     * @param float    $size           <p>The font size. Depending on your version
     *    of GD, this should be specified as the pixel size (GD1) or point size
     *    (GD2).</p>
     * @param float    $angle          <p>The angle in degrees, with 0 degrees being
     *    left-to-right reading text. Higher values represent a counter-clockwise
     *    rotation. For example, a value of 90 would result in bottom-to-top reading
     *    text.</p>
     * @param int      $x              <p>The coordinates given by x and y will
     *    define the basepoint of the first character (roughly the lower-left corner
     *    of the character). This is different from the imagestring(), where x and y
     *    define the upper-left corner of the first character. For example, "top
     *    left" is 0, 0.</p>
     * @param int      $y              <p>The y-ordinate. This sets the position of
     *    the fonts baseline, not the very bottom of the character.</p>
     * @param int      $color          <p>The color index. Using the negative of a
     *    color index has the effect of turning off antialiasing. See
     *    imagecolorallocate().</p>
     * @param string   $fontfile       <p>The path to the TrueType font you wish to
     *    use.</p><p>Depending on which version of the GD library PHP is using, when
     *    fontfile does not begin with a leading / then .ttf will be appended to the
     *    filename and the library will attempt to search for that filename along a
     *    library-defined font path.</p><p>When using versions of the GD library
     *    lower than 2.0.18, a space character, rather than a semicolon, was used as
     *    the 'path separator' for different font files. Unintentional use of this
     *    feature will result in the warning message: Warning: Could not find/open
     *    font. For these affected versions, the only solution is moving the font to
     *    a path which does not contain spaces.</p>
     * @param string   $text           <p>The text string in UTF-8 encoding.</p>
     *    <p>May include decimal numeric character references (of the form:
     *    &amp;#8364;) to access characters in a font beyond position 127. The
     *    hexadecimal format (like &amp;#xA9;) is supported.Strings in UTF-8
     *    encoding can be passed directly.</p><p>Named entities, such as &amp;copy;,
     *    are not supported. Consider using html_entity_decode to decode these
     *    named entities into UTF-8 strings.</p><p>If a character is used in the
     *    string which is not supported by the font, a hollow rectangle will
     *    replace the character.</p>
     * @param int      $gradient_color <p>The color index. Using the negative of a
     *    color index has the effect of turning off antialiasing. See
     *    imagecolorallocate().</p>
     *
     * @return mixed Returns an array with 8 elements representing four points
     * making the bounding box of the text. The order of the points is lower left,
     * lower right, upper right, upper left. The points are relative to the text
     * regardless of the angle, so "upper left" means in the top left-hand corner
     * when you see the text horizontally. Returns FALSE on error.
     */
    function imagettftextgradient(
        &$image,
        $size,
        $angle,
        $x,
        $y,
        $color,
        $fontfile,
        $text,
        $gradient_color = null
    ) {
        // $gradient_color needs to be an integer returned by imagecolorallocate();
        // if it is not we treat this function call identically to imagettftext
        if (!is_null($gradient_color) && is_int($gradient_color)) {
            // $return_array will be returned once all calculations are complete
            $return_array = [
                imagesx($image), // lower left, x coordinate
                -1,              // lower left, y coordinate
                -1,              // lower right, x coordinate
                -1,              // lower right, y coordinate
                -1,              // upper right, x coordinate
                imagesy($image), // upper right, y coordinate
                imagesx($image), // upper left, x coordinate
                imagesy($image)  // upper left, y coordinate
            ];

            // $temporary_image is a GD image that is the same size as our
            // original GD image
            $temporary_image = imagecreatetruecolor(
                imagesx($image),
                imagesy($image)
            );
            // fill $temporary_image with a black background
            imagefill(
                $temporary_image,
                0,
                0,
                imagecolorallocate($temporary_image, 0x00, 0x00, 0x00)
            );

            // add white text to $temporary_image with the function call's
            // parameters
            $temporary_text = imagettftext(
                $temporary_image,
                $size,
                $angle,
                $x,
                $y,
                imagecolorallocate($temporary_image, 0xFF, 0xFF, 0xFF),
                $fontfile,
                $text
            );
            if ($temporary_text !== false) {
                // calculate the text's top & bottom most pixels
                $text_top = min($temporary_text[5], $temporary_text[7]);
                $text_bottom = max($temporary_text[1], $temporary_text[3]);
                $text_height = $text_bottom - $text_top;

                // loop through each pixel in $temporary_image
                for ($_x = 0; $_x < imagesx($temporary_image); $_x++) {
                    for ($_y = 0; $_y < imagesy($temporary_image); $_y++) {
                        // $visibility is the grayscale of the current pixel
                        $visibility = (imagecolorat(
                            $temporary_image,
                            $_x,
                            $_y
                        ) & 0xFF) / 255;
                        // if the current pixel would not be invisible then add it to
                        // $image
                        if ($visibility > 0) {
                            // we know we are on an affected pixel so ensure
                            // $return_array is updated accordingly
                            $return_array[0] = min($return_array[0], $_x);
                            $return_array[1] = max($return_array[1], $_y);
                            $return_array[2] = max($return_array[2], $_x);
                            $return_array[3] = max($return_array[3], $_y);
                            $return_array[4] = max($return_array[4], $_x);
                            $return_array[5] = min($return_array[5], $_y);
                            $return_array[6] = min($return_array[6], $_x);
                            $return_array[7] = min($return_array[7], $_y);

                            // determine the current pixel's RGB color code & alpha
                            // value by first calculating its position within the
                            // text
                            $gradient_position = ($_y - $text_top) / $text_height;

                            $color_red = ($color >> 16) & 0xFF;
                            $color_red *= 1 - $gradient_position;
                            $gradient_color_red = ($gradient_color >> 16) & 0xFF;
                            $gradient_color_red *= $gradient_position;
                            $red = round($color_red + $gradient_color_red);

                            $color_green = ($color >> 8) & 0xFF;
                            $color_green *= 1 - $gradient_position;
                            $gradient_color_green = ($gradient_color >> 8) & 0xFF;
                            $gradient_color_green *= $gradient_position;
                            $green = round($color_green + $gradient_color_green);

                            $color_blue = $color & 0xFF;
                            $color_blue *= 1 - $gradient_position;
                            $gradient_color_blue = $gradient_color & 0xFF;
                            $gradient_color_blue *= $gradient_position;
                            $blue = round($color_blue + $gradient_color_blue);

                            $color_opacity = imagecolorsforindex(
                                $image,
                                $color
                            )['alpha'];
                            $color_opacity *= 1 - $gradient_position;
                            $gradient_color_opacity = imagecolorsforindex(
                                $image,
                                $gradient_color
                            )['alpha'];
                            $gradient_color_opacity *= $gradient_position;
                            $opacity = $color_opacity + $gradient_color_opacity;
                            $opacity = (127 - $opacity) / 127;

                            // set the current pixel in $image
                            imagesetpixel(
                                $image,
                                $_x,
                                $_y,
                                imagecolorallocatealpha(
                                    $image,
                                    $red,
                                    $green,
                                    $blue,
                                    (1 - $visibility) * 127 * $opacity
                                )
                            );
                        }
                    }
                }
            }

            // destroy our $temporary_image
            imagedestroy($temporary_image);

            return $return_array;
        } else {
            return imagettftext(
                $image,
                $size,
                $angle,
                $x,
                $y,
                $color,
                $fontfile,
                $text
            );
        }
    }
}