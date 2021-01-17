<?php

declare(strict_types=1);
namespace App\Helpers\File;

use IteratorAggregate;
use SplFileObject;
use Traversable;

/**
 * "Lazily" load a CSV file.
 *
 * Opens a CSV file and allows iteration over the file line-by-line. Can optionally use first row
 * as headers which the yielded row will be keyed by.
 *
 * @author Linus Sörensen <sorensen.linus@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class LazyCSVFile implements IteratorAggregate
{
    /**
     * @var resource|null
     */
    protected $file;

    /**
     * @var bool
     */
    protected $withHeaders;

    /**
     * @var array
     */
    protected $headers;

    public function __construct(string $path, string $openMode = 'r', string $delimiter = ',',
        string $enclosure = '"', string $escape = '\\', bool $withHeaders = true, ?int $flags = null)
    {
        $this->file = new SplFileObject($path, $openMode);

        $this->file->setCsvControl($delimiter, $enclosure, $escape);

        $this->withHeaders = $withHeaders;

        if ($this->withHeaders) {
            $this->headers = $this->file->fgetcsv();
        } else {
            $this->headers = [];
        }

        if (is_int($flags)) {
            $this->file->setFlags($flags);
        } else {
            $this->file->setFlags(
                SplFileObject::READ_CSV |
                SplFileObject::SKIP_EMPTY |
                SplFileObject::READ_AHEAD
            );
        }
    }

    public function __destruct()
    {
        $this->file = null;
    }

    public function rewind(): void
    {
        if ($this->file) {
            $this->file->rewind();

            if ($this->withHeaders) {
                $this->file->fgetcsv(); // Skips first line
            }
        }
    }

    public function getIterator(): Traversable
    {
        return (function () {
            while ($row = $this->file->fgetcsv()) {
                if ($this->withHeaders) {
                    if (count($row) != count($this->headers)) {
                        continue;
                    }

                    yield array_combine($this->headers, $row);
                } else {
                    yield $row;
                }
            }
        })();
    }

    /**
     * @return resource|null
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
