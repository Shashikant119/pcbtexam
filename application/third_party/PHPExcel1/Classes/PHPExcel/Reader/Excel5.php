<?php

/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
    /**
     * @ignore
     */
    define('PHPEXCEL_ROOT', dirname(__FILE__) . '/../../');
    require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}

/**
 * PHPExcel_Reader_Excel5
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Reader_Excel5
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */

// Original file header of ParseXL (used as the base for this class):
// --------------------------------------------------------------------------------
// Adapted from Excel_Spreadsheet_Reader developed by users bizon153,
// trex005, and mmp11 (SourceForge.net)
// http://sourceforge.net/projects/phpexcelreader/
// Primary changes made by canyoncasa (dvc) for ParseXL 1.00 ...
//     Modelled moreso after Perl Excel Parse/Write modules
//     Added Parse_Excel_Spreadsheet object
//         Reads a whole worksheet or tab as row,column array or as
//         associated hash of indexed rows and named column fields
//     Added variables for worksheet (tab) indexes and names
//     Added an object call for loading individual woorksheets
//     Changed default indexing defaults to 0 based arrays
//     Fixed date/time and percent formats
//     Includes patches found at SourceForge...
//         unicode patch by nobody
//         unpack("d") machine depedency patch by matchy
//         boundsheet utf16 patch by bjaenichen
//     Renamed functions for shorter names
//     General code cleanup and rigor, including <80 column width
//     Included a testcase Excel file and PHP example calls
//     Code works for PHP 5.x

// Primary changes made by canyoncasa (dvc) for ParseXL 1.10 ...
// http://sourceforge.net/tracker/index.php?func=detail&aid=1466964&group_id=99160&atid=623334
//     Decoding of formula conditions, results, and tokens.
//     Support for user-defined named cells added as an array "namedcells"
//         Patch code for user-defined named cells supports single cells only.
//         NOTE: this patch only works for BIFF8 as BIFF5-7 use a different
//         external sheet reference structure
class PHPExcel_Reader_Excel5 extends PHPExcel_Reader_Abstract implements PHPExcel_Reader_IReader
{
    // ParseXL definitions
    const XLS_BIFF8                     = 0x0600;
    const XLS_BIFF7                     = 0x0500;
    const XLS_WorkbookGlobals           = 0x0005;
    const XLS_Worksheet                 = 0x0010;

