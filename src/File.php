<?php
/**
 * @link https://github.com/linpax/microphp-framework
 * @copyright Copyright &copy; 2013 Oleg Lunegov
 * @license https://github.com/linpax/microphp-framework/blob/master/LICENSE
 */

namespace Micro\Driver\File;

use Micro\Driver\DriverInterface;


class File implements DriverInterface
{

    public function __construct(array $config = [])
    {
        if (!array_key_exists('filename', $config) || !is_writeable($config['filename'])) {
            throw new Exception;
        }

        $this->stream = fopen($config['filename'], 'a+b');
    }

    public function log($level, $message, array $context = array())
    {
        if (!is_resource($this->stream)) {
            throw new Exception;
        }

        fwrite(
            $this->stream,
            '[' . date('Y-m-d H:i:s') . '] ' . ucfirst($level) . ': ' . $message . "\n"
        );
    }

    public function __destruct()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
    }
}