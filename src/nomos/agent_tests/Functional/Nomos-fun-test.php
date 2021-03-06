<?php
/***********************************************************
 Copyright (C) 2013 Hewlett-Packard Development Company, L.P.

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
 * \brief Perform nomos functional test
 */

require_once (dirname(dirname(dirname(dirname(__FILE__)))).'/testing/lib/createRC.php');


class NomosFunTest extends PHPUnit_Framework_TestCase
{
  public $nomos;
  public $testdir;

  function setUp()
  {
    $this->testdir = dirname(dirname(__FILE__)).'/testdata/NomosTestfiles';
    $this->assertFileExists($this->testdir,"NomoFunTest FAILURE! $this->testdir not found\n");
    createRC();
    $sysconf = getenv('SYSCONFDIR');
    $this->nomos = $sysconf . '/mods-enabled/nomos/agent/nomos';
  }

  function testDiffNomos()
  {
    print "starting NomosFunTest\n";
    $last = exec("find $this->testdir -type f -not \( -wholename \"*svn*\" \) -exec $this->nomos -l '{}' + > scan.out", $out, $rtn);

    $file_correct = dirname(dirname(__FILE__))."/testdata/LastGoodNomosTestfilesScan";
    $last = exec("wc -l < $file_correct");
    $regtest_msg = "Right now, we have $last nomos regression tests\n";
    print $regtest_msg;
    $regtest_cmd = "echo '$regtest_msg' >./nomos-regression-test.html";
    $last = exec($regtest_cmd);
    $old = str_replace('/','\/',dirname(dirname(__FILE__))."/testdata/");
    $last = exec("sed 's/ $old/ /g' ./scan.out > ./scan.out.r");
    $last = exec("sort $file_correct >./LastGoodNomosTestfilesScan.s");
    $last = exec("sort ./scan.out.r >./scan.out.s");
    $last = exec("diff ./LastGoodNomosTestfilesScan.s ./scan.out.s >./report.d", $out, $rtn);
    $count = exec("cat report.d|wc -l", $out, $ret);
    $this->assertEquals($count,'0', "some lines of licenses are different, please view ./report.d for the details!");
  }
}