    // record identifiers
    const XLS_TYPE_FORMULA              = 0x0006;
    const XLS_TYPE_EOF                  = 0x000a;
    const XLS_TYPE_PROTECT              = 0x0012;
    const XLS_TYPE_OBJECTPROTECT        = 0x0063;
    const XLS_TYPE_SCENPROTECT          = 0x00dd;
    const XLS_TYPE_PASSWORD             = 0x0013;
    const XLS_TYPE_HEADER               = 0x0014;
    const XLS_TYPE_FOOTER               = 0x0015;
    const XLS_TYPE_EXTERNSHEET          = 0x0017;
    const XLS_TYPE_DEFINEDNAME          = 0x0018;
    const XLS_TYPE_VERTICALPAGEBREAKS   = 0x001a;
    const XLS_TYPE_HORIZONTALPAGEBREAKS = 0x001b;
    const XLS_TYPE_NOTE                 = 0x001c;
    const XLS_TYPE_SELECTION            = 0x001d;
    const XLS_TYPE_DATEMODE             = 0x0022;
    const XLS_TYPE_EXTERNNAME           = 0x0023;
    const XLS_TYPE_LEFTMARGIN           = 0x0026;
    const XLS_TYPE_RIGHTMARGIN          = 0x0027;
    const XLS_TYPE_TOPMARGIN            = 0x0028;
    const XLS_TYPE_BOTTOMMARGIN         = 0x0029;
    const XLS_TYPE_PRINTGRIDLINES       = 0x002b;
    const XLS_TYPE_FILEPASS             = 0x002f;
    const XLS_TYPE_FONT                 = 0x0031;
    const XLS_TYPE_CONTINUE             = 0x003c;
    const XLS_TYPE_PANE                 = 0x0041;
    const XLS_TYPE_CODEPAGE             = 0x0042;
    const XLS_TYPE_DEFCOLWIDTH          = 0x0055;
    const XLS_TYPE_OBJ                  = 0x005d;
    const XLS_TYPE_COLINFO              = 0x007d;
    const XLS_TYPE_IMDATA               = 0x007f;
    const XLS_TYPE_SHEETPR              = 0x0081;
    const XLS_TYPE_HCENTER              = 0x0083;
    const XLS_TYPE_VCENTER              = 0x0084;
    const XLS_TYPE_SHEET                = 0x0085;
    const XLS_TYPE_PALETTE              = 0x0092;
    const XLS_TYPE_SCL                  = 0x00a0;
    const XLS_TYPE_PAGESETUP            = 0x00a1;
    const XLS_TYPE_MULRK                = 0x00bd;
    const XLS_TYPE_MULBLANK             = 0x00be;
    const XLS_TYPE_DBCELL               = 0x00d7;
    const XLS_TYPE_XF                   = 0x00e0;
    const XLS_TYPE_MERGEDCELLS          = 0x00e5;
    const XLS_TYPE_MSODRAWINGGROUP      = 0x00eb;
    const XLS_TYPE_MSODRAWING           = 0x00ec;
    const XLS_TYPE_SST                  = 0x00fc;
    const XLS_TYPE_LABELSST             = 0x00fd;
    const XLS_TYPE_EXTSST               = 0x00ff;
    const XLS_TYPE_EXTERNALBOOK         = 0x01ae;
    const XLS_TYPE_DATAVALIDATIONS      = 0x01b2;
    const XLS_TYPE_TXO                  = 0x01b6;
    const XLS_TYPE_HYPERLINK            = 0x01b8;
    const XLS_TYPE_DATAVALIDATION       = 0x01be;
    const XLS_TYPE_DIMENSION            = 0x0200;
    const XLS_TYPE_BLANK                = 0x0201;
    const XLS_TYPE_NUMBER               = 0x0203;
    const XLS_TYPE_LABEL                = 0x0204;
    const XLS_TYPE_BOOLERR              = 0x0205;
    const XLS_TYPE_STRING               = 0x0207;
    const XLS_TYPE_ROW                  = 0x0208;
    const XLS_TYPE_INDEX                = 0x020b;
    const XLS_TYPE_ARRAY                = 0x0221;
    const XLS_TYPE_DEFAULTROWHEIGHT     = 0x0225;
    const XLS_TYPE_WINDOW2              = 0x023e;
    const XLS_TYPE_RK                   = 0x027e;
    const XLS_TYPE_STYLE                = 0x0293;
    const XLS_TYPE_FORMAT               = 0x041e;
    const XLS_TYPE_SHAREDFMLA           = 0x04bc;
    const XLS_TYPE_BOF                  = 0x0809;
    const XLS_TYPE_SHEETPROTECTION      = 0x0867;
    const XLS_TYPE_RANGEPROTECTION      = 0x0868;
    const XLS_TYPE_SHEETLAYOUT          = 0x0862;
    const XLS_TYPE_XFEXT                = 0x087d;
    const XLS_TYPE_PAGELAYOUTVIEW       = 0x088b;
    const XLS_TYPE_UNKNOWN              = 0xffff;

    // Encryption type
    const MS_BIFF_CRYPTO_NONE           = 0;
    const MS_BIFF_CRYPTO_XOR            = 1;
    const MS_BIFF_CRYPTO_RC4            = 2;
    
    // Size of stream blocks when using RC4 encryption
    const REKEY_BLOCK                   = 0x400;

    /**
     * Summary Information stream data.
     *
     * @var string
     */
    private $summaryInformation;

    /**
     * Extended Summary Information stream data.
     *
     * @var string
     */
    private $documentSummaryInformation;

    /**
     * User-Defined Properties stream data.
     *
     * @var string
     */
    private $userDefinedProperties;

    /**
     * Workbook stream data. (Includes workbook globals substream as well as sheet substreams)
     *
     * @var string
     */
    private $data;

    /**
     * Size in bytes of $this->data
     *
     * @var int
     */
    private $dataSize;

