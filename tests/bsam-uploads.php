<?php
/***********************************************************
 Copyright (C) 2008 Hewlett-Packard Development Company, L.P.

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 version 2 as published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 ***********************************************************/

/**
 * bsam-uploads.php
 *
 *\brief (deprecated) bsam uploads.  Used by other tests to make sure
 * bsam  license counts are correct.  Sets mime, metadata and bsam license.
 *
 * @param URL obtained from the test enviroment globals
 *
 * @version "$Id: uplTestData.php 2472 2009-08-24 19:35:52Z rrando $"
 *
 * Created on Aug 15, 2008
 */

/* Upload the following files from the fosstester home directory:
 * - simpletest_1.0.1.tar.gz
 * - gplv2.1
 * - Affero-v1.0
 * - http://www.gnu.org/licenses/gpl-3.0.txt
 * - http://www.gnu.org/licenses/agpl-3.0.txt
 */

//require_once '/usr/local/simpletest/autorun.php';
require_once ('fossologyTestCase.php');
require_once ('TestEnvironment.php');

global $URL;
global $PROXY;

class uploadTestDataTest extends fossologyTestCase
{
  public $mybrowser;
  public $webProxy;

    function setUp()
  {
    global $URL;
    $this->Login();
  }

  /**
   * create the Testing folder used by other tests
   */
  function testCreateTestingFolder()
  {
    global $URL;
    print "Creating Testing folder\n";
    $page = $this->mybrowser->get($URL);
    $this->createFolder(null, 'Testing', null);
  }

  function testuploadTestDataTest() {

    global $URL;
    global $PROXY;

    print "starting testUploadTestData\n";
    $rootFolder = 1;
    $upload = NULL;
    $uploadList = array('TestData/archives/fossI16L518.tar.bz2',
                        'TestData/archives/foss23D1F1L.tar.bz2',
                        'TestData/licenses/gplv2.1',
                        'TestData/licenses/Affero-v1.0');
    $urlList = array('http://downloads.sourceforge.net/simpletest/simpletest_1.0.1.tar.gz',
                     'http://www.gnu.org/licenses/gpl-3.0.txt',
                     'http://www.gnu.org/licenses/agpl-3.0.txt',
                     'http://osrb-1.fc.hp.com/~fosstester/fossDirsOnly.tar.bz2');

    /* upload the archives using the upload from file menu */

    print "Starting file uploads\n";
    foreach($uploadList as $upload) {
      $description = "File $upload uploaded by Upload Test Data Test";
      $this->uploadFile('Testing', $upload, $description, null, '1,2,6');
    }
    /* Upload the urls using upload from url.  Check if the user specificed a
     * web proxy for the environment.  If so, set the attribute. */
    if(!(empty($PROXY)))
    {
      $this->webProxy = $PROXY;
    }
    print "Starting Url uploads\n";
    foreach($urlList as $url)
    {
      $this->uploadUrl($rootFolder, $url, null, null, '1,2,6');
    }
  }
}
?>