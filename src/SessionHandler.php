<?php
namespace Thru\Session;

class SessionHandler implements \SessionHandlerInterface
{

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
        /* @var $session SessionModel */
        $session = SessionModel::search()->where('php_id', $id)->where('deleted', 'No')->execOne();
        if (!$session instanceof SessionModel) {
            $session = new SessionModel();
        }
        if ($session->data) {
            return unserialize($session->data);
        } else {
            return false;
        }
    }

    public function write($id, $data)
    {
        /* @var $session SessionModel */
        $session = SessionModel::search()->where('php_id', $id)->where('deleted', 'No')->execOne();
        if (!$session instanceof SessionModel) {
            $session = new SessionModel();
        }
        $session->php_id = $id;
        $session->data = serialize($data);
        $session->save();
        return true;
    }

    public function destroy($id)
    {
        /* @var $session SessionModel */
        $session = SessionModel::search()->where('php_id', $id)->where('deleted', 'No')->execOne();
        $session->delete();
        return true;
    }

    public function gc($maxlifetime)
    {
        $created = date("Y-m-d H:i:s", time() - $maxlifetime);
        foreach (SessionModel::search()->where('created', $created, '<')->where('deleted', 'No')->exec() as $session) {
            /* @var $session SessionModel */
            $session->delete();
        }
        return true;
    }
}