    /**
     * Current position in stream
     *
     * @var integer
     */
    private $pos;

    /**
     * Workbook to be returned by the reader.
     *
     * @var PHPExcel
     */
    private $phpExcel;

    /**
     * Worksheet that is currently being built by the reader.
     *
     * @var PHPExcel_Worksheet
     */
    private $phpSheet;

    /**
     * BIFF version
     *
     * @var int
     */
    private $version;

    /**
     * Codepage set in the Excel file being read. Only important for BIFF5 (Excel 5.0 - Excel 95)
     * For BIFF8 (Excel 97 - Excel 2003) this will always have the value 'UTF-16LE'
     *
     * @var string
     */
    private $codepage;

    /**
     * Shared formats
     *
     * @var array
     */
    private $formats;

    /**
     * Shared fonts
     *
     * @var array
     */
    private $objFonts;

    /**
     * Color palette
     *
     * @var array
     */
    private $palette;

    /**
     * Worksheets
     *
     * @var array
     */
    private $sheets;

    /**
     * External books
     *
     * @var array
     */
    private $externalBooks;

    /**
     * REF structures. Only applies to BIFF8.
     *
     * @var array
     */
    private $ref;

    /**
     * External names
     *
     * @var array
     */
    private $externalNames;

    /**
     * Defined names
     *
     * @var array
     */
    private $definedname;

    /**
     * Shared strings. Only applies to BIFF8.
     *
     * @var array
     */
    private $sst;

    /**
     * Panes are frozen? (in sheet currently being read). See WINDOW2 record.
     *
     * @var boolean
     */
    private $frozen;

    /**
     * Fit printout to number of pages? (in sheet currently being read). See SHEETPR record.
     *
     * @var boolean
     */
    private $isFitToPages;

    /**
     * Objects. One OBJ record contributes with one entry.
     *
     * @var array
     */
    private $objs;

    /**
     * Text Objects. One TXO record corresponds with one entry.
     *
     * @var array
     */
    private $textObjects;

    /**
     * Cell Annotations (BIFF8)
     *
     * @var array
     */
    private $cellNotes;

    /**
     * The combined MSODRAWINGGROUP data
     *
     * @var string
     */
    private $drawingGroupData;

    /**
     * The combined MSODRAWING data (per sheet)
     *
     * @var string
     */
    private $drawingData;

    /**
     * Keep track of XF index
     *
     * @var int
     */
    private $xfIndex;

    /**
     * Mapping of XF index (that is a cell XF) to final index in cellXf collection
     *
     * @var array
     */
    private $mapCellXfIndex;

    /**
     * Mapping of XF index (that is a style XF) to final index in cellStyleXf collection
     *
     * @var array
     */
    private $mapCellStyleXfIndex;

    /**
     * The shared formulas in a sheet. One SHAREDFMLA record contributes with one value.
     *
     * @var array
     */
    private $sharedFormulas;

    /**
     * The shared formula parts in a sheet. One FORMULA record contributes with one value if it
     * refers to a shared formula.
     *
     * @var array
     */
    private $sharedFormulaParts;

    /**
     * The type of encryption in use
     *
     * @var int
     */
    private $encryption = 0;
    
    /**
     * The position in the stream after which contents are encrypted
     *
     * @var int
     */
    private $encryptionStartPos = false;

    /**
     * The current RC4 decryption object
     *
     * @var PHPExcel_Reader_Excel5_RC4
     */
    private $rc4Key = null;

    /**
     * The position in the stream that the RC4 decryption object was left at
     *
     * @var int
     */
    private $rc4Pos = 0;

    /**
     * The current MD5 context state
     *
     * @var string
     */
    private $md5Ctxt = null;

    /**
     * Create a new PHPExcel_Reader_Excel5 instance
     */
    public function __construct()
    {
        $this->readFilter = new PHPExcel_Reader_DefaultReadFilter();
    }

    /**
     * Can the current PHPExcel_Reader_IReader read the file?
     *
     * @param     string         $pFilename
     * @return     boolean
     * @throws PHPExcel_Reader_Exception
     */
    public function canRead($pFilename)
    {
        // Check if file exists
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        try {
            // Use ParseXL for the hard work.
            $ole = new PHPExcel_Shared_OLERead();

            // get excel data
            $res = $ole->read($pFilename);
            return true;
        } catch (PHPExcel_Exception $e) {
            return false;
        }
    }

