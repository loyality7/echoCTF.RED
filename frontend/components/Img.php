<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * This is the model class for generating and manipulating images.
 *
 */
class Img extends Component
{
      public static function profile($profile)
      {
        $fname=Yii::getAlias(sprintf('@app/web/images/avatars/%s',$profile->avtr));

        $image = imagecreatetruecolor(800,220);
        if($image===false) return false;

        imagealphablending($image, false);
        $col=imagecolorallocatealpha($image,255,255,255,127);
        $textcolor = imagecolorallocate($image, 255, 255, 255);
        $consolecolor = imagecolorallocate($image, 148,148,148);
        $greencolor = imagecolorallocate($image, 148,193,31);

        imagefilledrectangle($image,0,0,800, 220,$col);
        imagefilledrectangle($image,20,20,180, 180,$greencolor);
        imagealphablending($image,true);

        $src = imagecreatefrompng($fname);
        if($src===false) return false;

        $x=160;
        $avatar=imagescale($src,$x);
        if($avatar===false) return false;

        imagecopyresampled($image, $avatar, /*dst_x*/ 20, /*dst_y*/ 20, /*src_x*/ 0, /*src_y*/ 0, /*dst_w*/ $x, /*dst_h*/ $x, /*src_w*/ $x, /*src_y*/ $x);
        imagealphablending($image,true);

        $cover = imagecreatefrompng(Yii::getAlias('@app/web/images/badge.tpl.png'));
        if($cover===false) return false;

        imagecopyresampled($image, $cover, 0, 0, 0, 0, 800, 220, 800, 220);
        imagealphablending($image,true);


        imagealphablending($image, false);
        imagesavealpha($image, true);

        $lineheight=20;
        $i=1;
        imagestring($image, 6, 200, $lineheight*$i++, sprintf("root@echoctf.red:/# ./userinfo --profile %d",$profile->id),$textcolor);
        imagestring($image, 6, 200, $lineheight*$i++, sprintf("username.....: %s",$profile->owner->username),$greencolor);
        imagestring($image, 6, 200, $lineheight*$i++, sprintf("joined.......: %s",date("d.m.Y", strtotime($profile->owner->created))),$greencolor);
        imagestring($image, 6, 200, $lineheight*$i++, sprintf("points.......: %s",number_format($profile->owner->playerScore->points)),$greencolor);
        imagestring($image, 6, 200, $lineheight*$i++, sprintf("rank.........: %s",$profile->rank->ordinalPlace),$greencolor);
        imagestring($image, 6, 200, $lineheight*$i++, sprintf("level........: %d / %s",$profile->experience->id, $profile->experience->name),$greencolor);
        imagestring($image, 6, 200, $lineheight*$i++, sprintf("flags........: %d", $profile->totalTreasures),$greencolor);
        imagestring($image, 6, 200, $lineheight*$i++, sprintf("headshots....: %d",$profile->headshotsCount),$greencolor);
        imagedestroy($avatar);
        imagedestroy($cover);
        imagedestroy($src);

        return $image;
      }
}