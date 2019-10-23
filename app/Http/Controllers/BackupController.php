<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Backup\MysqlDump;

class BackupController extends Controller
{
    public function backup()
    {
        MysqlDump::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->setCreateTable(false)
            ->dumpToFile('backup/dump.sql');
        return \Illuminate\Support\Facades\Response::download(public_path('/backup/dump.sql'), 'dump.sql');
    }
}
