<?php

namespace WebDriver\Utility;

/**
 * A helper utility for using the 'file' endpoint to create a virtual zip file
 *
 */
class FakeZip
{
    const SIGNATURE_FILE_HEADER = 0x04034b50;
    const SIGNATURE_CD_HEADER   = 0x02014b50;
    const SIGNATURE_EOCD_HEADER = 0x06054b50;

    const COMPRESSION_UNCOMPRESSED  = 0x0;
    const COMPRESSION_DEFLATE       = 0x8;

    /**
     * A list of files added
     *
     * @var array
     */
    private $files = array();

    /**
     * Add files to the array. Currently does not support directories, but then neither does the 'file' endpoint
     *
     * @param string $filename The name of the file to add
     * @param string $alias    Optional. The filename representation in the zip file. Otherwise defaults to the basename
     *
     * @return null
     */
    public function addFile($filename, $alias = null)
    {
        if (!$alias) {
            $alias = basename($filename);
        }

        $this->files[] = [$filename, $alias];
    }

    /**
     * Get the raw binary output of the virtual zip file
     *
     * @param boolean $compress         Whether to compress the files
     * @param integer $compressionLevel The compression level to pass to gzdeflate
     *
     * @return null
     */
    public function getOutput($compress = false, $compressionLevel = -1)
    {
        $data = '';
        $fileStats = array();
        $offset = 0;

        //Add file headers
        foreach ($this->files as $file) {
            list($filename, $alias) = $file;

            if (!is_file($filename)) {
                throw new \Exception("The path '$filename' is not a file");
            }

            $contents = file_get_contents($filename);

            // TODO: research how to do this better
            $crc32 = strrev(hex2bin(hash('crc32b', $contents)));

            $compressedData = $compress ? gzdeflate($contents, $compressionLevel) : $contents;

            $uncompressedSize = strlen($contents);
            $compressedSize = strlen($compressedData);

            //write to $data

            $data .= pack(
                'Vvvvvv',
                self::SIGNATURE_FILE_HEADER,
                20,     //PKZIP minimum version. Usually set to 20
                0,      //Bit flags. Unused
                $compress ? self::COMPRESSION_DEFLATE : self::COMPRESSION_UNCOMPRESSED,
                0,      //MS-DOS mod time. Unused
                0       //MS-DOS mod date. Unused
            );
            $data .= $crc32;
            $data .= pack(
                'VVvv',
                $compressedSize,
                $uncompressedSize,
                strlen($alias), //length of the filename in the zip file
                0               //extra field length. Unused
            );
            $data .= $alias;
            $data .= $compressedData;

            $fileStats [] = array(
                'crc32' => $crc32,
                'compressedSize' => $compressedSize,
                'uncompressedSize' => $uncompressedSize,
                'alias' => $alias,
                'offset' => $offset
            );

            $offset = strlen($data);
        }

        $cdOffset = $offset;
        $cdSize = 0;

        //Add central directory headers
        foreach ($fileStats as $stat) {
            $cd = '';

            $cd .= pack(
                'Vvvvvvv',
                self::SIGNATURE_CD_HEADER,
                20,     //PKZIP version
                20,     //PKZIP minimum version
                0,      //Bit flags. Unused
                $compress ? self::COMPRESSION_DEFLATE : self::COMPRESSION_UNCOMPRESSED,
                0,      //MS-DOS mod time. Unused
                0       //MS-DOS mod date. Unused
            );

            $cd .= $stat['crc32'];

            $cd .= pack(
                'VVvvvvvVV',
                $stat['compressedSize'],
                $stat['uncompressedSize'],
                strlen($stat['alias']), //length of the filename in the zip file
                0,              //extra field length. Unused
                0,              //File comment length. Unused
                0,              //Disk number of file. Should be 1
                0,              //Internal file attributes. Unused
                0,              //External file attributes. Unused
                $stat['offset'] //File offset
            );
            $cd .= $stat['alias'];

            $cdSize += strlen($cd);

            $data .= $cd;
        }

        //Add End-of-Central-Directory header
        $data .= pack(
            'VvvvvVVv',
            self::SIGNATURE_EOCD_HEADER,
            0,  //Disk number. Should only be 1
            0,  //CD Disk number. Should be 1
            count($fileStats),  //number of file entries on current disk. Should be same as below
            count($fileStats),  //number of file entries
            $cdSize,    //total size of the CD
            $cdOffset,  //offset of the CD
            0           //comment size. Unused
        );

        return $data;
    }
}