    /**
     * Reads names of the worksheets from a file, without parsing the whole file to a PHPExcel object
     *
     * @param     string         $pFilename
     * @throws     PHPExcel_Reader_Exception
     */
    public function listWorksheetNames($pFilename)
    {
        // Check if file exists
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        $worksheetNames = array();

        // Read the OLE file
        $this->loadOLE($pFilename);

        // total byte size of Excel data (workbook global substream + sheet substreams)
        $this->dataSize = strlen($this->data);

        $this->pos        = 0;
        $this->sheets    = array();

        // Parse Workbook Global Substream
        while ($this->pos < $this->dataSize) {
            $code = self::getInt2d($this->data, $this->pos);

            switch ($code) {
                case self::XLS_TYPE_BOF:
                    $this->readBof();
                    break;
                case self::XLS_TYPE_SHEET:
                    $this->readSheet();
                    break;
                case self::XLS_TYPE_EOF:
                    $this->readDefault();
                    break 2;
                default:
                    $this->readDefault();
                    break;
            }
        }

        foreach ($this->sheets as $sheet) {
            if ($sheet['sheetType'] != 0x00) {
                // 0x00: Worksheet, 0x02: Chart, 0x06: Visual Basic module
                continue;
            }

            $worksheetNames[] = $sheet['name'];
        }

        return $worksheetNames;
    }


    /**
     * Return worksheet info (Name, Last Column Letter, Last Column Index, Total Rows, Total Columns)
     *
     * @param   string     $pFilename
     * @throws   PHPExcel_Reader_Exception
     */
    public function listWorksheetInfo($pFilename)
    {
        // Check if file exists
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        $worksheetInfo = array();

        // Read the OLE file
        $this->loadOLE($pFilename);

        // total byte size of Excel data (workbook global substream + sheet substreams)
        $this->dataSize = strlen($this->data);

        // initialize
        $this->pos    = 0;
        $this->sheets = array();

        // Parse Workbook Global Substream
        while ($this->pos < $this->dataSize) {
            $code = self::getInt2d($this->data, $this->pos);

            switch ($code) {
                case self::XLS_TYPE_BOF:
                    $this->readBof();
                    break;
                case self::XLS_TYPE_SHEET:
                    $this->readSheet();
                    break;
                case self::XLS_TYPE_EOF:
                    $this->readDefault();
                    break 2;
                default:
                    $this->readDefault();
                    break;
            }
        }

        // Parse the individual sheets
        foreach ($this->sheets as $sheet) {
            if ($sheet['sheetType'] != 0x00) {
                // 0x00: Worksheet
                // 0x02: Chart
                // 0x06: Visual Basic module
                continue;
            }

            $tmpInfo = array();
            $tmpInfo['worksheetName'] = $sheet['name'];
            $tmpInfo['lastColumnLetter'] = 'A';
            $tmpInfo['lastColumnIndex'] = 0;
            $tmpInfo['totalRows'] = 0;
            $tmpInfo['totalColumns'] = 0;

            $this->pos = $sheet['offset'];

            while ($this->pos <= $this->dataSize - 4) {
                $code = self::getInt2d($this->data, $this->pos);

                switch ($code) {
                    case self::XLS_TYPE_RK:
                    case self::XLS_TYPE_LABELSST:
                    case self::XLS_TYPE_NUMBER:
                    case self::XLS_TYPE_FORMULA:
                    case self::XLS_TYPE_BOOLERR:
                    case self::XLS_TYPE_LABEL:
                        $length = self::getInt2d($this->data, $this->pos + 2);
                        $recordData = $this->readRecordData($this->data, $this->pos + 4, $length);

                        // move stream pointer to next record
                        $this->pos += 4 + $length;

                        $rowIndex = self::getInt2d($recordData, 0) + 1;
                        $columnIndex = self::getInt2d($recordData, 2);

                        $tmpInfo['totalRows'] = max($tmpInfo['totalRows'], $rowIndex);
                        $tmpInfo['lastColumnIndex'] = max($tmpInfo['lastColumnIndex'], $columnIndex);
                        break;
                    case self::XLS_TYPE_BOF:
                        $this->readBof();
                        break;
                    case self::XLS_TYPE_EOF:
                        $this->readDefault();
                        break 2;
                    default:
                        $this->readDefault();
                        break;
                }
            }

            $tmpInfo['lastColumnLetter'] = PHPExcel_Cell::stringFromColumnIndex($tmpInfo['lastColumnIndex']);
            $tmpInfo['totalColumns'] = $tmpInfo['lastColumnIndex'] + 1;

            $worksheetInfo[] = $tmpInfo;
        }

        return $worksheetInfo;
    }


