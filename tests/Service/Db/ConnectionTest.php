<?php

namespace tests\Service\Db;


use App\Service\Db\Connection;
use App\Service\Db\DatabaseConnectionException;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    public function testBadCredentials(){
        $this->expectException(\PDOException::class);
        $con = new Connection();
        $con->init("pgsql:host=localhost;dbname=testdb;","luxfero1","password");
    }

    public function testAlreadyInitializedConnection(){
        $this->expectException(DatabaseConnectionException::class);
        $con = new Connection();
        $con->init("pgsql:host=localhost;dbname=testdb;","luxfero","password");
        $con->init("pgsql:host=localhost;dbname=testdb;","luxfero","password");
    }

    public function testNotInitializedConnection(){
        $this->expectException(DatabaseConnectionException::class);
        $con = new Connection();
        $con->getConnection();
    }
}