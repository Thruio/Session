<?php
namespace Thru\Session;

use \Predis\Client as RedisClient;

class RedisSessionHandler implements \SessionHandlerInterface
{

    /** @var RedisClient */
    private $redis;

    private $keyLifeTime = 86400;

    public function __construct(RedisClient $redis, $keyLifeTime = 86400)
    {
        $this->redis = $redis;
        $this->keyLifeTime = $keyLifeTime;
    }

    public function open($savePath, $sessionName)
    {
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($id)
    {
        $serialised = $this->redis->get("session_{$id}");
        if($serialised != null){
            $this->redis->expire("session_{$id}", $this->keyLifeTime);
            return unserialize($serialised);
        }else{
            return false;
        }
    }

    public function write($id, $data)
    {
        $this->redis->set("session_{$id}", serialize($data));
        $this->redis->expire("session_{$id}", $this->keyLifeTime);
        return true;
    }

    public function destroy($id)
    {
        $this->redis->del("session_{$id}");
    }

    public function gc($maxlifetime)
    {
        return true;
    }
}
