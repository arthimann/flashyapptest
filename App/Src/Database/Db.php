<?php

namespace Src\Database;

use Src\Helper\Search;
use Src\Utils\Filesystem;
use Src\Utils\Serializer;
use Src\Utils\Singleton;
use Src\Helper\Parser;

class Db extends Singleton
{
    private array $fileContents;
    private string $fileName;
    private $result = null;
    private $idx = null;
    private $fs = null;

    /**
     * Select which file work with
     * @param string $fileName
     * @return $this
     */
    public function from(string $fileName): self
    {
        $this->fileName = $fileName;
        $this->fs = Filesystem::getInstance();
        $data = Parser::fromJson($this->fs->read($fileName));
        $this->fileContents = $data;
        $this->result = $this->fileContents;
        return $this;
    }

    /**
     * Cast to from method
     * @param string $fileName
     * @return $this
     */
    public function set(string $fileName): self
    {
        return $this->from($fileName);
    }

    /**
     * Cast to from method
     * @param string $fileName
     * @return $this
     */
    public function into(string $fileName): self
    {
        return $this->from($fileName);
    }

    /**
     * Find exact row to work with
     * @param string $colName
     * @param string $value
     * @return $this
     * @throws \Exception
     */
    public function where(string $colName, string $value): self
    {
        $idx = Search::binary($this->fileContents, $colName, $value);
        if (!$idx) {
            throw new \Exception('Record is not found!');
        }
        $this->idx = $idx;
        $this->result = $this->fileContents[$idx];
        return $this;
    }

    /**
     * Retrieve selected data
     * @param mixed ...$params
     * @return array
     */
    public function select(...$params): array
    {
        $result = [];
        if (!empty($params)) {
            foreach ($params as $param) {
                if (isset($this->result[$param])) {
                    $result[$param] = $this->result[$param];
                }
            }
        } else {
            $result = $this->result;
        }
        return $result;
    }

    /**
     * Update key data
     * @param string $key
     * @param string $value
     * @return mixed
     * @throws \Exception
     */
    public function update(string $key, string $value)
    {
        if (!$this->idx) {
            throw new \Exception('where method is missing!');
        }
        $this->result[$key] = $value;
        $this->fileContents[$this->idx] = $this->result;
        return $this->fs->write($this->fileName, Parser::toJson($this->fileContents));
    }

    /**
     * Insert new record
     * @param array $data
     * @return mixed
     */
    public function insert(array $data)
    {
        $entity = new Serializer($data);
        $this->fileContents[] = $entity;
        return $this->fs->write($this->fileName, Parser::toJson($this->fileContents));
    }

    /**
     * Delete record
     * @return mixed
     * @throws \Exception
     */
    public function delete()
    {
        if (!$this->idx) {
            throw new \Exception('where method is missing!');
        }
        array_splice($this->fileContents, $this->idx, 1);
        return $this->fs->write($this->fileName, Parser::toJson($this->fileContents));
    }
}