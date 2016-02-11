<?php
/**
 * Copyright (c) 2013 Gijs Kunze
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GWK\DynamoSessionBundle\Handler;

use Aws\DynamoDb\DynamoDbClient;
use SessionHandlerInterface;

/**
 * Class SessionHandler
 *
 * Proxy class for \Aws\DynamoDb\Session\SessionHandler which implements SessionHandlerInteface
 */
class SessionHandler implements SessionHandlerInterface {

    /**
     * @var \Aws\DynamoDb\DynamoDbClient
     */
    protected $client;

    /**
     * @var \Aws\DynamoDb\Session\SessionHandler
     */
    protected $handler;

    /**
     * @param \Aws\DynamoDb\DynamoDbClient $client
     * @param $config array
     */
    public function __construct(DynamoDbClient $client, array $config) {
        $this->client = $client;

        $config['dynamodb_client'] = $client;
        $this->handler = \Aws\DynamoDb\SessionHandler::fromClient($client, $config);
    }

    /**
     * @return \Aws\DynamoDb\Session\SessionHandler
     */
    public function getHandler() {
        return $this->handler;
    }


    /**
     * Close the session
     * @link http://php.net/manual/en/sessionhandlerinterafce.close.php
     * @return bool
     */
    public function close()
    {
        return $this->handler->close();
    }

    /**
     * Destroy a session
     * @link http://php.net/manual/en/sessionhandlerinterafce.destroy.php
     * @param int $session_id
     * @return bool
     */
    public function destroy($session_id)
    {
        return $this->handler->destroy($session_id);
    }

    /**
     * Cleanup old sessions
     * @link http://php.net/manual/en/sessionhandlerinterafce.gc.php
     * @param int $max_lifetime
     * @return bool
     */
    public function gc($max_lifetime)
    {
        return $this->handler->gc($max_lifetime);
    }

    /**
     * Initialize session
     * @link http://php.net/manual/en/sessionhandlerinterafce.open.php
     * @param string $save_path
     * @param string $session_id
     * @return bool
     */
    public function open($save_path, $session_id)
    {
        return $this->handler->open($save_path, $session_id);
    }

    /**
     * Read session data
     * @link http://php.net/manual/en/sessionhandlerinterafce.read.php
     * @param string $session_id
     * @return string
     */
    public function read($session_id)
    {
        return $this->handler->read($session_id);
    }

    /**
     * Write session data
     * @link http://php.net/manual/en/sessionhandlerinterafce.write.php
     * @param string $session_id
     * @param string $session_data
     * @return bool
     */
    public function write($session_id, $session_data)
    {
        return $this->handler->write($session_id, $session_data);
    }

}