    /**
     * Loads PHPExcel from file
     *
     * @param     string         $pFilename
     * @return     PHPExcel
     * @throws     PHPExcel_Reader_Exception
     */
    public function load($pFilename)
    {
        // Read the OLE file
        $this->loadOLE($pFilename);

        // Initialisations
        $this->phpExcel = new PHPExcel;
        $this->phpExcel->removeSheetByIndex(0); // remove 1st sheet
        if (!$this->readDataOnly) {
            $this->phpExcel->removeCellStyleXfByIndex(0); // remove the default style
            $this->phpExcel->removeCellXfByIndex(0); // remove the default style
        }

        // Read the summary information stream (containing meta data)
        $this->readSummaryInformation();

        // Read the Additional document summary information stream (containing application-specific meta data)
        $this->readDocumentSummaryInformation();

        // total byte size of Excel data (workbook global substream + sheet substreams)
        $this->dataSize = strlen($this->data);

        // initialize
        $this->pos                 = 0;
        $this->codepage            = 'CP1252';
        $this->formats             = array();
        $this->objFonts            = array();
        $this->palette             = array();
        $this->sheets              = array();
        $this->externalBooks       = array();
        $this->ref                 = array();
        $this->definedname         = array();
        $this->sst                 = array();
        $this->drawingGroupData    = '';
        $this->xfIndex             = '';
        $this->mapCellXfIndex      = array();
        $this->mapCellStyleXfIndex = array();

        // Parse Workbook Global Substream
        while ($this->pos < $this->dataSize) {
            $code = self::getInt2d($this->data, $this->pos);

            switch ($code) {
                case self::XLS_TYPE_BOF:
                    $this->readBof();
                    break;
                case self::XLS_TYPE_FILEPASS:
                    $this->readFilepass();
                    break;
                case self::XLS_TYPE_CODEPAGE:
                    $this->readCodepage();
                    break;
                case self::XLS_TYPE_DATEMODE:
                    $this->readDateMode();
                    break;
                case self::XLS_TYPE_FONT:
                    $this->readFont();
                    break;
                case self::XLS_TYPE_FORMAT:
                    $this->readFormat();
                    break;
                case self::XLS_TYPE_XF:
                    $this->readXf();
                    break;
                case self::XLS_TYPE_XFEXT:
                    $this->readXfExt();
                    break;
                case self::XLS_TYPE_STYLE:
                    $this->readStyle();
                    break;
                case self::XLS_TYPE_PALETTE:
                    $this->readPalette();
                    break;
                case self::XLS_TYPE_SHEET:
                    $this->readSheet();
                    break;
                case self::XLS_TYPE_EXTERNALBOOK:
                    $this->readExternalBook();
                    break;
                case self::XLS_TYPE_EXTERNNAME:
                    $this->readExternName();
                    break;
                case self::XLS_TYPE_EXTERNSHEET:
                    $this->readExternSheet();
                    break;
                case self::XLS_TYPE_DEFINEDNAME:
                    $this->readDefinedName();
                    break;
                case self::XLS_TYPE_MSODRAWINGGROUP:
                    $this->readMsoDrawingGroup();
                    break;
                case self::XLS_TYPE_SST:
                    $this->readSst();
                    break;
                case self::XLS_TYPE_EOF:
                    $this->readDefault();
                    break 2;
                default:
                    $this->readDefault();
                    break;
            }
        }

        // Resolve indexed colors for font, fill, and border colors
        // Cannot be resolved already in XF record, because PALETTE record comes afterwards
        if (!$this->readDataOnly) {
            foreach ($this->objFonts as $objFont) {
                if (isset($objFont->colorIndex)) {
                    $color = PHPExcel_Reader_Excel5_Color::map($objFont->colorIndex, $this->palette, $this->version);
                    $objFont->getColor()->setRGB($color['rgb']);
                }
            }

            foreach ($this->phpExcel->getCellXfCollection() as $objStyle) {
                // fill start and end color
                $fill = $objStyle->getFill();

                if (isset($fill->startcolorIndex)) {
                    $startColor = PHPExcel_Reader_Excel5_Color::map($fill->startcolorIndex, $this->palette, $this->version);
                    $fill->getStartColor()->setRGB($startColor['rgb']);
                }
                if (isset($fill->endcolorIndex)) {
                    $endColor = PHPExcel_Reader_Excel5_Color::map($fill->endcolorIndex, $this->palette, $this->version);
                    $fill->getEndColor()->setRGB($endColor['rgb']);
                }

                // border colors
                $top      = $objStyle->getBorders()->getTop();
                $right    = $objStyle->getBorders()->getRight();
                $bottom   = $objStyle->getBorders()->getBottom();
                $left     = $objStyle->getBorders()->getLeft();
                $diagonal = $objStyle->getBorders()->getDiagonal();

                if (isset($top->colorIndex)) {
                    $borderTopColor = PHPExcel_Reader_Excel5_Color::map($top->colorIndex, $this->palette, $this->version);
                    $top->getColor()->setRGB($borderTopColor['rgb']);
                }
                if (isset($right->colorIndex)) {
                    $borderRightColor = PHPExcel_Reader_Excel5_Color::map($right->colorIndex, $this->palette, $this->version);
                    $right->getColor()->setRGB($borderRightColor['rgb']);
                }
                if (isset($bottom->colorIndex)) {
                    $borderBottomColor = PHPExcel_Reader_Excel5_Color::map($bottom->colorIndex, $this->palette, $this->version);
                    $bottom->getColor()->setRGB($borderBottomColor['rgb']);
                }
                if (isset($left->colorIndex)) {
                    $borderLeftColor = PHPExcel_Reader_Excel5_Color::map($left->colorIndex, $this->palette, $this->version);
                    $left->getColor()->setRGB($borderLeftColor['rgb']);
                }
                if (isset($diagonal->colorIndex)) {
                    $borderDiagonalColor = PHPExcel_Reader_Excel5_Color::map($diagonal->colorIndex, $this->palette, $this->version);
                    $diagonal->getColor()->setRGB($borderDiagonalColor['rgb']);
                }
            }
        }

        // treat MSODRAWINGGROUP records, workbook-level Escher
        if (!$this->readDataOnly && $this->drawingGroupData) {
            $escherWorkbook = new PHPExcel_Shared_Escher();
            $reader = new PHPExcel_Reader_Excel5_Escher($escherWorkbook);
            $escherWorkbook = $reader->load($this->drawingGroupData);

            // debug Escher stream
            //$debug = new Debug_Escher(new PHPExcel_Shared_Escher());
            //$debug->load($this->drawingGroupData);
        }

        // Parse the individual sheets
        foreach ($this->sheets as $sheet) {
            if ($sheet['sheetType'] != 0x00) {
                // 0x00: Worksheet, 0x02: Chart, 0x06: Visual Basic module
                continue;
            }

            // check if sheet should be skipped
            if (isset($this->loadSheetsOnly) && !in_array($sheet['name'], $this->loadSheetsOnly)) {
                continue;
            }

            // add sheet to PHPExcel object
            $this->phpSheet = $this->phpExcel->createSheet();
            //    Use false for $updateFormulaCellReferences to prevent adjustment of worksheet references in formula
            //        cells... during the load, all formulae should be correct, and we're simply bringing the worksheet
            //        name in line with the formula, not the reverse
            $this->phpSheet->setTitle($sheet['name'], false);
            $this->phpSheet->setSheetState($sheet['sheetState']);

            $this->pos = $sheet['offset'];

            // Initialize isFitToPages. May change after reading SHEETPR record.
            $this->isFitToPages = false;

            // Initialize drawingData
            $this->drawingData = '';

            // Initialize objs
            $this->objs = array();

            // Initialize shared formula parts
            $this->sharedFormulaParts = array();

            // Initialize shared formulas
            $this->sharedFormulas = array();

            // Initialize text objs
            $this->textObjects = array();

            // Initialize cell annotations
            $this->cellNotes = array();
            $this->textObjRef = -1;

            while ($this->pos <= $this->dataSize - 4) {
                $code = self::getInt2d($this->data, $this->pos);

                switch ($code) {
                    case self::XLS_TYPE_BOF:
                        $this->readBof();
                        break;
                    case self::XLS_TYPE_PRINTGRIDLINES:
                        $this->readPrintGridlines();
                        break;
                    case self::XLS_TYPE_DEFAULTROWHEIGHT:
                        $this->readDefaultRowHeight();
                        break;
                    case self::XLS_TYPE_SHEETPR:
                        $this->readSheetPr();
                        break;
                    case self::XLS_TYPE_HORIZONTALPAGEBREAKS:
                        $this->readHorizontalPageBreaks();
                        break;
                    case self::XLS_TYPE_VERTICALPAGEBREAKS:
                        $this->readVerticalPageBreaks();
                        break;
                    case self::XLS_TYPE_HEADER:
                        $this->readHeader();
                        break;
                    case self::XLS_TYPE_FOOTER:
                        $this->readFooter();
                        break;
                    case self::XLS_TYPE_HCENTER:
                        $this->readHcenter();
                        break;
                    case self::XLS_TYPE_VCENTER:
                        $this->readVcenter();
                        break;
                    case self::XLS_TYPE_LEFTMARGIN:
                        $this->readLeftMargin();
                        break;
                    case self::XLS_TYPE_RIGHTMARGIN:
                        $this->readRightMargin();
                        break;
                    case self::XLS_TYPE_TOPMARGIN:
                        $this->readTopMargin();
                        break;
                    case self::XLS_TYPE_BOTTOMMARGIN:
                        $this->readBottomMargin();
                        break;
                    case self::XLS_TYPE_PAGESETUP:
                        $this->readPageSetup();
                        break;
                    case self::XLS_TYPE_PROTECT:
                        $this->readProtect();
                        break;
                    case self::XLS_TYPE_SCENPROTECT:
                        $this->readScenProtect();
                        break;
                    case self::XLS_TYPE_OBJECTPROTECT:
                        $this->readObjectProtect();
                        break;
                    case self::XLS_TYPE_PASSWORD:
                        $this->readPassword();
                        break;
                    case self::XLS_TYPE_DEFCOLWIDTH:
                        $this->readDefColWidth();
                        break;
                    case self::XLS_TYPE_COLINFO:
                        $this->readColInfo();
                        break;
                    case self::XLS_TYPE_DIMENSION:
                        $this->readDefault();
                        break;
                    case self::XLS_TYPE_ROW:
                        $this->readRow();
                        break;
                    case self::XLS_TYPE_DBCELL:
                        $this->readDefault();
                        break;
                    case self::XLS_TYPE_RK:
                        $this->readRk();
                        break;
                    case self::XLS_TYPE_LABELSST:
                        $this->readLabelSst();
                        break;
                    case self::XLS_TYPE_MULRK:
                        $this->readMulRk();
                        break;
                    case self::XLS_TYPE_NUMBER:
                        $this->readNumber();
                        break;
                    case self::XLS_TYPE_FORMULA:
                        $this->readFormula();
                        break;
                    case self::XLS_TYPE_SHAREDFMLA:
                        $this->readSharedFmla();
                        break;
                    case self::XLS_TYPE_BOOLERR:
                        $this->readBoolErr();
                        break;
                    case self::XLS_TYPE_MULBLANK:
                        $this->readMulBlank();
                        break;
                    case self::XLS_TYPE_LABEL:
                        $this->readLabel();
                        break;
                    case self::XLS_TYPE_BLANK:
            