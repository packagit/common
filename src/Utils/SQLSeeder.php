<?php

namespace Packagit\Common\Utils;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SQLSeeder
{
    /**
     * dir end without '/'.
     *
     * @param string  $dir
     * @param Command $command
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function run($dir, $command)
    {
        foreach (glob($dir . '/data/*.sql') as $f) {

            // remove prefix name like public_, local_ ...
            $tableName = preg_replace('/^.+?_/', '', File::name($f));
            DB::table($tableName)->truncate();

            DB::unprepared(File::get($f));

            $command->line($f);
        }
    }
}
