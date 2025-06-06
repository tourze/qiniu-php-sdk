<?php
namespace Qiniu\Tests;

use PHPUnit\Framework\TestCase;
use Qiniu\Processing\Operation;

class FopTest extends TestCase
{
    public function testExifPub()
    {
        $fop = new Operation('sdk.peterpy.cn');
        list($exif, $error) = $fop->execute('gogopher.jpg', 'exif');
        $this->assertNull($error);
        $this->assertNotNull($exif);
    }

    public function testExifPrivate()
    {
        global $testAuth;
        $fop = new Operation('private-res.qiniudn.com', $testAuth);
        list($exif, $error) = $fop->execute('noexif.jpg', 'exif');
        $this->assertNotNull($error);
        $this->assertNull($exif);
    }

    public function testbuildUrl()
    {
        $fops = 'imageView2/2/h/200';
        $fop = new Operation('testres.qiniudn.com');
        $url = $fop->buildUrl('gogopher.jpg', $fops);
        $this->assertEquals($url, 'http://testres.qiniudn.com/gogopher.jpg?imageView2/2/h/200');

        $fops = array('imageView2/2/h/200', 'imageInfo');
        $url = $fop->buildUrl('gogopher.jpg', $fops);
        $this->assertEquals($url, 'http://testres.qiniudn.com/gogopher.jpg?imageView2/2/h/200|imageInfo');
    }
}
