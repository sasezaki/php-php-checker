<?php
namespace Teto\PHPChecker;

/**
 * PHP File checker Commandline interface
 *
 * @package   Teto\PHPChecker*
 * @copyright Copyright (c) 2014 USAMI Kenta
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @license   MIT License
 */
class CLI
{
    public function __construct()
    {
    }

    public function exec($subcmd, $param)
    {
        return $this->$subcmd($param);
    }

    public function check_dir(array $params = [])
    {
        $params = $params + [
            'namespace' => '',
            'base_dir'  => '',
        ];

        FileChecker::checkRecursive(new \SplFileInfo($params['base_dir']), $params['namespace'], $params['base_dir']);
    }

    public function check_file(array $params = [])
    {
        $params = $params + [
            'path'      => '',
            'base_dir'  => '',
            'namespace' => '',
        ];

        $path = realpath($params['path']);

        if (empty($path)) {
            throw new \RuntimeException('path error.');
        }

        $options = [
            'base_dir' =>  $params['base_dir'],
            'namespace' => $params['namespace'],
        ];

        $checker = new FileChecker($path, $options);
        $checker->requireNamespace()->hasNClasses(1);
    }
}
