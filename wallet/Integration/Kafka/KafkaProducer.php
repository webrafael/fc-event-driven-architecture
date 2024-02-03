<?php namespace Wallet\Integration\Kafka;

use RdKafka\Conf;
use RdKafka\Producer;
use Wallet\Integration\Events\Exception\InvalidEventException;

class KafkaProducer
{
    protected $port = 29092;
    protected $host = 'kafka';

    protected $producer;

    public function __construct()
    {
        $conf = new Conf;
        $conf->set('debug', 'all');
        $conf->set('metadata.broker.list', "{$this->host}:{$this->port}");

        $conf->setErrorCb(function (Producer $producer, int $errorCode, string $errorMsg) {
            throw new \RuntimeException($errorMsg, $errorCode);
        });

        $this->producer = new Producer($conf);
        $this->producer->addBrokers("{$this->host}:{$this->port}");
        $this->producer->setLogLevel(LOG_DEBUG);
        $this->producer->setLogger(RD_KAFKA_LOG_SYSLOG);
    }

    public function produce($topicName, $message)
    {
        try {
            $topic = $this->producer->newTopic($topicName);
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);

            while ($this->producer->getOutQLen() > 0) {
                $this->producer->flush(1000);
            }
        } catch(\Exception $exc) {
            throw new InvalidEventException($exc->getMessage(), 500);
        }
    }
}
